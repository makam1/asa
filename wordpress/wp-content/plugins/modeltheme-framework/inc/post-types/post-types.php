<?php

/**
 * Custom Post Type [Testimonial]
 */
function trend_testimonial_custom_post() {
    register_post_type('Testimonial', array(
                        'label' => __('Testimonials','trend'),
                        'description' => '',
                        'public' => true,
                        'show_ui' => true,
                        'show_in_menu' => true,
                        'capability_type' => 'post',
                        'map_meta_cap' => true,
                        'hierarchical' => false,
                        'rewrite' => array('slug' => 'testimonial', 'with_front' => true),
                        'query_var' => true,
                        'menu_position' => '1',
                        'menu_icon' => 'dashicons-format-status',
                        'supports' => array('title','editor','thumbnail','author','excerpt'),
                        'labels' => array (
                            'name' => __('Testimonials','trend'),
                            'singular_name' => __('Testimonial','trend'),
                            'menu_name' => __('Testimonials','trend'),
                            'add_new' => __('Add Testimonial','trend'),
                            'add_new_item' => __('Add New Testimonial','trend'),
                            'edit' => __('Edit','trend'),
                            'edit_item' => __('Edit Testimonial','trend'),
                            'new_item' => __('New Testimonial','trend'),
                            'view' => __('View Testimonial','trend'),
                            'view_item' => __('View Testimonial','trend'),
                            'search_items' => __('Search Testimonials','trend'),
                            'not_found' => __('No Testimonials Found','trend'),
                            'not_found_in_trash' => __('No Testimonials Found in Trash','trend'),
                            'parent' => __('Parent Testimonial','trend'),
                            )
                        ) 
                    ); 
}
add_action('init', 'trend_testimonial_custom_post');


/**
 * Custom Post Type [Clients]
 */
function trend_client_custom_post() {
    register_post_type('client', array(
                        'label' => __('Clients','trend'),
                        'description' => '',
                        'public' => true,
                        'show_ui' => true,
                        'show_in_menu' => true,
                        'capability_type' => 'post',
                        'map_meta_cap' => true,
                        'hierarchical' => false,
                        'rewrite' => array('slug' => 'client', 'with_front' => true),
                        'query_var' => true,
                        'menu_position' => '1',
                        'menu_icon' => 'dashicons-admin-users',
                        'supports' => array('title','editor','thumbnail','author','excerpt'),
                        'labels' => array (
                            'name' => __('Clients','trend'),
                            'singular_name' => __('Client','trend'),
                            'menu_name' => __('Clients','trend'),
                            'add_new' => __('Add Client','trend'),
                            'add_new_item' => __('Add New Client','trend'),
                            'edit' => __('Edit','trend'),
                            'edit_item' => __('Edit Client','trend'),
                            'new_item' => __('New Client','trend'),
                            'view' => __('View Client','trend'),
                            'view_item' => __('View Client','trend'),
                            'search_items' => __('Search Clients','trend'),
                            'not_found' => __('No Clients Found','trend'),
                            'not_found_in_trash' => __('No Clients Found in Trash','trend'),
                            'parent' => __('Parent Client','trend'),
                            )
                        ) 
                    ); 
}
add_action('init', 'trend_client_custom_post');

?>