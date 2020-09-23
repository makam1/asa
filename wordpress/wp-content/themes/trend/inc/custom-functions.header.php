<?php
/**
CUSTOM HEADER FUNCTIONS
*/

/**
||-> FUNCTION: GET GOOGLE FONTS FROM THEME OPTIONS PANEL
*/
function trendwp_get_site_fonts(){
    $fonts_string = '';
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
    	global  $trendwp_redux;
	    if (isset($trendwp_redux['mt_google_fonts_select'])) {
	        $i = 0;
	        $len = count($trendwp_redux['mt_google_fonts_select']);
	        foreach(array_keys($trendwp_redux['mt_google_fonts_select']) as $key){
	            $font_url = str_replace(' ', '+', $trendwp_redux['mt_google_fonts_select'][$key]);
	            
	            if ($i == $len - 1) {
	                // last
	                $fonts_string .= $font_url;
	            }else{
	                $fonts_string .= $font_url . '|';
	            }
	            $i++;
	        }
	    }
    }else{
    	$fonts_string = 'Roboto:100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic,vietnamese,greek,latin-ext,greek-ext,cyrillic-ext,latin,cyrillic';
    }
    // fonts url
    $fonts_url = add_query_arg( 'family', $fonts_string, "//fonts.googleapis.com/css" );
    // enqueue fonts
    wp_enqueue_style( 'trendwp-fonts', $fonts_url, array(), '1.0.0' );
}
add_action('wp_enqueue_scripts', 'trendwp_get_site_fonts');



