<?php

// Logo Source
function trend_logo_source(){
    
    // REDUX VARIABLE
    global $trend_redux;

    // html VARIABLE
    $html = '';

    // Metaboxes
    $mt_custom_header_options_status = get_post_meta( get_the_ID(), 'mt_custom_header_options_status', true );
    $mt_metabox_header_logo = get_post_meta( get_the_ID(), 'mt_metabox_header_logo', true );

    if (is_page()) {
        if (isset($mt_custom_header_options_status) && isset($mt_metabox_header_logo) && $mt_custom_header_options_status == 'yes') {
            $html .='<img src="'.esc_url($mt_metabox_header_logo).'" alt="'.esc_attr(get_bloginfo()).'" />';
        }else{
            if(!empty($trend_redux['trend_logo']['url'])){
                $html .='<img src="'.esc_url($trend_redux['trend_logo']['url']).'" alt="'.esc_attr(get_bloginfo()).'" />';
            }else{ 
                $html .= $trend_redux['trend_logo_text'];
            }
        }
    }else{
        if(!empty($trend_redux['trend_logo']['url'])){
            $html .='<img src="'.esc_url($trend_redux['trend_logo']['url']).'" alt="'.esc_attr(get_bloginfo()).'" />';
        }elseif(isset($trend_redux['trend_logo_text'])){ 
            $html .= $trend_redux['trend_logo_text'];
        }else{
            $html .= esc_attr(get_bloginfo());
        }
    }

    return $html; 
}



// Logo Area
function trend_logo(){

    // REDUX VARIABLE
    global $trend_redux;

    // html VARIABLE
    $html = '';

    $html .='<h1 class="logo">';
        $html .='<a href="'.esc_url(get_site_url()).'">';
            $html .= trend_logo_source();
        $html .='</a>';
    $html .='</h1>';

    return $html;
}




