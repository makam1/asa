/*
 Project name:       TREND
 Project author:     ModelTheme
 File name:          Custom JS
*/

(function ($) {
    'use strict';
    





    if (typeof(Ecwid) == 'object') {
        Ecwid.OnPageLoaded.add( // an Ecwid JS API call
          function(page) { // this is anonymous function constructed right in place, but you use the named functions as well
            // alert('This code runs each time when a page is open inside an Ecwid product browser');
            if (jQuery('.ecwid-SearchPanel-field').length){  
                jQuery('.ecwid-SearchPanel-field').attr('placeholder', 'Enter your search term');
            }
            if (jQuery('html#ecwid_html body#ecwid_body div.ecwid-Orders-SearchPanel input.gwt-TextBox').length){  
                jQuery('html#ecwid_html body#ecwid_body div.ecwid-Orders-SearchPanel input.gwt-TextBox').attr('placeholder', 'Enter keyword');
            }

            jQuery( "html#ecwid_html body#ecwid_body .ecwid-productBrowser-productsGrid-v2 div.ecwid-productBrowser-productsGrid-productBottomFragment div.ecwid-BuyNow" ).on("hover",function() {
                jQuery( '.ecwid-productBrowser-productsGrid-productTopFragment-inner .ecwid-imgLoaded' ).toggleClass( 'is-hover' );
                console.log('Class: is-hover - added');
                console.log('Class: is-hover - added');
            });

            jQuery( '.ecwid-productBrowser-productsGrid-cell' ).attr( "class", function( i, val ) {
              return val;
            });

            
          }
        );
    }




    $(document).ready(function() {

        if (jQuery(window).width() < 760) {
            jQuery('.menu-item-has-children').on("click",function() {
                jQuery(this).find('.sub-menu').first('.sub-menu').toggle('shown');
                jQuery('.sub-menu.shown').removeClass('.shown');
            });
        }
        
        //Begin: MailChimp JS
        jQuery('.subscribe').ketchup().on("submit",function(evt) {
            evt.preventDefault();
            if (jQuery(this).ketchup('isValid')) {
                var action = jQuery(this).attr('action');

                jQuery.ajax({
                    url: action,
                    type: 'POST',
                    data: {
                        email: jQuery('.emaddress').val()
                    },
                    success: function(data){
                        jQuery('.result').html('Got it, you\'ve been added to our email list.').css('color', '#35cf76');
                    },
                    error: function() {
                        jQuery('.result').html('Sorry, an error occurred.').css('color', '#e74c3c');
                    }
                });
            }else{
                jQuery('.result').html('Please enter an valid email address.').css('color', '#e74c3c');
            }
            return false;
        });
        //End: MailChimp JS
        

        //Begin: Validate and Submit contact form via Ajax
        jQuery("#contact_form").validate({
            //Ajax validation rules
            rules: {
                user_name: {
                    required: true,
                    minlength: 2
                },
                user_message: {
                    required: true,
                    minlength: 10
                },
                user_subject: {
                    required: true,
                    minlength: 5
                },
                user_email: {
                    required: true,
                    email: true
                }
            },
            //Ajax validation messages
            messages: {
                user_name: {
                    required: "Please enter a name",
                    minlength: "Your name must consist of at least 2 characters"
                },
                user_message: {
                    required: "Please enter a message",
                    minlength: "Your message must consist of at least 10 characters"
                },
                user_subject: {
                    required: "Please provide a subject",
                    minlength: "Your subject must be at least 5 characters long"
                },
                user_email: "Please enter a valid email address"
            },
            //Submit via Ajax Form
            submitHandler: function() {
                jQuery('#contact_form').ajaxSubmit();
                jQuery('.success_message').fadeIn('slow');
            }
        });
        //End: Validate and Submit contact form via Ajax


        //Begin: Sticky Head

        jQuery(function(){
           if (jQuery('body').hasClass('is_nav_sticky')) {
                // console.log('Enabled - is_nav_sticky');

                jQuery(window).resize(function() {
                    if (jQuery(window).width() <= 768) {
                    // console.log('smaller-than-767');
                    } else {
                        // console.log('bigger-than-767');
                        // console.log('Start STICKY');
                        jQuery("#trend-main-head").sticky({
                            topSpacing:0
                        });
                    }
                });

                if (jQuery(window).width() >= 768) {
                    // console.log('=>768 Start STICKY');
                    jQuery("#trend-main-head").sticky({
                        topSpacing:0
                    });
                }
           }
        });



        //End: Sticky Head
        jQuery(document).on('mouseenter','.shop_cart',function(event) {
            /* Stuff to do when the mouse enters the element */
            jQuery('.header_mini_cart').addClass('visible_cart');
         }).on('mouseleave','.shop_cart',  function(){
            /* Stuff to do when the mouse leaves the element */
            jQuery('.header_mini_cart').removeClass('visible_cart');
        });



        jQuery(document).on('mouseenter','.header_mini_cart',function(event) {
            /* Stuff to do when the mouse enters the element */
            jQuery(this).addClass('visible_cart');
         }).on('mouseleave','.header_mini_cart',  function(){
            /* Stuff to do when the mouse leaves the element */
            jQuery(this).removeClass('visible_cart');
        });


        if ( jQuery( ".woocommerce_categories" ).length ) {
            
            jQuery(".category a").on("click",function () {
                var attr = jQuery(this).attr("class");

                jQuery(".products_by_category").removeClass("active");
                jQuery(attr).addClass("active");

                jQuery('.category').removeClass("active");
                jQuery(this).parent('.category').addClass("active");

            });  

            jQuery('.products_category .products_by_category:first').addClass("active");
            jQuery('.categories_shortcode .category:first').addClass("active");

        }


        //Begin: Search Form
        if ( jQuery( "#trend-search" ).length ) {
            new UISearch( document.getElementById( 'trend-search' ) );
        }
        //End: Search Form


        //Begin: Flat icons

        if (jQuery('body[class*=skin_]').length){
            var skin_color       = jQuery('body[class*=skin_]').attr('class').split(' ');
            var skin_color_class = skin_color.filter(  function(elem){ return elem.match(/skin_*/) } ).join('');
            var skin_color_hexa  = skin_color_class.replace("skin_", "#");

            jQuery(".flat-icon").flatshadow({
              fade: false,
              color: skin_color_hexa,
              boxShadow: "#00ADF1"
            });
        }
        //End: Flat icons


        //Begin: Parallax
        jQuery('.parralax-background').parallax("50%", 0.5);
        //End: Parallax


        /*Begin: Testimonials slider*/
        jQuery(".testimonials-container").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   2],
                [700,   2],
                [1000,  2],
                [1200,  2],
                [1400,  2],
                [1600,  2]
            ]
        });
        jQuery(".testimonials-container-1").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   1],
                [700,   1],
                [1000,  1],
                [1200,  1],
                [1400,  1],
                [1600,  1]
            ]
        });
        jQuery(".testimonials-container-2").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   2],
                [700,   2],
                [1000,  2],
                [1200,  2],
                [1400,  2],
                [1600,  2]
            ]
        });
        jQuery(".testimonials-container-3").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   2],
                [700,   2],
                [1000,  3],
                [1200,  3],
                [1400,  3],
                [1600,  3]
            ]
        });
        /*End: Testimonials slider*/


        /*Begin: Clients slider*/
        jQuery(".categories_shortcode").owlCarousel({
            navigation      : true, // Show next and prev buttons
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            navigationText  : ["<i class='fa fa-arrow-left'></i>","<i class='fa fa-arrow-right'></i>"],
            itemsCustom : [
                [0,     1],
                [450,   2],
                [600,   2],
                [700,   5],
                [1000,  5],
                [1200,  5],
                [1400,  5],
                [1600,  5]
            ]
        });

        /*Begin: Products by category*/
        jQuery(".clients-container").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   2],
                [600,   2],
                [700,   3],
                [1000,  5],
                [1200,  5],
                [1400,  5],
                [1600,  5]
            ]
        });

        /*Begin: Portfolio single slider*/
        jQuery(".portfolio_thumbnails_slider").owlCarousel({
            navigation      : true, // Show next and prev buttons
            pagination      : true,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            navigationText  : ["",""],
            singleItem      : true
        });
        /*End: Portfolio single slider*/

        /*Begin: Testimonials slider*/
        jQuery(".post_thumbnails_slider").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            singleItem      : true
        });
        var owl = jQuery(".post_thumbnails_slider");
        jQuery(".next").on("click",function(){
            owl.trigger('owl.next');
        })
        jQuery(".prev").on("click",function(){
            owl.trigger('owl.prev');
        })
        /*End: Testimonials slider*/
        
        /*Begin: Testimonials slider*/
        jQuery(".testimonials_slider").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : true,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            singleItem      : true
        });
        /*End: Testimonials slider*/

        /* Animate */
        jQuery('.animateIn').animateIn();

        // browser window scroll (in pixels) after which the "back to top" link is shown
        var offset = 300,
            //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
            offset_opacity = 1200,
            //duration of the top scrolling animation (in ms)
            scroll_top_duration = 700,
            //grab the "back to top" link
            $back_to_top = jQuery('.back-to-top');

        //hide or show the "back to top" link
        jQuery(window).scroll(function(){
            ( jQuery(this).scrollTop() > offset ) ? $back_to_top.addClass('trend-is-visible') : $back_to_top.removeClass('trend-is-visible trend-fade-out');
            if( jQuery(this).scrollTop() > offset_opacity ) { 
                $back_to_top.addClass('trend-fade-out');
            }
        });

        //smooth scroll to top
        $back_to_top.on('click', function(event){
            event.preventDefault();
            $('body,html').animate({
                scrollTop: 0 ,
                }, scroll_top_duration
            );
        });

        //Begin: Skills
        jQuery('.statistics').appear(function() {
            jQuery('.percentage').each(function(){
                dataperc = jQuery(this).attr('data-perc');
                jQuery(this).find('.skill-count').delay(6000).countTo({
                    from: 0,
                    to: dataperc,
                    speed: 5000,
                    refreshInterval: 100
                });
            });
        }); 
        //End: Skills 

        /* Youtube Video */
        if (jQuery('.player').length){
            jQuery(".player").mb_YTPlayer({});
            jQuery('.player').on("YTPStart",function(){
               jQuery('.video-bg').animate({opacity: 1}, 5000,function(){});
            });
        }

    })
} (jQuery) )