/**
||-> FUNCTION: GET DYNAMIC CSS
*/
add_action('wp_enqueue_scripts', 'trend_dynamic_css' );
function trend_dynamic_css(){

	wp_enqueue_style(
	   'trend-custom-style',
	    get_template_directory_uri() . '/css/custom-editor-style.css'
	);
   	
    $html = '';



   	if (is_page()) {
	    $mt_custom_page_skin_color_status = get_post_meta( get_the_ID(), 'mt_custom_page_skin_color_status', true );
		$mt_global_page_color = get_post_meta( get_the_ID(), 'mt_global_page_color', true );
		$mt_global_page_color_hover = get_post_meta( get_the_ID(), 'mt_global_page_color_hover', true );
		list($r, $g, $b) = sscanf($mt_global_page_color, "#%02x%02x%02x");

		if (isset($mt_custom_page_skin_color_status) AND $mt_custom_page_skin_color_status == 'yes') {
			$mt_style_main_texts_color = $mt_global_page_color;
			$mt_style_main_backgrounds_color = $mt_global_page_color;
			$mt_style_main_backgrounds_color_hover = $mt_global_page_color_hover;
			$mt_style_semi_opacity_backgrounds = 'rgba('.esc_attr($r).', '.esc_attr($g).', '.esc_attr($b).', 0.85)';
			$back_to_top = $mt_global_page_color;

			$html .= '	.back-to-top{
							background-color: '.esc_attr($mt_style_main_backgrounds_color).'; 
						}';

		}else{
			$mt_style_main_texts_color = trend_redux("mt_style_main_texts_color");
			$mt_style_main_backgrounds_color = trend_redux("mt_style_main_backgrounds_color");
			$mt_style_main_backgrounds_color_hover = trend_redux("mt_style_main_backgrounds_color_hover");
			$mt_style_semi_opacity_backgrounds = trend_redux('mt_style_semi_opacity_backgrounds', 'alpha');

		}
		

   	}else{
		$mt_style_main_texts_color = trend_redux("mt_style_main_texts_color");
		$mt_style_main_backgrounds_color = trend_redux("mt_style_main_backgrounds_color");
		$mt_style_main_backgrounds_color_hover = trend_redux("mt_style_main_backgrounds_color_hover");
		$mt_style_semi_opacity_backgrounds = trend_redux('mt_style_semi_opacity_backgrounds', 'alpha');


   	}

    // THEME OPTIONS STYLESHEET
    $html .= '
	        .breadcrumb a::after {
	            content: "'.trend_redux('breadcrumbs-delimitator').'";
	        }
	        .navbar-header .logo img {
	            max-width: '.esc_attr(trend_redux("logo_max_width")).'px;
	        }
		    ::selection{
		        color: '.trend_redux('mt_text_selection_color').';
		        background: '.trend_redux('mt_text_selection_background_color').';
		    }
		    ::-moz-selection { /* Code for Firefox */
		        color: '.trend_redux('mt_text_selection_color').';
		        background: '.trend_redux('mt_text_selection_background_color').';
		    }
		    a{
		        color: '.trend_redux('mt_global_link_styling', 'regular').';
		    }
		    a:focus,
		    a:visited,
		    a:hover{
		        color: '.trend_redux('mt_global_link_styling', 'hover').';
		    }
		    /*------------------------------------------------------------------
		        COLOR
		    ------------------------------------------------------------------*/
			a, 
			a:hover, 
			a:focus,
			span.amount,
			table.compare-list .remove td a .remove,
			.woocommerce form .form-row .required,
			.woocommerce .woocommerce-info::before,
			.woocommerce .woocommerce-message::before,
			.woocommerce div.product p.price, 
			.woocommerce div.product span.price,
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
			.widget_popular_recent_tabs .nav-tabs li.active a,
			.widget_product_categories .cat-item:hover,
			.widget_product_categories .cat-item a:hover,
			.widget_archive li:hover,
			.widget_archive li a:hover,
			.widget_categories .cat-item:hover,
			.widget_categories li a:hover,
			.woocommerce .star-rating span::before,
			.pricing-table.recomended .button.solid-button, 
			.pricing-table .table-content:hover .button.solid-button,
			.pricing-table.Recommended .button.solid-button, 
			.pricing-table.recommended .button.solid-button, 
			.pricing-table.recomended .button.solid-button, 
			.pricing-table .table-content:hover .button.solid-button,
			.testimonial-author,
			.testimonials-container blockquote::before,
			.testimonials-container blockquote::after,
			h1 span,
			h2 span,
			label.error,
			.author-name,
			.comment_body .author_name,
			.prev-next-post a:hover,
			.comment-form i,
			.prev-text,
			.next-text,
			.social ul li a:hover i,
			.wpcf7-form span.wpcf7-not-valid-tip,
			.text-dark .statistics .stats-head *,
			.wpb_button.btn-filled,
			.widget_meta a:hover,
			.logo span,
			.widget_pages a:hover,
			.categories_shortcode .category.active, .categories_shortcode .category:hover,
			.widget_recent_entries_with_thumbnail li:hover a,
			.widget_recent_entries li a:hover,
			.wpb_button.btn-filled:hover,
			.sidebar-content .widget_nav_menu li a:hover{
			    color: '.esc_attr($mt_style_main_texts_color).';
			}
			.woocommerce a.remove{
			    color: '.esc_attr($mt_style_main_texts_color).' !important;
			}
			.tagcloud > a:hover,
			.trend-icon-search,
			.wpb_button::after,
			.rotate45,
			.latest-posts .post-date-day,
			.latest-posts h3, 
			.latest-tweets h3, 
			.latest-videos h3,
			.button.solid-button, 
			button.vc_btn,
			.pricing-table.recomended .table-content, 
			.pricing-table .table-content:hover,
			.pricing-table.Recommended .table-content, 
			.pricing-table.recommended .table-content, 
			.pricing-table.recomended .table-content, 
			.pricing-table .table-content:hover,
			.block-triangle,
			.owl-theme .owl-controls .owl-page span,
			body .vc_btn.vc_btn-blue, 
			body a.vc_btn.vc_btn-blue, 
			body button.vc_btn.vc_btn-blue,
			.woocommerce #respond input#submit, 
			.woocommerce a.button, 
			.woocommerce button.button, 
			.woocommerce input.button,
			table.compare-list .add-to-cart td a,
			.woocommerce #respond input#submit.alt, 
			.woocommerce a.button.alt, 
			.woocommerce button.button.alt, 
			.woocommerce input.button.alt,
			.woocommerce a.remove:hover,
			.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
			.woocommerce nav.woocommerce-pagination ul li a:focus, 
			.woocommerce nav.woocommerce-pagination ul li a:hover, 
			.woocommerce nav.woocommerce-pagination ul li span.current, 
			.pagination .page-numbers.current,
			.pagination .page-numbers:hover,
			.widget_social_icons li a:hover, 
			#subscribe > button[type="submit"],
			.social-sharer > li:hover,
			.prev-next-post a:hover .rotate45,
			.masonry_banner.default-skin,
			.form-submit input,
			.member-header::before, 
			.member-header::after,
			.member-footer .social::before, 
			.member-footer .social::after,
			.subscribe > button[type="submit"],
			.woocommerce.single-product .wishlist-container .yith-wcwl-wishlistaddedbrowse,
			.woocommerce #respond input#submit.alt.disabled, 
			.woocommerce #respond input#submit.alt.disabled:hover, 
			.woocommerce #respond input#submit.alt:disabled, 
			.woocommerce #respond input#submit.alt:disabled:hover, 
			.woocommerce #respond input#submit.alt[disabled]:disabled, 
			.woocommerce #respond input#submit.alt[disabled]:disabled:hover, 
			.woocommerce a.button.alt.disabled, 
			.woocommerce a.button.alt.disabled:hover, 
			.woocommerce a.button.alt:disabled, 
			.woocommerce a.button.alt:disabled:hover, 
			.woocommerce a.button.alt[disabled]:disabled, 
			.woocommerce a.button.alt[disabled]:disabled:hover, 
			.woocommerce button.button.alt.disabled, 
			.woocommerce button.button.alt.disabled:hover, 
			.woocommerce button.button.alt:disabled, 
			.woocommerce button.button.alt:disabled:hover, 
			.woocommerce button.button.alt[disabled]:disabled, 
			.woocommerce button.button.alt[disabled]:disabled:hover, 
			.woocommerce input.button.alt.disabled, 
			.woocommerce input.button.alt.disabled:hover, 
			.woocommerce input.button.alt:disabled, 
			.woocommerce input.button.alt:disabled:hover, 
			.woocommerce input.button.alt[disabled]:disabled, 
			.woocommerce input.button.alt[disabled]:disabled:hover,
			.no-results input[type="submit"],
			table.compare-list .add-to-cart td a,
			.shop_cart,
			h3#reply-title::after,
			.newspaper-info,
			.categories_shortcode .owl-controls .owl-buttons i:hover,
			.widget-title:after,
			h2.heading-bottom:after,
			.wpb_content_element .wpb_accordion_wrapper .wpb_accordion_header.ui-state-active,
			#primary .main-content ul li:not(.rotate45)::before,
			.wpcf7-form .wpcf7-submit,
			.widget_address_social_icons .social-links a,
			.hover-components .component:hover,
			.navbar-default .navbar-toggle .icon-bar,
			footer .footer-top .menu .menu-item a::before,
			.post-password-form input[type="submit"] {
			    background: '.esc_attr($mt_style_main_backgrounds_color).';
			}
			body .tp-bullets.preview1 .bullet,
			body #mega_main_menu li.default_dropdown .mega_dropdown > li > .item_link:hover, 
			body #mega_main_menu li.widgets_dropdown .mega_dropdown > li > .item_link:hover, 
			body #mega_main_menu li.multicolumn_dropdown .mega_dropdown > li > .item_link:hover, 
			body #mega_main_menu li.grid_dropdown .mega_dropdown > li > .item_link:hover{
			    background: '.esc_attr($mt_style_main_backgrounds_color).' !important;
			}
			#cd-zoom-in, #cd-zoom-out{
			    background-color: '.esc_attr($mt_style_main_backgrounds_color).';
			}
			.woocommerce ul.products li.product .onsale, 
			body .woocommerce ul.products li.product .onsale, 
			body .woocommerce ul.products li.product .onsale {
				background-color: '.esc_attr($mt_style_main_backgrounds_color).';
			}
			.comment-form input, 
			.comment-form textarea,
			.author-bio,
			blockquote,
			.widget_popular_recent_tabs .nav-tabs > li.active,
			body .left-border, 
			body .right-border,
			body .member-header,
			body .member-footer .social,
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
			.woocommerce .woocommerce-info, 
			.woocommerce .woocommerce-message,
			body .button[type="submit"],
			.navbar ul li ul.sub-menu,
			.wpb_content_element .wpb_tabs_nav li.ui-tabs-active,
			.header_mini_cart,
			.header_mini_cart.visible_cart,
			#contact-us .form-control:focus,
			.header_mini_cart .woocommerce .widget_shopping_cart .total, 
			.header_mini_cart .woocommerce.widget_shopping_cart .total,
			.sale_banner_holder:hover,
			.testimonial-img,
			.wpcf7-form input:focus, 
			.wpcf7-form textarea:focus,
			.navbar-default .navbar-toggle:hover, 
			.navbar-default .navbar-toggle{
			    border-color: '.esc_attr($mt_style_main_backgrounds_color).';
			}
			.woocommerce #respond input#submit:hover, 
			.woocommerce a.button:hover, 
			.woocommerce button.button:hover, 
			.woocommerce input.button:hover,
			table.compare-list .add-to-cart td a:hover,
			.woocommerce #respond input#submit.alt:hover, 
			.woocommerce a.button.alt:hover, 
			.woocommerce button.button.alt:hover, 
			.woocommerce input.button.alt:hover,
			.trend-search.trend-search-open .trend-icon-search, 
			.no-js .trend-search .trend-icon-search,
			.trend-icon-search:hover,
			.latest-posts .post-date-month,
			.button.solid-button:hover,
			body .vc_btn.vc_btn-blue:hover, 
			body a.vc_btn.vc_btn-blue:hover, 
			body button.vc_btn.vc_btn-blue:hover,
			.subscribe > button[type="submit"]:hover,
			.no-results input[type="submit"]:hover,
			table.compare-list .add-to-cart td a:hover,
			.shop_cart:hover,
			.wpcf7-form .wpcf7-submit:hover,
			.widget_address_social_icons .social-links a:hover,
			.post-password-form input[type="submit"]:hover {
			    background: '.esc_attr($mt_style_main_backgrounds_color_hover).'; /*Color: Main Dark */
			}
			.no-touch #cd-zoom-in:hover, .no-touch #cd-zoom-out:hover{
			    background-color: '.esc_attr($mt_style_main_backgrounds_color_hover).'; /*Color: Main Dark */
			}
			.woocommerce ul.cart_list li a::before, 
			.woocommerce ul.product_list_widget li a::before,
			.flickr_badge_image a::after,
			.thumbnail-overlay,
			.portfolio-hover,
			.hover-components .component,
			.item-description .holder-top,
			blockquote::before {
			    background: '.esc_attr($mt_style_semi_opacity_backgrounds).'; /*Color: Main: Opacity 0.95 */
			}

    ';



    wp_add_inline_style( 'trend-custom-style', $html );
}



?>