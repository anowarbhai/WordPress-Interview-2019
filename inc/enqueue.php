<?php

/*
	
@package sunsettheme
	
	========================
		ADMIN ENQUEUE FUNCTIONS
	========================
*/

function mephoto_load_admin_scripts(){
	wp_enqueue_style( 'admincss', get_template_directory_uri() . '/css/admin.css', array(), '1.0.0', 'all');

    wp_enqueue_script( 'metrika_admin_js', get_template_directory_uri() . '/js/admin.js', array(), false );
    $l10n = array(
        'site_url'         => site_url(),
        'loader'           => '<img src="' . get_template_directory_uri() . '/img/loader.GIF' . '">',
        'success_save'     => '<span class="success-msg">' . __('Save') . '</span>',
        'error_save'       => '<span class="error-msg">' . __('Error') . '</span>',
        'select_icon_text' => __('Select Icon', 'metrika'),
        'loading'          => __('Loading...', 'metrika'),
    );
    wp_localize_script('metrika_admin_js', 'metrikaParams', $l10n);
}
add_action( 'admin_enqueue_scripts', 'mephoto_load_admin_scripts' );

/*
	
	========================
		FRONT-END ENQUEUE FUNCTIONS
	========================
*/

function sunset_load_scripts(){
	
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.6', 'all' );
	wp_enqueue_style( 'font-awesome-css', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.7.0', 'all' );
	wp_enqueue_style( 'font-7-stroke-css', get_template_directory_uri() . '/css/pe-icon-7-stroke/css/pe-icon-7-stroke.css', array(), '4.7.0', 'all' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), '1.0.0', 'all' );
	wp_enqueue_style( 'fonts', get_template_directory_uri() . '/css/fonts.css', array(), '1.0.0', 'all' );
	wp_enqueue_style( 'owl.carousel', get_template_directory_uri() . '/css/owl.carousel.css', array(), '1.0.0', 'all' );
	wp_enqueue_style( 'owl.theme', get_template_directory_uri() . '/css/owl.theme.css', array(), '1.0.0', 'all' );
	wp_enqueue_style( 'owl.transitions', get_template_directory_uri() . '/css/owl.transitions.css', array(), '1.0.0', 'all' );
	wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/css/slick.css', array(), '1.0.0', 'all' );
	wp_enqueue_style( 'fancybox-css', get_template_directory_uri() . '/css/jquery.fancybox.min.css', array(), '1.0.0', 'all' );
	wp_enqueue_style( 'main-css', get_template_directory_uri() . '/css/main.css', array('js_composer_front'), '1.0.0', 'all' );
	wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/responsive.css', array(), '1.0.0', 'all' );
	wp_enqueue_style( 'Roboto-font', '//fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,600,600i,700,700i', array(), '1.0.0', 'all' );
	wp_enqueue_style( 'Karla-font', '//fonts.googleapis.com/css?family=Karla:400,400i,700,700i&display=swap', array(), '1.0.0', 'all' );


	//wp_enqueue_script( 'ajaxgoogle-js', '//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js', array('jquery'), '2.0.2', true );
	
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.3.6', true );
	wp_enqueue_script( 'easing', get_template_directory_uri() . '/js/jquery.easing.min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'jquery-ui', get_template_directory_uri() . '/js/jquery-ui.min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'carousel', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/js/slick.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'fancybox-js', get_template_directory_uri() . '/js/jquery.fancybox.min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'sticky', get_template_directory_uri() . '/js/jquery.sticky.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'mixitup', get_template_directory_uri() . '/js/jquery.mixitup.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true );
	
}
add_action( 'wp_enqueue_scripts', 'sunset_load_scripts' );















