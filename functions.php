<?php
/**
 * Functions
 *
 * @package WordPress
 * @subpackage CIT Theme Starterr
 * @since CIT Theme Starterr 1.0
 */

define( 'citthemestarter_VERSION', '3.0.1' );
require get_template_directory().'/inc/custom-post-type.php';
require get_template_directory().'/inc/breadcums.php';
require get_template_directory().'/inc/post-duplicator.php';
require get_template_directory().'/inc/veshortcode.php';
require get_template_directory().'/inc/healper.php';



/*category checked_ontop*/
class Category_Checklist {
	static function init() {
		add_filter( 'wp_terms_checklist_args', array( __CLASS__, 'checklist_args' ) );
	}
	static function checklist_args( $args ) {
		add_action( 'admin_footer', array( __CLASS__, 'script' ) );
		$args['checked_ontop'] = false;
		return $args;
	}
	// Scrolls to first checked category
	static function script() {
?>
<script type="text/javascript">
	jQuery(function(){
		jQuery('[id$="-all"] > ul.categorychecklist').each(function() {
			var $list = jQuery(this);
			var $firstChecked = $list.find(':checkbox:checked').first();
			if ( !$firstChecked.length )
				return;
			var pos_first = $list.find(':checkbox').position().top;
			var pos_checked = $firstChecked.position().top;
			$list.closest('.tabs-panel').scrollTop(pos_checked - pos_first + 5);
		});
	});
</script>
<?php
	}
}
Category_Checklist::init();


/*Admin Style/Script Load*/
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

