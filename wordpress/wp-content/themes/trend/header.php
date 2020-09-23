<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<?php 
#Redux global variable
global $trend_redux;
?>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
        <link rel="shortcut icon" href="<?php echo esc_url(trend_redux('trend_favicon', 'url')); ?>">
    <?php } ?>
    <?php wp_head(); ?>
</head>



<body <?php body_class(); ?>>
    <div id="page" class="hfeed site">
    <?php
        if (is_page()) {
            $mt_custom_header_options_status = get_post_meta( get_the_ID(), 'mt_custom_header_options_status', true );
            $mt_header_custom_variant = get_post_meta( get_the_ID(), 'mt_header_custom_variant', true );
            if (isset($mt_custom_header_options_status) AND $mt_custom_header_options_status == 'yes') {
                get_template_part( 'templates/header-template'.esc_attr($mt_header_custom_variant) );
            }else{
                // DIFFERENT HEADER LAYOUT TEMPLATES
                if ($trend_redux['header_layout'] == 'first_header') {
                    // Header Layout #1
                    get_template_part( 'templates/header-template1' );
                }elseif ($trend_redux['header_layout'] == 'second_header') {
                    // Header Layout #2
                    get_template_part( 'templates/header-template2' );
                }elseif ($trend_redux['header_layout'] == 'third_header') {
                    // Header Layout #3
                    get_template_part( 'templates/header-template3' );
                }elseif ($trend_redux['header_layout'] == 'fourth_header') {
                    // Header Layout #4
                    get_template_part( 'templates/header-template4' );
                }elseif ($trend_redux['header_layout'] == 'fifth_header') {
                    // Header Layout #5
                    get_template_part( 'templates/header-template5' );
                }elseif ($trend_redux['header_layout'] == 'sixth_header') {
                    // Header Layout #6
                    get_template_part( 'templates/header-template6' );
                }elseif ($trend_redux['header_layout'] == 'seventh_header') {
                    // Header Layout #7
                    get_template_part( 'templates/header-template7' );
                }elseif ($trend_redux['header_layout'] == 'eighth_header') {
                    // Header Layout #8
                    get_template_part( 'templates/header-template8' );
                }else{
                    // if no header layout selected show header layout #1
                    get_template_part( 'templates/header-template1' );
                } 
            }
        }else{
            // DIFFERENT HEADER LAYOUT TEMPLATES
            if ($trend_redux['header_layout'] == 'first_header') {
                // Header Layout #1
                get_template_part( 'templates/header-template1' );
            }elseif ($trend_redux['header_layout'] == 'second_header') {
                // Header Layout #2
                get_template_part( 'templates/header-template2' );
            }elseif ($trend_redux['header_layout'] == 'third_header') {
                // Header Layout #3
                get_template_part( 'templates/header-template3' );
            }elseif ($trend_redux['header_layout'] == 'fourth_header') {
                // Header Layout #4
                get_template_part( 'templates/header-template4' );
            }elseif ($trend_redux['header_layout'] == 'fifth_header') {
                // Header Layout #5
                get_template_part( 'templates/header-template5' );
            }elseif ($trend_redux['header_layout'] == 'sixth_header') {
                // Header Layout #6
                get_template_part( 'templates/header-template6' );
            }elseif ($trend_redux['header_layout'] == 'seventh_header') {
                // Header Layout #7
                get_template_part( 'templates/header-template7' );
            }elseif ($trend_redux['header_layout'] == 'eighth_header') {
                // Header Layout #8
                get_template_part( 'templates/header-template8' );
            }else{
                // if no header layout selected show header layout #1
                get_template_part( 'templates/header-template1' );
            }
        }

    ?>







