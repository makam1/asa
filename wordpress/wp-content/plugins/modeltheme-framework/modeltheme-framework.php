<?php
/**
* Plugin Name: ModelTheme Framework
* Plugin URI: http://modeltheme.com/
* Description: ModelTheme Framework required by TREND Theme.
* Version: 1.2
* Author: ModelTheme
* Author http://modeltheme.com/
* Last Plugin Update: 05-DEC-2019
*/

$plugin_dir = plugin_dir_path( __FILE__ );


// CMB METABOXES
function modeltheme_cmb_initialize_cmb_meta_boxes() {
    if ( ! class_exists( 'cmb_Meta_Box' ) )
        require_once ('init.php');
}
add_action( 'init', 'modeltheme_cmb_initialize_cmb_meta_boxes', 9999 );


/**
||-> Function: modeltheme_framework()
*/
function modeltheme_framework( $hook ) {
    // CSS
    wp_register_style( 'modelteme-framework-admin-style',  plugin_dir_url( __FILE__ ) . 'css/modelteme-framework-admin-style.css' );
    wp_enqueue_style( 'modelteme-framework-admin-style' );
    // JS
    wp_enqueue_script( 'js-modeltheme-admin-custom', plugin_dir_url( __FILE__ ) . 'js/modeltheme-custom-admin.js', array(), '1.0.0', true );
}
add_action('admin_enqueue_scripts', 'modeltheme_framework');


// Remove the demo link and the notice of integrated demo from the redux-framework plugin
function remove_demo() {

    // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2);
    }

    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
    remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));
}


function trendRemoveDemoModeLink() { // Be sure to rename this function to something more unique
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
}
add_action('init', 'trendRemoveDemoModeLink');


// REMOVE VC Parallax Notices
if ( class_exists('GambitVCParallaxBackgrounds') ) {
    defined( 'GAMBIT_DISABLE_RATING_NOTICE' ) or define( 'GAMBIT_DISABLE_RATING_NOTICE', true );
}


// LOAD METABOXES
require_once('inc/metaboxes/metaboxes.php');
// LOAD POST TYPES
require_once('inc/post-types/post-types.php');
// LOAD SHORTCsODES
require_once('inc/shortcodes/shortcodes.php');
// DEMO IMPORTER
require_once('inc/demo-importer/redux.php');
// GOOGLE MAPS
require_once('inc/sb-google-maps-vc-addon/sb-google-maps-vc-addon.php'); // GMAPS
/* ========= WIDGETS ===================================== */
require_once('inc/widgets/widgets.php');


