<?php
/*
@package sunsettheme
	========================
		THEME CUSTOM POST TYPES
	========================
*/

/* sunset CPT */
function sunset_custom_post_type() {

    register_post_type( 'words',
        array(
            'labels' => array(
                'name' => __( 'Works' ),
                'singular_name' => __( 'Work' ),
                'add_new_item' => __( 'Add New Work' ),
                'edit_item' => __( 'Edit Work' ),
                'new_item' => __( 'Add New Work' ),
                'view_item' => __( 'View Work' ),
                'search_items' => __( 'Search Work' ),
                'not_found' => __( 'No Work found' ),
                'not_found_in_trash' => __( 'No Work found in trash' ),
                'all_items' => __( 'All Works' ),
            ),
            'public' => true,
            'supports' => array( 'title', 'editor', 'thumbnail'),
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-networking',
            'menu_position' => 5,
        )
    );

    register_post_type( 'faq',
        array(
            'labels' => array(
                'name' => __( 'Faq\'s' ),
                'singular_name' => __( 'Faq' ),
                'add_new_item' => __( 'Add New Faq' ),
                'edit_item' => __( 'Edit Faq' ),
                'new_item' => __( 'Add New Faq' ),
                'view_item' => __( 'View Faq' ),
                'search_items' => __( 'Search Faq' ),
                'not_found' => __( 'No Faq found' ),
                'not_found_in_trash' => __( 'No Faq found in trash' ),
                'all_items' => __( 'All Faq\'s' ),
            ),
            'public' => true,
            'supports' => array( 'title', 'editor'),
            'capability_type' => 'post',
            'menu_position' => 5,
        )
    );
	
	register_taxonomy('faq_cat', 'faq', array(
        'labels'    => array(
            'name'  => 'Faq Cat',
            'add_new_item'  => 'Add New',
            'parent_item'   => 'Parent Category',
            
        ),
        'public'    => true,
        'hierarchical'  => true
    ));
	
    register_post_type( 'services',
        array(
            'labels' => array(
                'name' => __( 'Services' ),
                'singular_name' => __( 'Service' ),
                'add_new_item' => __( 'Add New Service' ),
                'edit_item' => __( 'Edit Service' ),
                'new_item' => __( 'Add New Service' ),
                'view_item' => __( 'View Service' ),
                'search_items' => __( 'Search Service' ),
                'not_found' => __( 'No Service found' ),
                'not_found_in_trash' => __( 'No Service found in trash' ),
                'all_items' => __( 'All Services' ),
            ),
            'public' => true,
            'supports' => array( 'title', 'editor', 'thumbnail'),
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-admin-users',
            'menu_position' => 5,
        )
    );

	
}
add_action( 'init', 'sunset_custom_post_type' );