// Add specific CSS class by filter
function trend_body_classes( $classes ) {

    global  $trend_redux;


    // CHECK IF FEATURED IMAGE IS FALSE(Disabled)
    $post_featured_image = '';
    if (is_singular('post')) {
        if ($trend_redux['post_featured_image'] == false) {
            $post_featured_image = 'hide_post_featured_image';
        }else{
            $post_featured_image = '';
        }
    }


    // CHECK IF THE NAV IS STICKY
    $is_nav_sticky = '';
    if ($trend_redux['is_nav_sticky'] == true) {
        // If is sticky
        $is_nav_sticky = 'is_nav_sticky';
    }else{
        // If is not sticky
        $is_nav_sticky = '';
    }


    // CHECK IF ADD-TO-WISHLIST option is false
    $add_to_compare = '';
    if ($trend_redux['is_add_to_compare_active'] == false) {
        // If is sticky
        $add_to_compare = 'hidden_compare_btn';
    }else{
        // If is not sticky
        $add_to_compare = '';
    }


    // CHECK IF ADD-TO-COMPARE option is true
    $add_to_wishlist = '';
    if ($trend_redux['is_add_to_wishlist_active'] == false) {
        // If is sticky
        $add_to_wishlist = 'hidden_wishlist_btn';
    }else{
        // If is not sticky
        $add_to_wishlist = '';
    }


    // DIFFERENT HEADER LAYOUT TEMPLATES
    if (is_page()) {

        $mt_custom_header_options_status = get_post_meta( get_the_ID(), 'mt_custom_header_options_status', true );
        $mt_header_custom_variant = get_post_meta( get_the_ID(), 'mt_header_custom_variant', true );
        $header_version = 'first_header';

        if (isset($mt_custom_header_options_status) AND $mt_custom_header_options_status == 'yes') {
            if ($mt_header_custom_variant == '1') {
                // Header Layout #1
                $header_version = 'first_header';
            }elseif ($mt_header_custom_variant == '2') {
                // Header Layout #2
                $header_version = 'second_header';
            }elseif ($mt_header_custom_variant == '3') {
                // Header Layout #3
                $header_version = 'third_header';
            }elseif ($mt_header_custom_variant == '4') {
                // Header Layout #4
                $header_version = 'fourth_header';
            }elseif ($mt_header_custom_variant == '5') {
                // Header Layout #5
                $header_version = 'fifth_header';
            }elseif ($mt_header_custom_variant == '6') {
                // Header Layout #6
                $header_version = 'sixth_header';
            }elseif ($mt_header_custom_variant == '7') {
                // Header Layout #7
                $header_version = 'seventh_header';
            }elseif ($mt_header_custom_variant == '8') {
                // Header Layout #8
                $header_version = 'eighth_header';
            }else{
                // if no header layout selected show header layout #1
                $header_version = 'first_header';
            }
        }else{
            if ($trend_redux['header_layout'] == 'first_header') {
                // Header Layout #1
                $header_version = 'first_header';
            }elseif ($trend_redux['header_layout'] == 'second_header') {
                // Header Layout #2
                $header_version = 'second_header';
            }elseif ($trend_redux['header_layout'] == 'third_header') {
                // Header Layout #3
                $header_version = 'third_header';
            }elseif ($trend_redux['header_layout'] == 'fourth_header') {
                // Header Layout #4
                $header_version = 'fourth_header';
            }elseif ($trend_redux['header_layout'] == 'fifth_header') {
                // Header Layout #5
                $header_version = 'fifth_header';
            }elseif ($trend_redux['header_layout'] == 'sixth_header') {
                // Header Layout #6
                $header_version = 'sixth_header';
            }elseif ($trend_redux['header_layout'] == 'seventh_header') {
                // Header Layout #7
                $header_version = 'seventh_header';
            }elseif ($trend_redux['header_layout'] == 'eighth_header') {
                // Header Layout #8
                $header_version = 'eighth_header';
            }else{
                // if no header layout selected show header layout #1
                $header_version = 'first_header';
            }
        }
    }else{
        if ($trend_redux['header_layout'] == 'first_header') {
            // Header Layout #1
            $header_version = 'first_header';
        }elseif ($trend_redux['header_layout'] == 'second_header') {
            // Header Layout #2
            $header_version = 'second_header';
        }elseif ($trend_redux['header_layout'] == 'third_header') {
            // Header Layout #3
            $header_version = 'third_header';
        }elseif ($trend_redux['header_layout'] == 'fourth_header') {
            // Header Layout #4
            $header_version = 'fourth_header';
        }elseif ($trend_redux['header_layout'] == 'fifth_header') {
            // Header Layout #5
            $header_version = 'fifth_header';
        }elseif ($trend_redux['header_layout'] == 'sixth_header') {
            // Header Layout #6
            $header_version = 'sixth_header';
        }elseif ($trend_redux['header_layout'] == 'seventh_header') {
            // Header Layout #7
            $header_version = 'seventh_header';
        }elseif ($trend_redux['header_layout'] == 'eighth_header') {
            // Header Layout #8
            $header_version = 'eighth_header';
        }else{
            // if no header layout selected show header layout #1
            $header_version = 'first_header';
        }
    }


    // add 'class-name' to the $classes array
    $classes[] = esc_attr($is_nav_sticky) . ' ' . esc_attr($add_to_compare) . ' ' . esc_attr($add_to_wishlist) . ' ' . esc_attr($header_version) . ' ' . esc_attr($post_featured_image) . ' ';
    // return the $classes array
    return $classes;

}
add_filter( 'body_class', 'trend_body_classes' );

// TREND REDUX
function trend_redux($redux_meta_name1,$redux_meta_name2 = ''){

    global  $trend_redux;

    $html = '';
    if (isset($redux_meta_name1) && !empty($redux_meta_name2)) {
        $html = $trend_redux[$redux_meta_name1][$redux_meta_name2];
    }elseif(isset($redux_meta_name1) && empty($redux_meta_name2)){
        $html = $trend_redux[$redux_meta_name1];
    }
    
    return $html;
}

?>