<?php
// Add backend styles for Gutenberg.
add_action( 'enqueue_block_editor_assets', 'trend_add_gutenberg_assets' );
/**
 * Load Gutenberg stylesheet.
 */
function trend_add_gutenberg_assets() {
	// Load the theme styles within Gutenberg.
	wp_enqueue_style( 'trend-gutenberg-style', get_theme_file_uri( '/css/gutenberg-editor-style.css' ), false );
    wp_enqueue_style( 
        'trend-gutenberg-fonts', 
        '//fonts.googleapis.com/css?family=Roboto:100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic,vietnamese,greek,latin-ext,greek-ext,cyrillic-ext,latin,cyrillic' 
    ); 
}
?>