// require get_template_directory().'/inc/theme-options.php';
if ( ! function_exists( 'citthemestarter_setup' ) ) :
	/**
	 * Theme setup
	 */
	function citthemestarter_setup() {
		/*
		 * Make theme available for translation.
		 */
		load_theme_textdomain( 'cit', get_template_directory() . '/languages' );

		/*
		 * Define sidebars
		 */
		define( 'citthemestarter_PAGE_SIDEBAR',                     'cit_overall_site_page_sidebar' );
		define( 'citthemestarter_POST_SIDEBAR',                     'cit_overall_site_post_sidebar' );
		define( 'citthemestarter_ARCHIVE_AND_CATEGORY_SIDEBAR',     'cit_overall_site_aac_sidebar' );
		define( 'citthemestarter_DISABLE_HEADER',                   'cit_overall_site_disable_header' );
		define( 'citthemestarter_DISABLE_HEADER_TOPBAR',                   'cit_overall_site_disable_header_top_bar' );
		define( 'citthemestarter_DISABLE_FOOTER',                   'cit_overall_site_disable_footer' );
		define( 'cit_overall_site_enable_breadcrum',                   'cit_overall_site_enable_breadcrum' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable custom logo
		 */
		add_theme_support( 'custom-logo' );

		/*
		 * Enable custom background
		 */
		add_theme_support( 'custom-background', array(
				'default-color' => '#ffffff',
			) );

		citthemestarter_set_old_styles();
		citthemestarter_set_old_content_size();

		/*
		 * Feed Links
		 */
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'post-formats', array( 'gallery', 'video', 'image' ) );

		add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption' ) );

		if ( get_theme_mod( 'cit_overall_site_featured_image', true ) === true ) {
			add_theme_support( 'post-thumbnails' );
		}

		add_image_size( 'citthemestarter-featured-loop-image', 848, 0 );
		add_image_size( 'citthemestarter-featured-loop-image-full', 1140, 0 );
		add_image_size( 'citthemestarter-featured-single-image-boxed', 1170, 0 );
		add_image_size( 'citthemestarter-featured-single-image-full', 1920, 0 );

		/*
		 * Set the default content width.
		 */
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 848;
		}


		/*
		 * This theme uses wp_nav_menu() in two locations.
		 */
		register_nav_menus( array(
			'primary'       => esc_html__( 'Primary Menu', 'cit' ),
			'top_menu'       => esc_html__( 'Top Menu', 'cit' ),
			'footer_menu'       => esc_html__( 'About Footer', 'cit' ),
			'flash_menu'       => esc_html__( 'Flash Delivery', 'cit' ),
			'support_menu'       => esc_html__( 'Flash Support', 'cit' ),
		) );

		/*
		 * Comment reply
		 */
		add_action( 'comment_form_before', 'citthemestarter_enqueue_comments_reply' );

		/*
		 * ACF Integration
		 */

		if ( class_exists( 'acf' ) && function_exists( 'register_field_group' ) ) {
			$vct_acf_page_options = array(
				'id' => 'acf_page-options',
				'title' => esc_html__( 'Page Options', 'cit' ),
				'fields' => array(
					array(
						'key' => 'field_589f5a321f0bc',
						'label' => esc_html__( 'Sidebar Position', 'cit' ),
						'name' => 'sidebar_position',
						'type' => 'select',
						'instructions' => esc_html__( 'Select specific sidebar position.', 'cit' ),
						'choices' => array(
							'default' => esc_html__( 'Default', 'cit' ),
							'none' => esc_html__( 'None', 'cit' ),
							'left' => esc_html__( 'Left', 'cit' ),
							'right' => esc_html__( 'Right', 'cit' ),
						),
						'default_value' => get_theme_mod( citthemestarter_PAGE_SIDEBAR, 'none' ),
						'allow_null' => 0,
						'multiple' => 0,
					),
					array(
						'key' => 'field_589f55db2faa9',
						'label' => esc_html__( 'Show Page Title', 'cit' ),
						'name' => 'hide_page_title',
						'type' => 'checkbox',
						'choices' => array(
							1 => esc_html__( 'Yes', 'cit' ),
						),
						'default_value' => '',
						'layout' => 'vertical',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'page',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array(
					'position' => 'side',
					'layout' => 'default',
					'hide_on_screen' => array(),
				),
				'menu_order' => 0,
			);

			$vct_acf_post_options = array(
				'id' => 'acf_post-options',
				'title' => esc_html__( 'Post Options', 'cit' ),
				'fields' => array(
					array(
						'key' => 'field_589f5b1d656ca',
						'label' => esc_html__( 'Sidebar Position', 'cit' ),
						'name' => 'sidebar_position',
						'type' => 'select',
						'instructions' => esc_html__( 'Select specific sidebar position.', 'cit' ),
						'choices' => array(
							'default' => esc_html__( 'Default', 'cit' ),
							'none' => esc_html__( 'None', 'cit' ),
							'left' => esc_html__( 'Left', 'cit' ),
							'right' => esc_html__( 'Right', 'cit' ),
						),
						'default_value' => get_theme_mod( citthemestarter_POST_SIDEBAR, 'none' ),
						'allow_null' => 0,
						'multiple' => 0,
					),
					array(
						'key' => 'field_589f5b9a56207',
						'label' => esc_html__( 'Hide Post Title', 'cit' ),
						'name' => 'hide_page_title',
						'type' => 'checkbox',
						'choices' => array(
							1 => esc_html__( 'Yes', 'cit' ),
						),
						'default_value' => '',
						'layout' => 'vertical',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'post',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array(
					'position' => 'side',
					'layout' => 'default',
					'hide_on_screen' => array(),
				),
				'menu_order' => 0,
			);

			if ( ! get_theme_mod( citthemestarter_DISABLE_HEADER_TOPBAR, false ) ) {
				$vct_acf_page_options['fields'][] = array(
					'key' => 'field_58c800e5a7730',
					'label' => 'Disable Header Top',
					'name' => 'disable_page_header_top',
					'type' => 'checkbox',
					'choices' => array(
						1 => esc_html__( 'Yes', 'cit' ),
					),
					'default_value' => '',
					'layout' => 'vertical',
				);

				$vct_acf_post_options['fields'][] = array(
					'key' => 'field_58c800e5a7731',
					'label' => 'Disable Header Top',
					'name' => 'disable_page_header_top',
					'type' => 'checkbox',
					'choices' => array(
						1 => esc_html__( 'Yes', 'cit' ),
					),
					'default_value' => '',
					'layout' => 'vertical',
				);
			}

			if ( ! get_theme_mod( citthemestarter_DISABLE_HEADER, false ) ) {
				$vct_acf_page_options['fields'][] = array(
					'key' => 'field_58c800e5a7722',
					'label' => 'Disable Header',
					'name' => 'disable_page_header',
					'type' => 'checkbox',
					'choices' => array(
						1 => esc_html__( 'Yes', 'cit' ),
					),
					'default_value' => '',
					'layout' => 'vertical',
				);

				$vct_acf_post_options['fields'][] = array(
					'key' => 'field_58c7e3f0b7dfb',
					'label' => 'Disable Header',
					'name' => 'disable_post_header',
					'type' => 'checkbox',
					'choices' => array(
						1 => esc_html__( 'Yes', 'cit' ),
					),
					'default_value' => '',
					'layout' => 'vertical',
				);
			}

			if ( ! get_theme_mod( citthemestarter_DISABLE_FOOTER, false ) ) {
				$vct_acf_page_options['fields'][] = array(
					'key' => 'field_58c800faa7723',
					'label' => 'Disable Footer',
					'name' => 'disable_page_footer',
					'type' => 'checkbox',
					'choices' => array(
						1 => esc_html__( 'Yes', 'cit' ),
					),
					'default_value' => '',
					'layout' => 'vertical',
				);

				$vct_acf_post_options['fields'][] = array(
					'key' => 'field_58c7e40db7dfc',
					'label' => 'Disable Footer',
					'name' => 'disable_post_footer',
					'type' => 'checkbox',
					'choices' => array(
						1 => esc_html__( 'Yes', 'cit' ),
					),
					'default_value' => '',
					'layout' => 'vertical',
				);
			}
			register_field_group( $vct_acf_page_options );
			register_field_group( $vct_acf_post_options );
		} // End if().

		/**
		 * Customizer settings.
		 */
		require get_template_directory() . '/inc/customizer/class-citthemestarter-fonts.php';
		require get_template_directory() . '/inc/customizer/class-citthemestarter-customizer.php';
		require get_template_directory() . '/inc/hooks.php';
		new citthemestarter_Fonts();
		new citthemestarter_Customizer();

	}
endif; /* citthemestarter_setup */

add_action( 'after_setup_theme', 'citthemestarter_setup' );

/**
 *  Style Switch Toggle function
 */
function citthemestarter_style_switch_toggle_acf() {
	$screen = get_current_screen();
	if ( isset( $screen->base ) && 'post' === $screen->base ) {
		$font_uri = citthemestarter_Fonts::vct_theme_get_google_font_uri( array( 'Open Sans' ) );
		wp_register_style( 'citthemestarter-toggle-acf-fonts', $font_uri );
		wp_enqueue_style( 'citthemestarter-toggle-acf-fonts' );

		wp_register_style( 'citthemestarter-toggle-acf-style', get_template_directory_uri() . '/css/toggle-switch.css', array(), false );
		wp_enqueue_style( 'citthemestarter-toggle-acf-style' );
	}
}
add_action( 'admin_enqueue_scripts', 'citthemestarter_style_switch_toggle_acf' );

/**
 *  Script Switch Toggle function
 */
function citthemestarter_script_switch_toggle_acf() {
	$screen = get_current_screen();
	if ( isset( $screen->base ) && 'post' === $screen->base ) {
		wp_register_script( 'citthemestarter-toggle-acf-script', get_template_directory_uri() . '/js/toggle-switch-acf.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'citthemestarter-toggle-acf-script' );
	}
}
add_action( 'admin_enqueue_scripts', 'citthemestarter_script_switch_toggle_acf' );

/**
 * Ajax Comment Reply
 */
function citthemestarter_enqueue_comments_reply() {
	if ( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/*
 * Add Next Page Button to WYSIWYG editor
 */

add_filter( 'mce_buttons', 'citthemestarter_page_break' );

/**
 * Add page break
 *
 * @param citthemestarter_Customizer $mce_buttons Add page break.
 *
 * @return array
 */
function citthemestarter_page_break( $mce_buttons ) {
	$pos = array_search( 'wp_more', $mce_buttons, true );

	if ( false !== $pos ) {
		$buttons = array_slice( $mce_buttons, 0, $pos );
		$buttons[] = 'wp_page';
		$mce_buttons = array_merge( $buttons, array_slice( $mce_buttons, $pos ) );
	}

	return $mce_buttons;
}

/**
 * Enqueues styles.
 *
 * @since CIT Theme Starterr 1.0
 */
function citthemestarter_style() {

	/* Bootstrap stylesheet */
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7' );

	/* Add CIT Theme Starterr Font */
	wp_register_style( 'citthemestarter-font', get_template_directory_uri() . '/css/visual-composer-starter-font.min.css', array(), citthemestarter_VERSION );

	/* Slick slider stylesheet */
	wp_register_style( 'animate-style', get_template_directory_uri() . '/css/animate.min.css', array(), '1.6.0' );
	wp_register_style( 'awesome-style', get_template_directory_uri() . '/css/font-awesome.css', array(), '1.6.0' );
	wp_register_style( 'fancybox-style', get_template_directory_uri() . '/css/jquery.fancybox.min.css', array(), '1.6.0' );

	/* General theme stylesheet */
	wp_register_style( 'citthemestarter-general', get_template_directory_uri() . '/css/style.css', array(), citthemestarter_VERSION );

	/* Woocommerce stylesheet */
	wp_register_style( 'citthemestarter-woocommerce', get_template_directory_uri() . '/css/woocommerce.min.css', array(), citthemestarter_VERSION );
	wp_register_style( 'citthemestarter-theme-woocommercesss', get_template_directory_uri() . '/css/theme-woocommerce.css', array(), citthemestarter_VERSION );

	/* Stylesheet with additional responsive style */
	wp_register_style( 'citthemestarter-responsive', get_template_directory_uri() . '/css/responsive.css', array(), citthemestarter_VERSION );
	wp_enqueue_style( 'Robotos-font', '//fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,600,600i,700,700i', array(), '1.0.0', 'all' );
	/* Theme stylesheet */
	wp_register_style( 'citthemestarter-style', get_stylesheet_uri() );

	/* Font options */
	$fonts = array(
		get_theme_mod( 'cit_fonts_and_style_body_font_family', 'Roboto' ),
		get_theme_mod( 'cit_fonts_and_style_h1_font_family', 'Roboto' ),
		get_theme_mod( 'cit_fonts_and_style_h2_font_family', 'Roboto' ),
		get_theme_mod( 'cit_fonts_and_style_h3_font_family', 'Roboto' ),
		get_theme_mod( 'cit_fonts_and_style_h4_font_family', 'Roboto' ),
		get_theme_mod( 'cit_fonts_and_style_h5_font_family', 'Roboto' ),
		get_theme_mod( 'cit_fonts_and_style_h6_font_family', 'Roboto' ),
		get_theme_mod( 'cit_fonts_and_style_buttons_font_family', 'Roboto' ),
	);

	$font_uri = citthemestarter_Fonts::vct_theme_get_google_font_uri( $fonts );

	/* Load Google Fonts */
	wp_register_style( 'citthemestarter-fonts', $font_uri, array(), null, 'screen' );

	/* Enqueue styles */
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'citthemestarter-font' );
	wp_enqueue_style( 'animate-style' );
	wp_enqueue_style( 'awesome-style' );
	wp_enqueue_style( 'slick-style' );
	wp_enqueue_style( 'fancybox-style' );
	wp_enqueue_style( 'citthemestarter-general' );
	wp_enqueue_style( 'citthemestarter-woocommerce' );
	wp_enqueue_style( 'citthemestarter-responsive' );
	wp_enqueue_style( 'citthemestarter-style' );
	wp_enqueue_style( 'citthemestarter-fonts' );
	wp_enqueue_style( 'citthemestarter-theme-woocommercesss' );
}
add_action( 'wp_enqueue_scripts', 'citthemestarter_style' );


/**
 * Enqueues scripts.
 *
 * @since CIT Theme Starterr 1.0
 */
function citthemestarter_script() {
	/* Bootstrap Transition JS */
	wp_register_script( 'bootstrap-transition', get_template_directory_uri() . '/js/bootstrap/transition.min.js', array( 'jquery' ), '3.3.7', true );
	wp_register_script( 'bootstrap-main', get_template_directory_uri() . '/js/bootstrap/bootstrap.min.js', array( 'jquery' ), '3.3.7', true );

	/* Bootstrap Transition JS */
	wp_register_script( 'bootstrap-collapser', get_template_directory_uri() . '/js/bootstrap/collapse.min.js', array( 'jquery' ), '3.3.7', true );

	/* Slick Slider JS */
	wp_register_script( 'slick-js', get_template_directory_uri() . '/js/slick/slick.min.js', array( 'jquery' ), '1.6.0', true );
	wp_register_script( 'sticky-js', get_template_directory_uri() . '/js/jquery.sticky.js', array( 'jquery' ), '1.6.0', true );
	wp_register_script( 'modernizr-js', get_template_directory_uri() . '/js/modernizr.custom.js', array( 'jquery' ), '1.6.0', true );
	wp_register_script( 'fancybox-js', get_template_directory_uri() . '/js/jquery.fancybox.min.js', array( 'jquery' ), '1.6.0', true );
	wp_register_script( 'gallerys-js', get_template_directory_uri() . '/js/jquery.gallery.js', array( 'jquery' ), '1.6.0', true );

	/* Main theme JS functions */
	wp_register_script( 'citthemestarter-script', get_template_directory_uri() . '/js/functions.min.js', array( 'jquery' ), citthemestarter_VERSION, true );
	wp_register_script( 'main-js', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), citthemestarter_VERSION, true );

	wp_localize_script( 'jquery', 'citthemestarter', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'citthemestarter' ),
		'woo_coupon_form' => get_theme_mod( 'woocommerce_coupon_from', false ),
	) );

	/* Enqueue scripts */
	wp_enqueue_script( 'bootstrap-transition' );
	wp_enqueue_script( 'bootstrap-main' );
	wp_enqueue_script( 'bootstrap-collapser' );
	wp_enqueue_script( 'slick-js' );
	wp_enqueue_script( 'sticky-js' );
	wp_enqueue_script( 'modernizr-js' );
	wp_enqueue_script( 'fancybox-js' );
	wp_enqueue_script( 'gallerys-js' );
	wp_enqueue_script( 'citthemestarter-script' );
	wp_enqueue_script( 'main-js' );
}
add_action( 'wp_enqueue_scripts', 'citthemestarter_script' );

/**
 * Used by hook: 'customize_preview_init'
 *
 * @see add_action('customize_preview_init',$func)
 */
function citthemestarter_customizer_live_preview() {
	wp_enqueue_script( 'citthemestarter-themecustomizer', get_template_directory_uri() . '/js/customize-preview.min.js', array(
			'jquery',
			'customize-preview',
		), '', true );
}
add_action( 'customize_preview_init', 'citthemestarter_customizer_live_preview' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param Classes $classes Classes list.
 *
 * @return array
 */
function citthemestarter_body_classes( $classes ) {
	$classes[] = 'citthemestarter';

	/* Sandwich color */
	if ( get_theme_mod( 'cit_header_sandwich_style', '#333333' ) === '#FFFFFF' ) {
		$classes[] = 'sandwich-color-light';
	}

	/* Header Style */
	if ( get_theme_mod( 'cit_header_position', 'top' ) === 'sandwich' ) {
		$classes[] = 'menu-sandwich';
	}

	/* Menu position */
	if ( get_theme_mod( 'cit_header_sticky_header', false ) === true ) {
		$classes[] = 'scroll-fixed-header';
	}

	/* Navbar background */
	if ( get_theme_mod( 'cit_header_reserve_space_for_header', true ) === false ) {
		$classes[] = 'navbar-no-background';
	}

	/* Width of header-area */
	if ( get_theme_mod( 'cit_header_top_header_width', 'boxed' ) === 'full_width' ) {
		$classes[] = 'header-full-width';
	} elseif ( get_theme_mod( 'cit_header_top_header_width', 'boxed' ) === 'full_width_boxed' ) {
		$classes[] = 'header-full-width-boxed';
	}

	/* Width of content-area */
	if ( get_theme_mod( 'cit_overall_content_area_size', 'boxed' ) === 'full_width' ) {
		$classes[] = 'content-full-width';
	}

	/* Height of featured image */
	if ( get_theme_mod( 'cit_overall_site_featured_image_height', 'auto' ) === 'full_height' ) {
		$classes[] = 'featured-image-full-height';
	}

	if ( get_theme_mod( 'cit_overall_site_featured_image_height', 'auto' ) === 'custom' ) {
		$classes[] = 'featured-image-custom-height';
	}

	if ( false === citthemestarter_is_the_header_top_displayed() ) {
		$classes[] = 'headertop-area-disabled';
	}

	if ( false === citthemestarter_is_the_header_displayed() ) {
		$classes[] = 'header-area-disabled';
	}
	if ( false === citthemestarter_is_the_footer_displayed() ) {
		$classes[] = 'footer-area-disabled';
	}

	return $classes;
}
add_filter( 'body_class', 'citthemestarter_body_classes' );

/**
 *  Give linked images class
 *
 * @param string $html Html.
 * @since CIT Theme Starterr 1.2
 * @return mixed
 */
function citthemestarter_give_linked_images_class( $html ) {
	$classes = 'image-link'; // separated by spaces, e.g. 'img image-link'.

	$patterns = array();
	$replacements = array();

	// Matches img tag wrapped in anchor tag where anchor has existing classes contained in double quotes.
	$patterns[0] = '/<a([^>]*)class="([^"]*)"([^>]*)>\s*<img([^>]*)>\s*<\/a>/';
	$replacements[0] = '<a\1class="' . $classes . ' \2"\3><img\4></a>';

	// Matches img tag wrapped in anchor tag where anchor has existing classes contained in single quotes.
	$patterns[1] = '/<a([^>]*)class=\'([^\']*)\'([^>]*)>\s*<img([^>]*)>\s*<\/a>/';
	$replacements[1] = '<a\1class="' . $classes . ' \2"\3><img\4></a>';

	// Matches img tag wrapped in anchor tag where anchor tag has no existing classes.
	$patterns[2] = '/<a(?![^>]*class)([^>]*)>\s*<img([^>]*)>\s*<\/a>/';
	$replacements[2] = '<a\1 class="' . $classes . '"><img\2></a>';

	$html = preg_replace( $patterns, $replacements, $html );

	return $html;
}
add_filter( 'the_content', 'citthemestarter_give_linked_images_class' );

/*
 * Register sidebars
 */
register_sidebar(
	array(
		'name'          => esc_html__( 'Sidebar', 'cit' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'cit' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h2>',
	)
);

register_sidebar(
	array(
		'name'          => esc_html__( 'Menu Area', 'cit' ),
		'id'            => 'menu',
		'description'   => esc_html__( 'Add widgets here to appear in menu area.', 'cit' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h2>',
	)
);
/**
 * Footer area 1.
 *
 * @return array
 */
function citthemestarter_footer_1() {
	return array(
		'name' => esc_html__( 'Footer Widget Column 1', 'cit' ),
		'id' => 'footer',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'cit' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h2>',
	);
}
/**
 * Footer area 2.
 *
 * @return array
 */
function citthemestarter_footer_2() {
	return array(
		'name' => esc_html__( 'Footer Widget Column 2', 'cit' ),
		'id' => 'footer-2',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'cit' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h2>',
	);
}
/**
 * Footer area 3.
 *
 * @return array
 */
function citthemestarter_footer_3() {
	return array(
		'name' => esc_html__( 'Footer Widget Column 3', 'cit' ),
		'id' => 'footer-3',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'cit' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h2>',
	);
}
/**
 * Footer area 4.
 *
 * @return array
 */
function citthemestarter_footer_4() {
	return array(
		'name' => esc_html__( 'Footer Widget Column 4', 'cit' ),
		'id' => 'footer-4',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'cit' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h2>',
	);
}

add_action( 'widgets_init',             'citthemestarter_all_widgets' );
add_action( 'admin_bar_init',           'citthemestarter_widgets' );

/**
 * All widgets.
 */
function citthemestarter_all_widgets() {
	/**
	 * Register all zones for availability in customizer
	 */
	register_sidebar(
		citthemestarter_footer_1()
	);
	register_sidebar(
		citthemestarter_footer_2()
	);
	register_sidebar(
		citthemestarter_footer_3()
	);
	register_sidebar(
		citthemestarter_footer_4()
	);
}

/**
 * Widgets handler
 */
function citthemestarter_widgets() {
	unregister_sidebar( 'footer' );
	unregister_sidebar( 'footer-2' );
	unregister_sidebar( 'footer-3' );
	unregister_sidebar( 'footer-4' );
	if ( get_theme_mod( 'cit_footer_area_widget_area', false ) ) {
		$footer_columns = intval( get_theme_mod( 'cit_footer_area_widgetized_columns', 1 ) );
		if ( $footer_columns >= 1 ) {
			register_sidebar(
				citthemestarter_footer_1()
			);
		}

		if ( $footer_columns >= 2 ) {
			register_sidebar(
				citthemestarter_footer_2()
			);
		}

		if ( $footer_columns >= 3 ) {
			register_sidebar(
				citthemestarter_footer_3()
			);
		}
		if ( 4 === $footer_columns ) {
			register_sidebar(
				citthemestarter_footer_4()
			);
		}
	}

}

/**
 * Is header top displayed
 *
 * @return bool
 */
function citthemestarter_is_the_header_top_displayed() {
	if ( get_theme_mod( citthemestarter_DISABLE_HEADER_TOPBAR, false ) ) {
		return false;
	} elseif ( function_exists( 'get_field' ) ) {
		if ( is_page() && ! ( function_exists( 'is_shop' ) && is_shop() ) ) {
			return ! get_field( 'field_58c800e5a7730' );
		} elseif ( function_exists( 'is_shop' ) && is_shop() && get_option( 'woocommerce_shop_page_id' ) ) {
			return ! get_field( 'field_58c800e5a7730', get_option( 'woocommerce_shop_page_id' ) );
		} elseif ( is_singular() ) {
			return ! get_field( 'field_58c800e5a7731' );
		} else {
			return true;
		}
	} else {
		return true;
	}
}

/**
 * Is header displayed
 *
 * @return bool
 */
function citthemestarter_is_the_header_displayed() {
	if ( get_theme_mod( citthemestarter_DISABLE_HEADER, false ) ) {
		return false;
	} elseif ( function_exists( 'get_field' ) ) {
		if ( is_page() && ! ( function_exists( 'is_shop' ) && is_shop() ) ) {
			return ! get_field( 'field_58c800e5a7722' );
		} elseif ( function_exists( 'is_shop' ) && is_shop() && get_option( 'woocommerce_shop_page_id' ) ) {
			return ! get_field( 'field_58c800e5a7722', get_option( 'woocommerce_shop_page_id' ) );
		} elseif ( is_singular() ) {
			return ! get_field( 'field_58c7e3f0b7dfb' );
		} else {
			return true;
		}
	} else {
		return true;
	}
}

/**
 * Is footer displayed.
 *
 * @return bool
 */
function citthemestarter_is_the_footer_displayed() {
	if ( get_theme_mod( citthemestarter_DISABLE_FOOTER, false ) ) {
		return false;
	} elseif ( function_exists( 'get_field' ) ) {
		if ( is_page() && ! ( function_exists( 'is_shop' ) && is_shop() ) ) {
			return ! get_field( 'field_58c800faa7723' );
		} elseif ( function_exists( 'is_shop' ) && is_shop() && get_option( 'woocommerce_shop_page_id' ) ) {
			return ! get_field( 'field_58c800faa7723', get_option( 'woocommerce_shop_page_id' ) );
		} elseif ( is_singular() ) {
			return ! get_field( 'field_58c7e40db7dfc' );
		} else {
			return true;
		}
	} else {
		return true;
	}
}

/**
 * Get header container class.
 *
 * @return string
 */
function citthemestarter_get_header_container_class() {
	if ( get_theme_mod( 'cit_header_top_header_width', 'boxed' ) === 'full_width' ) {
		return 'container-fluid';
	} elseif ( get_theme_mod( 'cit_header_top_header_width', 'custom_container' ) === 'custom_container' ) {
		return 'custom_container';
	} else {
		return 'container';
	}
}

/**
 * Get header image container class.
 *
 * @return string
 */
function citthemestarter_get_header_image_container_class() {
	if ( get_theme_mod( 'cit_overall_site_featured_image_width', 'full_width' ) === 'full_width' ) {
		return 'container-fluid';
	} else {
		return 'container';
	}
}

/**
 * Get contant container class
 *
 * @return string
 */
function citthemestarter_get_content_container_class() {
	if ( 'full_width' === get_theme_mod( 'cit_overall_content_area_size', 'boxed' ) ) {
		return 'container-fluid';
	} else {
		return 'container';
	}
}

/**
 * Check needed sidebar
 *
 * @return string
 */
function citthemestarter_check_needed_sidebar() {
	if ( is_page() && ! ( function_exists( 'is_shop' ) && is_shop() ) ) {
		return citthemestarter_PAGE_SIDEBAR;
	} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		return citthemestarter_PAGE_SIDEBAR;
	} elseif ( is_singular() ) {
		return citthemestarter_POST_SIDEBAR;
	} elseif ( is_archive() || is_category() || is_search() || is_front_page() || is_home() ) {
		return citthemestarter_ARCHIVE_AND_CATEGORY_SIDEBAR;
	} else {
		return 'none';
	}
}

/**
 * Specify sidebar
 *
 * @return null
 */
function citthemestarter_specify_sidebar() {
	if ( is_page() ) {
		$value = function_exists( 'get_field' ) ? get_field( 'field_589f5a321f0bc' ) : null;
	} elseif ( is_singular() ) {
		$value = function_exists( 'get_field' ) ? get_field( 'field_589f5b1d656ca' ) : null;
	} elseif ( ( is_archive() || is_category() || is_search() || is_front_page() || is_home() ) && ! ( function_exists( 'is_shop' ) && is_shop() ) ) {
		if ( is_front_page() ) {
			$value = function_exists( 'get_field' ) ? get_field( 'field_589f5a321f0bc', get_option( 'page_on_front' ) ) : null;
		} elseif ( is_home() ) {
			$value = function_exists( 'get_field' ) ? get_field( 'field_589f5a321f0bc', get_option( 'page_for_posts' ) ) : null;
		} else {
			$value = get_theme_mod( citthemestarter_check_needed_sidebar(), 'none' );
		}
	} elseif ( function_exists( 'is_shop' ) && is_shop() && get_option( 'woocommerce_shop_page_id' ) ) {
		$value = function_exists( 'get_field' ) ? get_field( 'field_589f5a321f0bc', get_option( 'woocommerce_shop_page_id' ) ) : null;
	} else {
		$value = null;
	}

	$value = apply_filters( 'citthemestarter_specify_sidebar', $value );

	if ( 'default' === $value ) {
		return get_theme_mod( citthemestarter_check_needed_sidebar(), 'none' );
	} else {
		$specify_setting = function_exists( 'get_field' ) ? $value : null;
		if ( $specify_setting ) {
			return $specify_setting;
		} else {
			return get_theme_mod( citthemestarter_check_needed_sidebar(), 'none' );
		}
	}
}

/**
 * Is the title displayed
 *
 * @return bool
 */
function citthemestarter_is_the_title_displayed() {
	if ( function_exists( 'get_field' ) ) {
		if ( is_page() && ! ( function_exists( 'is_shop' ) && is_shop() ) ) {
			return (bool) ! get_field( 'field_589f55db2faa9' );
		} elseif ( function_exists( 'is_shop' ) && is_shop() && get_option( 'woocommerce_shop_page_id' ) ) {
			return (bool) ! get_field( 'field_589f55db2faa9', get_option( 'woocommerce_shop_page_id' ) );
		} elseif ( is_singular() ) {
			return (bool) ! get_field( 'field_589f5b9a56207' );
		} else {
			return true;
		}
	} else {
		return true;
	}
}

/**
 * Get main content block class
 *
 * @return string
 */
function citthemestarter_get_maincontent_block_class() {
	switch ( citthemestarter_specify_sidebar() ) {
		case 'none':
			return 'col-md-12';
		case 'left':
			return 'col-md-9 col-md-push-3';
		case 'right':
			return 'col-md-9';
		default:
			return 'col-md-12';
	}
}

/**
 * Get sidebar class
 *
 * @return bool|string
 */
function citthemestarter_get_sidebar_class() {
	switch ( citthemestarter_specify_sidebar() ) {
		case 'none':
			return false;
		case 'left':
			return 'col-md-3 col-md-pull-9';
		case 'right':
			return 'col-md-3';
		default:
			return false;
	}
}

/**
 * Inline styles.
 */
function citthemestarter_inline_styles() {
	wp_register_style( 'citthemestarter-custom-style', get_template_directory_uri() . '/css/customizer-custom.css', array(), false );
	wp_enqueue_style( 'citthemestarter-custom-style' );
	$css = '';

	// Fonts and style.
	$css .= '
	/*Body fonts and style*/
	body,
	#main-menu ul li ul li,
	.comment-content cite,
	.entry-content cite,
	#add_payment_method .cart-collaterals .cart_totals table small,
	.woocommerce-cart .cart-collaterals .cart_totals table small,
	.woocommerce-checkout .cart-collaterals .cart_totals table small,
	.citthemestarter.woocommerce-cart .woocommerce .cart-collaterals .cart_totals .cart-subtotal td,
	.citthemestarter.woocommerce-cart .woocommerce .cart-collaterals .cart_totals .cart-subtotal th,
	.citthemestarter.woocommerce-cart .woocommerce table.cart,
	.citthemestarter.woocommerce .woocommerce-ordering,
	.citthemestarter.woocommerce .woocommerce-result-count,
	.citthemestarter legend,
	.citthemestarter.woocommerce-account .woocommerce-MyAccount-content a.button
	 { font-family: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_body_font_family', 'Roboto' ) ) . '; }
	 body,
	 .sidebar-widget-area a:hover, .sidebar-widget-area a:focus,
	 .sidebar-widget-area .widget_recent_entries ul li:hover, .sidebar-widget-area .widget_archive ul li:hover, .sidebar-widget-area .widget_categories ul li:hover, .sidebar-widget-area .widget_meta ul li:hover, .sidebar-widget-area .widget_recent_entries ul li:focus, .sidebar-widget-area .widget_archive ul li:focus, .sidebar-widget-area .widget_categories ul li:focus, .sidebar-widget-area .widget_meta ul li:focus, .citthemestarter.woocommerce-cart .woocommerce table.cart .product-name a { color: ' . get_theme_mod( 'cit_fonts_and_style_body_primary_color', '#555555' ) . '; }
	  .comment-content table,
	  .entry-content table { border-color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_body_primary_color', '#555555' ) ) . '; }
	  .entry-full-content .entry-author-data .author-biography,
	  .entry-full-content .entry-meta,
	  .nav-links.post-navigation a .meta-nav,
	  .search-results-header h4,
	  .entry-preview .entry-meta li,
	  .entry-preview .entry-meta li a,
	  .entry-content .gallery-caption,
	  .comment-content blockquote,
	  .entry-content blockquote,
	  .wp-caption .wp-caption-text,
	  .comments-area .comment-list .comment-metadata a { color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_body_secondary_text_color', '#777777' ) ) . '; }
	  .comments-area .comment-list .comment-metadata a:hover,
	  .comments-area .comment-list .comment-metadata a:focus { border-bottom-color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_body_secondary_text_color', '#777777' ) ) . '; }
	  a,
	  .comments-area .comment-list .reply a,
	  .comments-area span.required,
	  .comments-area .comment-subscription-form label:before,
	  .entry-preview .entry-meta li a:hover:before,
	  .entry-preview .entry-meta li a:focus:before,
	  .entry-preview .entry-meta li.entry-meta-category:hover:before,
	  .entry-content ol a:hover,
	  .entry-content ul a:hover,
	  .entry-content table a:hover,
	  .entry-content datalist a:hover,
	  .entry-content blockquote a:hover,
	  .entry-content dl a:hover,
	  .entry-content address a:hover,
	  .entry-content p a:focus,
	  .entry-content ol a:focus,
	  .entry-content ul a:focus,
	  .entry-content table a:focus,
	  .entry-content datalist a:focus,
	  .entry-content blockquote a:focus,
	  .entry-content dl a:focus,
	  .entry-content address a:focus,
	  .entry-content ul > li:before,
	  .comment-content p a:hover,
	  .comment-content ol a:hover,
	  .comment-content ul a:hover,
	  .comment-content table a:hover,
	  .comment-content datalist a:hover,
	  .comment-content blockquote a:hover,
	  .comment-content dl a:hover,
	  .comment-content address a:hover,
	  .comment-content p a:focus,
	  .comment-content ol a:focus,
	  .comment-content ul a:focus,
	  .comment-content table a:focus,
	  .comment-content datalist a:focus,
	  .comment-content blockquote a:focus,
	  .comment-content dl a:focus,
	  .comment-content address a:focus,
	  .comment-content ul > li:before,
	  .sidebar-widget-area .widget_recent_entries ul li,
	  .sidebar-widget-area .widget_archive ul li,
	  .sidebar-widget-area .widget_categories ul li,
	  .sidebar-widget-area .widget_meta ul li { color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_body_active_color', '#844DA3' ) ) . '; }
	  .entry-content blockquote, .comment-content { border-left-color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_body_active_color', '#844DA3' ) ) . '; }
	  
	  html, #main-menu ul li ul li { font-size: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_body_font_size', '16px' ) ) . ' }
	  body {
		letter-spacing: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_body_letter_spacing', '0.01rem' ) ) . ';
		font-weight: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_body_weight', '400' ) ) . ';
		font-style: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_body_font_style', 'normal' ) ) . ';
		text-transform: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_body_capitalization', 'none' ) ) . ';
	  }
	  
	  .comment-content address,
	  .comment-content blockquote,
	  .comment-content datalist,
	  .comment-content dl,
	  .comment-content ol,
	  .comment-content p,
	  .comment-content table,
	  .comment-content ul,
	  .entry-content address,
	  .entry-content blockquote,
	  .entry-content datalist,
	  .entry-content dl,
	  .entry-content ol,
	  .entry-content table,
	  .entry-content ul {
		margin-top: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_body_margin_top', '0' ) ) . ';
		margin-bottom: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_body_margin_bottom', '1.5rem' ) ) . ';
	  }
	  
	  /*Buttons font and style*/
	  .comments-area .form-submit input[type=submit],
	  .blue-button { 
			background-color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_background_color', '#557cbf' ) ) . '; 
			color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_text_color', '#f4f4f4' ) ) . ';
			font-family: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_font_family', 'Roboto' ) ) . ';
			font-size: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_font_size', '16px' ) ) . ';
			font-weight: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_weight', '400' ) ) . ';
			font-style: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_font_style', 'normal' ) ) . ';
			letter-spacing: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_letter_spacing', '0.01rem' ) ) . ';
			line-height: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_line_height', '1' ) ) . ';
			text-transform: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_capitalization', 'none' ) ) . ';
			margin-top: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_margin_top', '0' ) ) . ';
			margin-bottom: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_margin_bottom', '0' ) ) . ';
	  }
	  .citthemestarter .products .added_to_cart {
			font-family: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_font_family', 'Roboto' ) ) . ';
	  }
	  .comments-area .form-submit input[type=submit]:hover, .comments-area .form-submit input[type=submit]:focus,
	  .blue-button:hover, .blue-button:focus, 
	  .entry-content p a.blue-button:hover { 
			background-color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_background_hover_color', '#3c63a6' ) ) . '; 
			color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_text_hover_color', '#f4f4f4' ) ) . '; 
	  }
	  
	  .nav-links.archive-navigation .page-numbers,
	  .citthemestarter.woocommerce nav.woocommerce-pagination ul li .page-numbers {
	        background-color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_background_color', '#557cbf' ) ) . '; 
			color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_text_color', '#f4f4f4' ) ) . ';
	  }
	  
	  .nav-links.archive-navigation a.page-numbers:hover, 
	  .nav-links.archive-navigation a.page-numbers:focus, 
	  .nav-links.archive-navigation .page-numbers.current,
	  .citthemestarter.woocommerce nav.woocommerce-pagination ul li .page-numbers:hover, 
	  .citthemestarter.woocommerce nav.woocommerce-pagination ul li .page-numbers:focus, 
	  .citthemestarter.woocommerce nav.woocommerce-pagination ul li .page-numbers.current {
	        background-color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_background_hover_color', '#3c63a6' ) ) . '; 
			color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_text_hover_color', '#f4f4f4' ) ) . '; 
	  }
	  .citthemestarter.woocommerce button.button,
	  .citthemestarter.woocommerce a.button.product_type_simple,
	  .citthemestarter.woocommerce a.button.product_type_grouped,
	  .citthemestarter.woocommerce a.button.product_type_variable,
	  .citthemestarter.woocommerce a.button.product_type_external,
	  .citthemestarter .woocommerce .buttons a.button.wc-forward,
	  .citthemestarter .woocommerce #place_order,
	  .citthemestarter .woocommerce .button.checkout-button,
	  .citthemestarter .woocommerce .button.wc-backward,
	  .citthemestarter .woocommerce .track_order .button,
	  .citthemestarter .woocommerce .vct-thank-you-footer a,
	  .citthemestarter .woocommerce .woocommerce-EditAccountForm .button,
	  .citthemestarter .woocommerce .woocommerce-MyAccount-content a.edit,
	  .citthemestarter .woocommerce .woocommerce-mini-cart__buttons.buttons a,
	  .citthemestarter .woocommerce .woocommerce-orders-table__cell .button,
	  .citthemestarter .woocommerce a.button,
	  .citthemestarter .woocommerce button.button,
	  .citthemestarter #review_form #respond .form-submit .submit
	   {
	  		background-color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_background_color', '#557cbf' ) ) . '; 
			color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_text_color', '#f4f4f4' ) ) . ';
			font-family: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_font_family', 'Roboto Display' ) ) . ';
			font-size: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_font_size', '16px' ) ) . ';
			font-weight: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_weight', '400' ) ) . ';
			font-style: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_font_style', 'normal' ) ) . ';
			letter-spacing: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_letter_spacing', '0.01rem' ) ) . ';
			line-height: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_line_height', '1' ) ) . ';
			text-transform: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_capitalization', 'none' ) ) . ';
			margin-top: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_margin_top', '0' ) ) . ';
			margin-bottom: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_margin_bottom', '0' ) ) . ';
	  }
	  .citthemestarter.woocommerce button.button.alt.disabled {
            background-color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_background_color', '#557cbf' ) ) . '; 
			color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_text_color', '#f4f4f4' ) ) . ';
	  }
	  .citthemestarter.woocommerce a.button:hover,
	  .citthemestarter.woocommerce a.button:focus,
	  .citthemestarter.woocommerce button.button:hover,
	  .citthemestarter.woocommerce button.button:focus,
	  .citthemestarter .woocommerce #place_order:hover,
	  .citthemestarter .woocommerce .button.checkout-button:hover,
	  .citthemestarter .woocommerce .button.wc-backward:hover,
	  .citthemestarter .woocommerce .track_order .button:hover,
	  .citthemestarter .woocommerce .vct-thank-you-footer a:hover,
	  .citthemestarter .woocommerce .woocommerce-EditAccountForm .button:hover,
	  .citthemestarter .woocommerce .woocommerce-MyAccount-content a.edit:hover,
	  .citthemestarter .woocommerce .woocommerce-mini-cart__buttons.buttons a:hover,
	  .citthemestarter .woocommerce .woocommerce-orders-table__cell .button:hover,
	  .citthemestarter .woocommerce a.button:hover,
	  .citthemestarter #review_form #respond .form-submit .submit:hover
	  .citthemestarter .woocommerce #place_order:focus,
	  .citthemestarter .woocommerce .button.checkout-button:focus,
	  .citthemestarter .woocommerce .button.wc-backward:focus,
	  .citthemestarter .woocommerce .track_order .button:focus,
	  .citthemestarter .woocommerce .vct-thank-you-footer a:focus,
	  .citthemestarter .woocommerce .woocommerce-EditAccountForm .button:focus,
	  .citthemestarter .woocommerce .woocommerce-MyAccount-content a.edit:focus,
	  .citthemestarter .woocommerce .woocommerce-mini-cart__buttons.buttons a:focus,
	  .citthemestarter .woocommerce .woocommerce-orders-table__cell .button:focus,
	  .citthemestarter .woocommerce a.button:focus,
	  .citthemestarter #review_form #respond .form-submit .submit:focus { 
			background-color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_background_hover_color', '#3c63a6' ) ) . '; 
			color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_buttons_text_hover_color', '#f4f4f4' ) ) . '; 
	  }
	';

	// Headers font and style.
	$css .= '
	/*Headers fonts and style*/
	.header-widgetised-area .widget_text,
	 #main-menu > ul > li > a, 
	 .entry-full-content .entry-author-data .author-name, 
	 .nav-links.post-navigation a .post-title, 
	 .comments-area .comment-list .comment-author,
	 .comments-area .comment-list .reply a,
	 .comments-area .comment-form-comment label,
	 .comments-area .comment-form-author label,
	 .comments-area .comment-form-email label,
	 .comments-area .comment-form-url label,
	 .comment-content blockquote,
	 .entry-content blockquote { font-family: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h1_font_family', 'Roboto' ) ) . '; }
	.entry-full-content .entry-author-data .author-name,
	.entry-full-content .entry-meta a,
	.nav-links.post-navigation a .post-title,
	.comments-area .comment-list .comment-author,
	.comments-area .comment-list .comment-author a,
	.search-results-header h4 strong,
	.entry-preview .entry-meta li a:hover,
	.entry-preview .entry-meta li a:focus { color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h1_text_color', '#333333' ) ) . '; }
	
	.entry-full-content .entry-meta a,
	.comments-area .comment-list .comment-author a:hover,
	.comments-area .comment-list .comment-author a:focus,
	.nav-links.post-navigation a .post-title { border-bottom-color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h1_text_color', '#333333' ) ) . '; }

	 
	 h1 {
		color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h1_text_color', '#333333' ) ) . ';
		font-family: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h1_font_family', 'Roboto' ) ) . ';
		font-size: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h1_font_size', '42px' ) ) . ';
		font-weight: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h1_weight', '400' ) ) . ';
		font-style: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h1_font_style', 'normal' ) ) . ';
		letter-spacing: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h1_letter_spacing', '0.01rem' ) ) . ';
		line-height: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h1_line_height', '1.1' ) ) . ';
		margin-top: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h1_margin_top', '0' ) ) . ';
		margin-bottom: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h1_margin_bottom', '2.125rem' ) ) . ';
		text-transform: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h1_capitalization', 'none' ) ) . ';  
	 }
	 h1 a {color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h1_active_color', '#844DA3' ) ) . ';}
	 h1 a:hover, h1 a:focus {color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h1_active_color', '#844DA3' ) ) . ';}
	 h2 {
		color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h2_text_color', '#333333' ) ) . ';
		font-family: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h2_font_family', 'Roboto' ) ) . ';
		font-size: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h2_font_size', '36px' ) ) . ';
		font-weight: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h2_weight', '400' ) ) . ';
		font-style: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h2_font_style', 'normal' ) ) . ';
		letter-spacing: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h2_letter_spacing', '0.01rem' ) ) . ';
		line-height: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h2_line_height', '1.1' ) ) . ';
		margin-top: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h2_margin_top', '0' ) ) . ';
		margin-bottom: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h2_margin_bottom', '0.625rem' ) ) . ';
		text-transform: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h2_capitalization', 'none' ) ) . ';  
	 }
	 h2 a {color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h2_active_color', '#844DA3' ) ) . ';}
	 h2 a:hover, h2 a:focus {color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h2_active_color', '#844DA3' ) ) . ';}
	 h3 {
		color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h3_text_color', '#333333' ) ) . ';
		font-family: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h3_font_family', 'Roboto' ) ) . ';
		font-size: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h3_font_size', '30px' ) ) . ';
		font-weight: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h3_weight', '400' ) ) . ';
		font-style: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h3_font_style', 'normal' ) ) . ';
		letter-spacing: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h3_letter_spacing', '0.01rem' ) ) . ';
		line-height: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h3_line_height', '1.1' ) ) . ';
		margin-top: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h3_margin_top', '0' ) ) . ';
		margin-bottom: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h3_margin_bottom', '0.625rem' ) ) . ';
		text-transform: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h3_capitalization', 'none' ) ) . ';  
	 }
	 h3 a {color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h3_active_color', '#844DA3' ) ) . ';}
	 h3 a:hover, h3 a:focus {color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h3_active_color', '#844DA3' ) ) . ';}
	 h4 {
		color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h4_text_color', '#333333' ) ) . ';
		font-family: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h4_font_family', 'Roboto' ) ) . ';
		font-size: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h4_font_size', '22px' ) ) . ';
		font-weight: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h4_weight', '400' ) ) . ';
		font-style: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h4_font_style', 'normal' ) ) . ';
		letter-spacing: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h4_letter_spacing', '0.01rem' ) ) . ';
		line-height: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h4_line_height', '1.1' ) ) . ';
		margin-top: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h4_margin_top', '0' ) ) . ';
		margin-bottom: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h4_margin_bottom', '0.625rem' ) ) . ';
		text-transform: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h4_capitalization', 'none' ) ) . ';  
	 }
	 h4 a {color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h4_active_color', '#844DA3' ) ) . ';}
	 h4 a:hover, h4 a:focus {color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h4_active_color', '#844DA3' ) ) . ';}
	 h5 {
		color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h5_text_color', '#333333' ) ) . ';
		font-family: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h5_font_family', 'Roboto' ) ) . ';
		font-size: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h5_font_size', '22px' ) ) . ';
		font-weight: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h5_weight', '400' ) ) . ';
		font-style: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h5_font_style', 'normal' ) ) . ';
		letter-spacing: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h5_letter_spacing', '0.01rem' ) ) . ';
		line-height: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h5_line_height', '1.1' ) ) . ';
		margin-top: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h5_margin_top', '0' ) ) . ';
		margin-bottom: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h5_margin_bottom', '0.625rem' ) ) . ';
		text-transform: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h5_capitalization', 'none' ) ) . ';  
	 }
	 h5 a {color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h5_active_color', '#844DA3' ) ) . ';}
	 h5 a:hover, h5 a:focus {color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h5_active_color', '#844DA3' ) ) . ';}
	 h6 {
		color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h6_text_color', '#333333' ) ) . ';
		font-family: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h6_font_family', 'Roboto' ) ) . ';
		font-size: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h6_font_size', '16px' ) ) . ';
		font-weight: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h6_weight', '400' ) ) . ';
		font-style: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h6_font_style', 'normal' ) ) . ';
		letter-spacing: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h6_letter_spacing', '0.01rem' ) ) . ';
		line-height: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h6_line_height', '1.1' ) ) . ';
		margin-top: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h6_margin_top', '0' ) ) . ';
		margin-bottom: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h6_margin_bottom', '0.625rem' ) ) . ';
		text-transform: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h6_capitalization', 'none' ) ) . ';  
	 }
	 h6 a {color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h6_active_color', '#844DA3' ) ) . ';}
	 h6 a:hover, h6 a:focus {color: ' . esc_html( get_theme_mod( 'cit_fonts_and_style_h6_active_color', '#844DA3' ) ) . ';}
	';

	$cit_footer_area_contact_bg = get_theme_mod( 'cit_footer_area_contact_bg', '#ffffff' );
	if ( true === get_theme_mod( 'cit_footer_area_contact_widget_area', true ) || '#ffffff' !== $cit_footer_area_contact_bg ) {
		$css .= '
		/*Header and menu area background color*/
		.footer-contact-area {
			background-image: url(' . esc_html( $cit_footer_area_contact_bg ) . ');
		}
		';
	}

	$banner_image = get_field( 'banner_image' );
	if (!empty($banner_image) ){
		$css .= '
		/*Header and menu area background color*/
		.top_banner_bg {background-image: url('.$banner_image.');}
		';
	}

	$header_and_menu_area_background = get_theme_mod( 'cit_header_background', '#ffffff' );
	if ( true === get_theme_mod( 'cit_header_reserve_space_for_header', true ) || '#ffffff' !== $header_and_menu_area_background ) {
		$css .= '
		/*Header and menu area background color*/
		#header .navbar .navbar-wrapper,
		body.navbar-no-background #header .navbar.fixed.scroll,
		body.header-full-width-boxed #header .navbar,
		body.header-full-width #header .navbar {
			background-color: ' . esc_html( $header_and_menu_area_background ) . ';
		}
		
		@media only screen and (min-width: 768px) {
			body:not(.menu-sandwich) #main-menu ul li ul { background-color: ' . esc_html( $header_and_menu_area_background ) . '; }
		}
		body.navbar-no-background #header .navbar {background-color: transparent;}
		';
	}

	$header_and_menu_area_text_color = get_theme_mod( 'cit_header_text_color', '#555555' );
	if ( '#555555' !== $header_and_menu_area_text_color ) {
		$css .= '
		/*Header and menu area text color*/
		#header { color: ' . esc_html( $header_and_menu_area_text_color ) . ' }
		
		@media only screen and (min-width: 768px) {
			body:not(.menu-sandwich) #main-menu ul li,
			body:not(.menu-sandwich) #main-menu ul li a,
			body:not(.menu-sandwich) #main-menu ul li ul li a { color:  ' . esc_html( $header_and_menu_area_text_color ) . ' }
		}
		';
	}

	$header_and_menu_area_text_active_color = get_theme_mod( 'cit_header_text_active_color', '#333333' );
	if ( '#333333' !== $header_and_menu_area_text_active_color ) {
		$css .= '
		/*Header and menu area active text color*/
		#header a:hover {
			color: ' . esc_html( $header_and_menu_area_text_active_color ) . ';
			border-bottom-color: ' . esc_html( $header_and_menu_area_text_active_color ) . ';
		}
		
		@media only screen and (min-width: 768px) {
			body:not(.menu-sandwich) #main-menu ul li a:hover,
			body:not(.menu-sandwich) #main-menu ul li.current-menu-item > a,
			body:not(.menu-sandwich) #main-menu ul li ul li a:focus, body:not(.menu-sandwich) #main-menu ul li ul li a:hover,
			body:not(.menu-sandwich) .sandwich-color-light #main-menu>ul>li.current_page_item>a,
			body:not(.menu-sandwich) .sandwich-color-light #main-menu>ul ul li.current_page_item>a {
				color: ' . esc_html( $header_and_menu_area_text_active_color ) . ';
				border-bottom-color: ' . esc_html( $header_and_menu_area_text_active_color ) . ';
			}
		}
		';
	}

	$header_padding = get_theme_mod( 'cit_header_padding', '25px' );
	if ( '25px' !== $header_padding ) {
		$css .= '
		/* Header padding */

		.navbar-wrapper { padding: ' . esc_html( $header_padding ) . ' 15px; }
		';
	}

	$header_sandwich_icon_color = get_theme_mod( 'cit_header_sandwich_icon_color', '#ffffff' );
	if ( '#ffffff' !== $header_sandwich_icon_color ) {
		$css .= '
			.navbar-toggle .icon-bar {background-color: ' . esc_html( $header_sandwich_icon_color ) . ';}
		';
	}

	$header_and_menu_area_menu_hover_background = get_theme_mod( 'cit_header_menu_hover_background', '#eeeeee' );
	if ( '#eeeeee' !== $header_and_menu_area_menu_hover_background ) {
		$css .= '
		/*Header and menu area menu hover background color*/
		@media only screen and (min-width: 768px) { body:not(.menu-sandwich) #main-menu ul li ul li:hover > a { background-color: ' . esc_html( $header_and_menu_area_menu_hover_background ) . '; } }
		';
	}

	// Featured image custom height.
	$vct_featured_image_custom_height = get_theme_mod( 'cit_overall_site_featured_image_custom_height', '400px' );
	if ( is_numeric( $vct_featured_image_custom_height ) ) {
		$vct_featured_image_custom_height .= 'px';
	}
	if ( get_theme_mod( 'cit_overall_site_featured_image_height', 'auto' ) === 'custom' ) {
		$css .= '
		/*Featured image custom height*/
		.header-image .fade-in-img { height: ' . esc_html( $vct_featured_image_custom_height ) . '; }
		';

	}

	$content_area_background = get_theme_mod( 'cit_overall_site_content_background', '#ffffff' );
	if ( '#ffffff' !== $content_area_background ) {
		$css .= '
		/*Content area background*/
		.content-wrapper { background-color: ' . esc_html( $content_area_background ) . '; }
		';
	}

	$content_area_comments_background = get_theme_mod( 'cit_overall_site_comments_background', '#f4f4f4' );
	if ( '#f4f4f4' !== $content_area_comments_background ) {
		$css .= '
		/*Comments background*/
		.comments-area { background-color: ' . esc_html( $content_area_comments_background ) . '; }
		';
	}

	$footer_area_background = get_theme_mod( 'cit_footer_area_background', '#333333' );
	if ( '#333333' !== $footer_area_background ) {
		// Work out if hash given.
		$hex = str_replace( '#', '', $footer_area_background );

		// HEX TO RGB.
		$rgb = array( hexdec( substr( $hex,0,2 ) ), hexdec( substr( $hex,2,2 ) ), hexdec( substr( $hex,4,2 ) ) );
		// CALCULATE.
		for ( $i = 0; $i < 3; $i++ ) {
			$rgb[ $i ] = round( $rgb[ $i ] * 1.1 );

			// In case rounding up causes us to go to 256.
			if ( $rgb[ $i ] > 255 ) {
				$rgb[ $i ] = 255;
			}
		}
		// RBG to Hex.
		$hex = '';
		for ( $i = 0; $i < 3; $i++ ) {
			// Convert the decimal digit to hex.
			$hex_digit = dechex( $rgb[ $i ] );
			// Add a leading zero if necessary.
			if ( strlen( $hex_digit ) === 1 ) {
				$hex_digit = '0' . $hex_digit;
			}
			// Append to the hex string.
			$hex .= $hex_digit;
		}
		$footer_widget_area_background = '#' . $hex;
		$css .= '
		/*Footer area background color*/
		#footer { background-color: ' . esc_html( $footer_area_background ) . '; }
		.footer-widget-area { background-color: ' . esc_html( $footer_widget_area_background ) . '; }
		';
	}

	$footer_area_text_color = get_theme_mod( 'cit_footer_area_text_color', '#777777' );
	if ( '#777777' !== $footer_area_text_color ) {
		$css .= '
		/*Footer area text color*/
		#footer,
		#footer .footer-socials ul li a span {color: ' . esc_html( $footer_area_text_color ) . '; }
		';
	}

	$footer_area_text_active_color = get_theme_mod( 'cit_footer_area_text_active_color', '#ffffff' );
	if ( '#ffffff' !== $footer_area_text_active_color ) {
		$css .= '
		/*Footer area text active color*/
		#footer a,
		#footer .footer-socials ul li a:hover span { color: ' . esc_html( $footer_area_text_active_color ) . '; }
		#footer a:hover { border-bottom-color: ' . esc_html( $footer_area_text_active_color ) . '; }
		';
	}
	$on_sale_color = get_theme_mod( 'woo_on_sale_color', '#FAC917' );
	if ( '#FAC917' !== $on_sale_color ) {
		$css .= '
		/*Woocommerce*/
		.vct-sale svg>g>g {fill: ' . esc_html( $on_sale_color ) . ';}
		';
	}

	$cit_footer_area_background_image = get_theme_mod( 'cit_footer_area_background_image', '#fff' );
	if ( '#fff' !== $cit_footer_area_background_image ) {
		$css .= '
		/*Footer bg*/
		.main-footer-area {
			background-image: url(' . esc_html( $cit_footer_area_background_image ) . ');
		}';
	}

	$price_tag_color = get_theme_mod( 'woo_price_tag_color', '#2b4b80' );
	$css .= '
	.citthemestarter.woocommerce ul.products li.product .price,
	.citthemestarter.woocommerce div.product p.price,
	.citthemestarter.woocommerce div.product p.price ins,
	.citthemestarter.woocommerce div.product span.price,
	.citthemestarter.woocommerce div.product span.price ins,
	.citthemestarter.woocommerce.widget .quantity,
	.citthemestarter.woocommerce.widget del,
	.citthemestarter.woocommerce.widget ins,
	.citthemestarter.woocommerce.widget span.woocommerce-Price-amount.amount,
	.citthemestarter.woocommerce p.price ins,
	.citthemestarter.woocommerce p.price,
	.citthemestarter.woocommerce span.price,
	.citthemestarter.woocommerce span.price ins,
	.citthemestarter .woocommerce.widget span.amount,
	.citthemestarter .woocommerce.widget ins {
		color: ' . esc_html( $price_tag_color ) . '
	}
	';

	$old_price_tag_color = get_theme_mod( 'woo_old_price_tag_color', '#d5d5d5' );
	$css .= '
	.citthemestarter.woocommerce span.price del,
	.citthemestarter.woocommerce p.price del,
	.citthemestarter.woocommerce p.price del span,
	.citthemestarter.woocommerce span.price del span,
	.citthemestarter .woocommerce.widget del,
	.citthemestarter .woocommerce.widget del span.amount,
	.citthemestarter.woocommerce ul.products li.product .price del {
		color: ' . esc_html( $old_price_tag_color ) . '
	}
	';

	$cart_color = get_theme_mod( 'woo_cart_color', '#2b4b80' );
	$cart_text_color = get_theme_mod( 'woo_cart_text_color', '#fff' );
	$css .= '
	.citthemestarter .vct-cart-items-count {
	    background: ' . esc_html( $cart_color ) . ';
	    color: ' . esc_html( $cart_text_color ) . ';
	}
	.citthemestarter .vct-cart-wrapper svg g>g {
	    fill: ' . esc_html( $cart_color ) . ';
	}
	';

	$link_color = get_theme_mod( 'woo_link_color', '#d5d5d5' );
	$css .= '
	.citthemestarter.woocommerce div.product .entry-categories a,
	.citthemestarter.woocommerce div.product .woocommerce-tabs ul.tabs li a
	{
		color: ' . esc_html( $link_color ) . ';
	}
	';

	$link_hover_color = get_theme_mod( 'woo_link_hover_color', '#2b4b80' );
	$css .= '
	.citthemestarter.woocommerce div.product .entry-categories a:hover,
	.citthemestarter.woocommerce-cart .woocommerce table.cart .product-name a:hover,
	.citthemestarter.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
	.citthemestarter.woocommerce div.product .entry-categories a:focus,
	.citthemestarter.woocommerce-cart .woocommerce table.cart .product-name a:focus,
	.citthemestarter.woocommerce div.product .woocommerce-tabs ul.tabs li a:focus,
	{
		color: ' . esc_html( $link_hover_color ) . ';
	}
	';

	$link_active_color = get_theme_mod( 'woo_link_active_color', '#2b4b80' );
	$css .= '
	.citthemestarter.woocommerce div.product .woocommerce-tabs ul.tabs li.active a
	{
		color: ' . esc_html( $link_active_color ) . ';
	}
	.citthemestarter.woocommerce div.product .woocommerce-tabs ul.tabs li.active a:before
	{
		background: ' . esc_html( $link_active_color ) . ';
	}
	';

	$outline_button_color = get_theme_mod( 'woo_outline_button_color', '#4e4e4e' );
	$css .= '
	.woocommerce button.button[name="update_cart"],
    .button[name="apply_coupon"],
    .vct-checkout-button,
    .woocommerce button.button:disabled, 
    .woocommerce button.button:disabled[disabled]
	{
		color: ' . esc_html( $outline_button_color ) . ';
	}';

	$price_filter_widget_color = get_theme_mod( 'woo_price_filter_widget_color', '#2b4b80' );
	$css .= '
	.citthemestarter .woocommerce.widget.widget_price_filter .ui-slider .ui-slider-handle,
	.citthemestarter .woocommerce.widget.widget_price_filter .ui-slider .ui-slider-range
	{
		background-color: ' . esc_html( $price_filter_widget_color ) . ';
	}';

	$widget_links_color = get_theme_mod( 'woo_widget_links_color', '#000' );
	$css .= '
	.citthemestarter .woocommerce.widget li a
	{
		color: ' . esc_html( $widget_links_color ) . ';
	}';

	$widget_links_hover_color = get_theme_mod( 'woo_widget_links_hover_color', '#2b4b80' );
	$css .= '
	.citthemestarter .woocommerce.widget li a:hover,
	.citthemestarter .woocommerce.widget li a:focus
	{
		color: ' . esc_html( $widget_links_hover_color ) . ';
	}';

	$delete_icon_color = get_theme_mod( 'woo_delete_icon_color', '#d5d5d5' );
	$css .= '
	.citthemestarter.woocommerce-cart .woocommerce table.cart a.remove:before,
	.citthemestarter .woocommerce.widget .cart_list li a.remove:before,
	.citthemestarter.woocommerce-cart .woocommerce table.cart a.remove:after,
	.citthemestarter .woocommerce.widget .cart_list li a.remove:after
	{
		background-color: ' . esc_html( $delete_icon_color ) . ';
	}';

	wp_add_inline_style( 'citthemestarter-custom-style', $css );
}
add_action( 'wp_enqueue_scripts', 'citthemestarter_inline_styles' );

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/tgmpa/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'citthemestarter_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 */
function citthemestarter_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 */
	$plugins = array(


		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => 'Advanced Custom Fields PRO',
			'slug'      => 'advanced-custom-fields',
			'source'             => get_template_directory_uri() . '/plugins/advanced-custom-fields-pro.zip',
			'required'  => true,
		),
		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => true,
		),
		array(
			'name'      => 'Visual composer',
			'slug'      => 'visual-composer',
			'source'    => get_template_directory_uri() . '/plugins/js_composer.zip',
			'required'  => true,
		)


	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 */
	$config = array(
		'id'           => 'cit',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);
	tgmpa( $plugins, $config );
}

/**
 *  For backward compatibility for background
 *
 * @deprecated 1.3
 */
function citthemestarter_set_old_styles() {
	if ( get_theme_mod( 'cit_overall_site_bg_color' ) ) {
		set_theme_mod( 'background_color', str_replace( '#', '', get_theme_mod( 'cit_overall_site_bg_color' ) ) );
		remove_theme_mod( 'cit_overall_site_bg_color' );
	}

	if ( get_theme_mod( 'cit_overall_site_enable_bg_image' ) ) {

		set_theme_mod( 'background_attachment', 'scroll' );
		set_theme_mod( 'background_image', esc_url_raw( get_theme_mod( 'cit_overall_site_bg_image' ) ) );
		if ( 'repeat' === get_theme_mod( 'cit_overall_site_bg_image_style' ) ) {
			set_theme_mod( 'background_repeat', 'repeat' );
		} else {
			set_theme_mod( 'background_repeat', 'no-repeat' );
			set_theme_mod( 'background_size', esc_html( get_theme_mod( 'cit_overall_site_bg_image_style' ) ) );
		}

		remove_theme_mod( 'cit_overall_site_bg_image' );
		remove_theme_mod( 'cit_overall_site_bg_image_style' );
		remove_theme_mod( 'cit_overall_site_enable_bg_image' );
	}
}

/**
 * For backward compatibility content area size
 *
 * @deprecated 2.0.4
 */
function citthemestarter_set_old_content_size() {
	if ( get_theme_mod( 'vct_content_area_size' ) ) {
		set_theme_mod( 'cit_overall_content_area_size', get_theme_mod( 'vct_content_area_size' ) );
		remove_theme_mod( 'vct_content_area_size' );
	}
}


/**
 *  WooCommerce support
 */
function citthemestarter_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'citthemestarter_support' );

/**
 *  WooCommerce single product gallery
 */
function citthemestarter_woo_setup() {
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'citthemestarter_woo_setup' );

/**
 *  WooCommerce single product categories layout
 */
function citthemestarter_woo_categories() {
	global $product;
	// @codingStandardsIgnoreLine
	echo wc_get_product_category_list( $product->get_id(), ' ', '<div class="entry-categories"><span class="screen-reader-text">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'cit' ) . '</span>', '</div>' );
}
add_action( 'woocommerce_single_product_summary', 'citthemestarter_woo_categories', 1 );

/**
 * WooCommerce single product tags layout
 */
function citthemestarter_woo_tags() {
	global $product;
	// @codingStandardsIgnoreLine
	echo wc_get_product_tag_list( $product->get_id(), ' ', '<div class="entry-tags"><span class="screen-reader-text">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'cit' ) . '</span>', '</div>' );
}
add_action( 'woocommerce_single_product_summary', 'citthemestarter_woo_tags', 65 );

/**
 * WooCommerce single product price layout
 *
 * @param product $price layout.
 * @param product $regular_price number.
 * @param product $sale_price number.
 * @return string
 */
function citthemestarter_woo_format_sale_price( $price, $regular_price, $sale_price ) {
	$price = '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins> <del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';

	return $price;
}
add_filter( 'woocommerce_format_sale_price', 'citthemestarter_woo_format_sale_price', 10, 3 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 25 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );

/**
 * WooCommerce single product sale flash layout
 *
 * @param single $post data.
 * @param single $product data.
 * @return string
 */
function citthemestarter_woo_sale_flash( $post, $product ) {
	$sale = <<<HTML
 <span class="onsale vct-sale">
	<svg width="48px" height="48px" viewBox="0 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g id="Product-Open" transform="translate(-20.000000, -24.000000)" fill-rule="nonzero" fill="#FAC917">
                <g id="Image" transform="translate(0.000000, 4.000000)">
                    <g id="Discount" transform="translate(20.000000, 20.000000)">
                        <ellipse id="Oval" cx="17.5163" cy="19.8834847" rx="2.04" ry="2.00245399"></ellipse>
                        <ellipse id="Oval" cx="30.4763" cy="28.011092" rx="2.04" ry="2.00245399"></ellipse>
                        <path d="M47.2963,26.5975951 L46.5563,25.606184 C45.7563,24.5264294 45.7363,23.0638528 46.5263,21.9644663 L47.2463,20.9632393 C48.3463,19.4319509 47.8363,17.3018896 46.1463,16.408638 L45.0463,15.8294969 C43.8463,15.2012761 43.1863,13.8859387 43.4163,12.5607853 L43.6263,11.3534233 C43.9463,9.50802454 42.5363,7.80004908 40.6263,7.72152147 L39.3763,7.67244172 C38.0163,7.61354601 36.8363,6.71047853 36.4563,5.42458896 L36.1063,4.24667485 C35.5763,2.44053988 33.5563,1.50802454 31.7963,2.25403681 L30.6463,2.7350184 C29.3963,3.26507975 27.9363,2.95096933 27.0263,1.94974233 L26.1963,1.0368589 C24.9263,-0.357006135 22.6963,-0.347190184 21.4363,1.0761227 L20.6163,1.99882209 C19.7163,3.00986503 18.2663,3.34360736 17.0063,2.83317791 L15.8463,2.36201227 C14.0763,1.64544785 12.0763,2.61722699 11.5663,4.42336196 L11.2363,5.61109202 C10.8763,6.90679755 9.7163,7.82949693 8.3563,7.89820859 L7.1063,7.96692025 C5.1963,8.07489571 3.8163,9.80250307 4.1663,11.6479018 L4.3963,12.8552638 C4.6463,14.1706012 4.0063,15.4957546 2.8163,16.1436074 L1.7263,16.7423804 C0.0563,17.6552638 -0.4237,19.7951411 0.7063,21.3067975 L1.4463,22.2982086 C2.2463,23.3779632 2.2663,24.8405399 1.4763,25.9399264 L0.7563,26.9411534 C-0.3437,28.4724417 0.1663,30.6025031 1.8563,31.4957546 L2.9563,32.0748957 C4.1563,32.7031166 4.8163,34.018454 4.5863,35.3436074 L4.3763,36.5509693 C4.0563,38.3963681 5.4663,40.1043436 7.3763,40.1828712 L8.6263,40.2319509 C9.9863,40.2908466 11.1663,41.1939141 11.5463,42.4798037 L11.8963,43.6577178 C12.4263,45.4638528 14.4463,46.3963681 16.2063,45.6503558 L17.3563,45.1693742 C18.6063,44.6393129 20.0663,44.9534233 20.9763,45.9546503 L21.8063,46.8675337 C23.0863,48.2613988 25.3163,48.2515828 26.5663,46.8282699 L27.3863,45.9055706 C28.2863,44.8945276 29.7363,44.5607853 30.9963,45.0712147 L32.1563,45.5423804 C33.9263,46.2589448 35.9263,45.2871656 36.4363,43.4810307 L36.7663,42.2933006 C37.1263,40.9975951 38.2863,40.0748957 39.6463,40.006184 L40.8963,39.9374724 C42.8063,39.8294969 44.1863,38.1018896 43.8363,36.2564908 L43.6063,35.0491288 C43.3563,33.7337914 43.9963,32.408638 45.1863,31.7607853 L46.2763,31.1620123 C47.9463,30.2589448 48.4263,28.1190675 47.2963,26.5975951 Z M12.5863,19.8834847 C12.5863,17.213546 14.7863,15.0540368 17.5063,15.0540368 C20.2263,15.0540368 22.4263,17.213546 22.4263,19.8834847 C22.4263,22.5534233 20.2263,24.7129325 17.5063,24.7129325 C14.7863,24.7129325 12.5863,22.5436074 12.5863,19.8834847 Z M18.4563,32.3399264 C18.0363,32.8405399 17.2763,32.9092515 16.7663,32.4969816 L16.7663,32.4969816 C16.2563,32.0847117 16.1863,31.3386994 16.6063,30.8380859 L29.5163,15.5742822 C29.9363,15.0736687 30.6963,15.0049571 31.2063,15.417227 C31.7163,15.8294969 31.7863,16.5755092 31.3663,17.0761227 L18.4563,32.3399264 Z M30.4763,32.8405399 C27.7563,32.8405399 25.5563,30.6810307 25.5563,28.011092 C25.5563,25.3411534 27.7563,23.1816442 30.4763,23.1816442 C33.1963,23.1816442 35.3963,25.3411534 35.3963,28.011092 C35.3963,30.6810307 33.1963,32.8405399 30.4763,32.8405399 Z" id="Shape"></path>
                    </g>
                </g>
            </g>
        </g>
    </svg>
</span>
HTML;

	return $sale;
}
add_filter( 'woocommerce_sale_flash', 'citthemestarter_woo_sale_flash', 10, 2 );

/**
 * Update cart woocommerce cart item count
 */
function citthemestarter_woo_cart_count() {
	if ( function_exists( 'WC' ) ) {
		echo esc_html( WC()->cart->get_cart_contents_count() );
	}
	die;
}
add_action( 'wp_ajax_citthemestarter_woo_cart_count', 'citthemestarter_woo_cart_count' );
add_action( 'wp_ajax_nopriv_citthemestarter_woo_cart_count', 'citthemestarter_woo_cart_count' );

/**
 * Add variable container
 *
 * @param dropdown $html content.
 * @return string
 */
function citthemestarter_woo_variable_container( $html ) {
	return '<div class="vct-variable-container">' . $html . '</div>';
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'citthemestarter_woo_variable_container' );

/**
 * Removes the "shop" title on the main shop page
 *
 * @access public
 * @return bool
 */
function citthemestarter_woo_hide_page_title() {
	return citthemestarter_is_the_title_displayed();
}
add_filter( 'woocommerce_show_page_title', 'citthemestarter_woo_hide_page_title' );

// Move payments after customer details.
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_checkout_after_customer_details', 'woocommerce_checkout_payment', 20 );



add_action('wp_ajax_load_default_blogs_by_ajax', 'load_posts_by_ajax_default_blogs_callback');
add_action('wp_ajax_nopriv_load_default_blogs_by_ajax', 'load_posts_by_ajax_default_blogs_callback');

function load_posts_by_ajax_default_blogs_callback() {
  check_ajax_referer('load_more_default_blogs', 'security');
  $paged = $_POST['page'];
  $args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => '6',
    'paged' => $paged,
  );
  $my_posts = new WP_Query( $args );
  if ( $my_posts->have_posts() ) :
    while ( $my_posts->have_posts() ) : $my_posts->the_post();
      $thumbnails = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full');
      
      //var_dump($color);
    ?>
    <div class="col-md-4 col-sm-6">
		<article class="singleBlog-post">	
			<div class="singleBlogthum">
				<span><?php echo get_the_date( 'j M y' ); ?></span>
				<img src="<?php echo $thumbnails[0]; ?>" alt="">
			</div>	
			<div class="blogContent">
				<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<a href="<?php the_permalink(); ?>" class="readMore3"><span>Read More</span> <i class="fa fa-angle-right"></i></a>
			</div>
		</article>
	</div>
    <?php endwhile ?>
    <?php
  endif;

  wp_die();
}

/*Ajax post load more*/

add_action('wp_ajax_load_default_services_by_ajax', 'load_posts_by_ajax_default_services_callback');
add_action('wp_ajax_nopriv_load_default_services_by_ajax', 'load_posts_by_ajax_default_services_callback');

function load_posts_by_ajax_default_services_callback() {
  check_ajax_referer('load_more_default_services', 'security');
  $paged = $_POST['page'];
  $args = array(
    'post_type' => 'services',
    'post_status' => 'publish',
    'posts_per_page' => '6',
    'paged' => $paged,
  );
  $my_posts = new WP_Query( $args );
  if ( $my_posts->have_posts() ) :
    while ( $my_posts->have_posts() ) : $my_posts->the_post();
    	$thumbnails = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full');
		$count++;
		$even_odd_class = ( ($count % 2) == 0 ) ? "floatright" : "floatleft"; 
		$even_odd_class2 = ( ($count % 2) == 0 ) ? "floatleft" : "floatright"; 
      //var_dump($color);
    ?>
    <div class="singleSerivesItm clearfix">	
		<div class="col-md-6 col-sm-6 <?php echo $even_odd_class; ?>">	
			<div class="singleServicethum">
				<img src="<?php echo $thumbnails[0]; ?>" alt="">
			</div>	
		</div>
		<div class="col-md-6 col-sm-6 <?php echo $even_odd_class; ?>">
			<div class="ServicesContent">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="contentService">
					<?php the_content(); ?>
				</div>
				<a href="<?php the_permalink(); ?>" class="readMore2"><span>Browse All Energy Services</a>
			</div>
		</div>
	</div>
    <?php endwhile ?>
    <?php
  endif;

  wp_die();
}



function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function wpb_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    wpb_set_post_views($post_id);
}
add_action( 'wp_head', 'wpb_track_post_views');

function wpb_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}



if( class_exists( 'WP_Customize_Control' ) ):
	class WP_Customize_Latest_Post_Control extends WP_Customize_Control {
		public $type = 'latest_post_dropdown';
		public $post_type = 'wpcf7_contact_form';
 
		public function render_content() {

		$latest = new WP_Query( array(
			'post_type'   => $this->post_type,
			'post_status' => 'publish',
			'orderby'     => 'date',
			'order'       => 'DESC'
		));

		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select <?php $this->link(); ?>>
					<?php 
					while( $latest->have_posts() ) {
						$latest->the_post();
						echo "<option " . selected( $this->value(), get_the_ID() ) . " value='" . get_the_ID() . "'>" . the_title( '', '', false ) . "</option>";
					}
					?>
				</select>
			</label>
		<?php
		}
	}
endif;
function is_blog () {
    return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
}

