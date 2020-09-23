jQuery(document).ready(function($){
	//final width --> this is the quick view image slider width
	//maxQuickWidth --> this is the max-width of the quick-view panel
	var sliderFinalWidth = 600,
		maxQuickWidth = 1170;

	//open the quick view panel
	$('.trend-trigger').on('click', function(event){
		var selectedImage = $(this).parent().parent().parent().find('.selected img');
			$(this).addClass('clicked');
			slectedImageUrl = selectedImage.attr('src');

			$('.portfolio-overlay').addClass('overlay-layer');
		animateQuickView(selectedImage, sliderFinalWidth, maxQuickWidth, 'open');

		//update the visible slider image in the quick view panel
		//you don't need to implement/use the updateQuickView if retrieving the quick view data with ajax
		//updateQuickView(slectedImageUrl);
	});

	//close the quick view panel
	$('.portfolio-overlay').on('click', function(event){
		//if( $(event.target).is('.trend-close i') || $(event.target).is('.portfolio-overlay.overlay-layer')) {
			//closeQuickView( sliderFinalWidth, maxQuickWidth);
			$('.portfolio-overlay').removeClass('overlay-layer');
			$('.trend-quick-view').removeClass('is-visible');
			$('.trend-quick-view').removeClass('animate-width');
			$('.trend-quick-view').removeClass('add-content');
		//}
	});
	$('.trend-close i').on('click', function(event){
		//if( $(event.target).is('.trend-close i') || $(event.target).is('.portfolio-overlay.overlay-layer')) {
			$('.portfolio-overlay').removeClass('overlay-layer');
			$('.trend-quick-view').removeClass('is-visible');
			$('.trend-quick-view').removeClass('animate-width');
			$('.trend-quick-view').removeClass('add-content');
		//}
	});
	$(document).keyup(function(event){
		//check if user has pressed 'Esc'
    	if(event.which=='27'){
			//closeQuickView( sliderFinalWidth, maxQuickWidth);
			$('.portfolio-overlay.overlay-layer').removeClass('.overlay-layer');
			$('.trend-quick-view').removeClass('.is-visible');
			$('.trend-quick-view').removeClass('.animate-width');
			$('.trend-quick-view').removeClass('.add-content');
		}
	});

	//quick view slider implementation
	$('.trend-quick-view').on('click', '.trend-slider-navigation a', function(){
		updateSlider($(this));
	});

	//center quick-view on window resize
	$(window).on('resize', function(){
		if($('.trend-quick-view').hasClass('is-visible')){
			window.requestAnimationFrame(resizeQuickView);
		}
	});

	function updateSlider(navigation) {
		var sliderConatiner = navigation.parents('.trend-slider-wrapper').find('.trend-slider'),
			activeSlider = sliderConatiner.children('.selected').removeClass('selected');
		if ( navigation.hasClass('trend-next') ) {
			( !activeSlider.is(':last-child') ) ? activeSlider.next().addClass('selected') : sliderConatiner.children('li').eq(0).addClass('selected'); 
		} else {
			( !activeSlider.is(':first-child') ) ? activeSlider.prev().addClass('selected') : sliderConatiner.children('li').last().addClass('selected');
		} 
	}

	function updateQuickView(url) {
		$('.trend-quick-view .trend-slider li').removeClass('selected').find('img[src="'+ url +'"]').parent('li').addClass('selected');
	}

	function resizeQuickView() {
		var quickViewLeft = ($(window).width() - $('.trend-quick-view').width())/2,
			quickViewTop = ($(window).height() - $('.trend-quick-view').height())/2;
		$('.trend-quick-view').css({
		    "top": quickViewTop,
		    "left": quickViewLeft,
		});
	} 

	// function closeQuickView(finalWidth, maxQuickWidth) {
	// 	var close = $('.trend-close i'),
	// 		activeSliderUrl = close.siblings('.trend-slider-wrapper').find('.selected img').attr('src'),
	// 		selectedImage = $('.empty-box').find('img');
	// 	//update the image in the gallery
	// 	if( !$('.trend-quick-view').hasClass('velocity-animating') && $('.trend-quick-view').hasClass('add-content')) {
	// 		selectedImage.attr('src', activeSliderUrl);
	// 		animateQuickView(selectedImage, finalWidth, maxQuickWidth, 'close');
	// 	} else {
	// 		closeNoAnimation(selectedImage, finalWidth, maxQuickWidth);
	// 	}
	// }

	function animateQuickView(image, finalWidth, maxQuickWidth, animationType) {
		//store some image data (width, top position, ...)
		//store window data to calculate quick view panel position
		var parentListItem = image.parent('.trend-item'),
			topSelected = image.offset().top - $(window).scrollTop(),
			leftSelected = image.offset().left,
			widthSelected = image.width(),
			heightSelected = image.height(),
			windowWidth = $(window).width(),
			windowHeight = $(window).height(),
			finalLeft = (windowWidth - finalWidth)/2,
			finalHeight = finalWidth * heightSelected/widthSelected,
			finalTop = (windowHeight - finalHeight)/2,
			quickViewWidth = ( windowWidth * .8 < maxQuickWidth ) ? windowWidth * .8 : maxQuickWidth ,
			quickViewLeft = (windowWidth - quickViewWidth)/2;

		if( animationType == 'open') {
			//hide the image in the gallery
			parentListItem.addClass('empty-box');
			//place the quick view over the image gallery and give it the dimension of the gallery image
			var currenntQuickView = jQuery('.trend-trigger.clicked').parent().parent().parent().find('.trend-quick-view');
			$(currenntQuickView).css({
			    "top": topSelected,
			    "left": leftSelected,
			    "width": widthSelected,
			}).velocity({
				//animate the quick view: animate its width and center it in the viewport
				//during this animation, only the slider image is visible
			    'top': finalTop+ 'px',
			    'left': finalLeft+'px',
			    'width': finalWidth+'px',
			}, 1000, [ 400, 20 ], function(){
				//animate the quick view: animate its width to the final value

				var currenntQuickView = jQuery('.trend-trigger.clicked').parent().parent().parent().find('.trend-quick-view');
				//console.log(currenntQuickView);

				$(currenntQuickView).addClass('animate-width').velocity({
					'left': quickViewLeft+'px',
			    	'width': quickViewWidth+'px',
				}, 300, 'ease' ,function(){
					//show quick view content
					var currenntQuickView = jQuery('.trend-trigger.clicked').parent().parent().parent().find('.trend-quick-view');
					$(currenntQuickView).addClass('add-content');
				});
			}).addClass('is-visible');
		} else {
			//close the quick view reverting the animation
			$('.trend-quick-view').removeClass('add-content').velocity({
			    'top': finalTop+ 'px',
			    'left': finalLeft+'px',
			    'width': finalWidth+'px',
			}, 300, 'ease', function(){
				$('.portfolio-overlay').removeClass('overlay-layer');
				$('.trend-quick-view').removeClass('animate-width').velocity({
					"top": topSelected,
				    "left": leftSelected,
				    "width": widthSelected,
				}, 500, 'ease', function(){
					$('.trend-quick-view').removeClass('is-visible');
					$('.trend-trigger').removeClass('clicked');
					parentListItem.removeClass('empty-box');
				});
			});
		}
	}
	function closeNoAnimation(image, finalWidth, maxQuickWidth) {
		var parentListItem = image.parent('.trend-item'),
			topSelected = image.offset().top - $(window).scrollTop(),
			leftSelected = image.offset().left,
			widthSelected = image.width();

		//close the quick view reverting the animation
		$('.portfolio-overlay').removeClass('overlay-layer');
		parentListItem.removeClass('empty-box');
		$('.trend-quick-view').velocity("stop").removeClass('add-content animate-width is-visible').css({
			"top": topSelected,
		    "left": leftSelected,
		    "width": widthSelected,
		});
	}
});