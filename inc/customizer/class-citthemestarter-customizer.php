<?php
/**
 * Customizer
 *
 * @package WordPress
 * @subpackage CIT Theme Starterr
 * @since CIT Theme Starterr 1.0
 */

/**
 * Class citthemestarter_Customizer
 */
class citthemestarter_Customizer {
	/**
	 * CIT Theme Starterr Customizer constructor.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'include_controls' ) );
		add_action( 'customize_register', array( $this, 'custom_css' ) );
		add_action( 'customize_register', array( $this, 'register_customize_sections' ) );
	}

	/**
	 * Custom css.
	 */
	public function custom_css() {
		wp_register_style( 'citthemestarter-custom-css', get_template_directory_uri() . '/css/customizer-custom.css' );
		wp_enqueue_style( 'citthemestarter-custom-css' );
	}

	/**
	 * Include Custom Controls
	 *
	 * Includes all our custom control classes.
	 *
	 * @param WP_Customize_Manager $wp_customize Customize manager class.
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function include_controls( $wp_customize ) {
		require_once get_template_directory() . '/inc/customizer/controls/class-citthemestarter-toggle-switch-control.php';
		$wp_customize->register_control_type( 'citthemestarter_Toggle_Switch_Control' );
	}

	/**
	 * Add all panels and sections to the Customizer
	 *
	 * @param WP_Customize_Manager $wp_customize Customize manager class.
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function register_customize_sections( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		// Create sections.
		$wp_customize->add_section( 'cit_overall_site', array(
			'title'             => esc_html__( 'Theme Options', 'cit' ),
			'priority'          => 101,
			'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_section( 'cit_header_and_menu_area', array(
			'title'             => esc_html__( 'Header', 'cit' ),
			'priority'          => 102,
			'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_section( 'cit_footer_area', array(
			'title'             => esc_html__( 'Footer', 'cit' ),
			'priority'          => 103,
			'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_panel( 'cit_fonts_and_style', array(
			'priority'          => 105,
			'capability'        => 'edit_theme_options',
			'theme_supports'    => '',
			'title'             => esc_html__( 'Fonts & Style', 'cit' ),
		) );
		// Populate sections.
		$this->overall_site_section( $wp_customize );
		$this->header_and_menu_section( $wp_customize );
		$this->footer_section( $wp_customize );
		$this->fonts_and_style_panel( $wp_customize );
		$this->cit_woocommerce( $wp_customize );
	}

	/**
	 * Sanitize Custom Height
	 *
	 * @param integer $height Height.
	 *
	 * @return null
	 */
	public function sanitize_custom_height( $height ) {
		$matches = null;
		preg_match( '/^(([0-9]+)px|[0-9]+)$/', $height, $matches );

		if ( (bool) $matches ) {
			return $height;
		}
		return null;
	}

	/**
	 * Sanitize checkbox
	 *
	 * @param bool $input Input data.
	 *
	 * @return bool
	 */
	public function sanitize_checkbox( $input ) {
		return ( true === $input ) ? true : false;
	}

	/**
	 * Sanitize select
	 *
	 * @param string $input Text data.
	 * @param object $setting Settings object data.
	 *
	 * @return mixed
	 */
	public function sanitize_select( $input, $setting ) {
		$input = sanitize_key( $input );
		$choices = $setting->manager->get_control( $setting->id )->choices;
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

	/**
	 * Sanitize google fonts select
	 *
	 * @param string $input Text data.
	 * @param object $setting Settings object data.
	 *
	 * @return mixed
	 */
	public function sanitize_select_google_fonts( $input, $setting ) {
		$input = wp_strip_all_tags( $input );
		$choices = $setting->manager->get_control( $setting->id )->choices;

		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

	/**
	 * Section: Overall Site
	 *
	 * @param WP_Customize_Manager $wp_customize Customize manager class.
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function overall_site_section( $wp_customize ) {
		$wp_customize->add_setting( citthemestarter_DISABLE_HEADER_TOPBAR,  array(
			'default'           => false,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );
		$wp_customize->add_setting( citthemestarter_DISABLE_HEADER,  array(
			'default'           => false,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_setting( citthemestarter_DISABLE_FOOTER,  array(
			'default'           => false,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_setting( 'cit_overall_site_featured_image',  array(
			'default' => true,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_setting( cit_overall_site_enable_breadcrum,  array(
			'default'           => false,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_setting( 'cit_overall_site_featured_image_width',  array(
			'default' => 'full_width',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_overall_site_featured_image_height',  array(
			'default' => 'auto',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_overall_site_featured_image_custom_height', array(
			'default'                   => '400px',
			'sanitize_callback'         => array( $this, 'sanitize_custom_height' ),
		) );

		$wp_customize->add_setting( 'cit_overall_content_area_size',  array(
			'default'       => 'boxed',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( citthemestarter_PAGE_SIDEBAR,  array(
			'default'       => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( citthemestarter_POST_SIDEBAR,  array(
			'default'       => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( citthemestarter_ARCHIVE_AND_CATEGORY_SIDEBAR,  array(
			'default'       => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_overall_site_content_background',  array(
			'default'       => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'cit_overall_site_comments_background',  array(
			'default'       => '#f4f4f4',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control(
			new citthemestarter_Toggle_Switch_Control(
				$wp_customize,
				citthemestarter_DISABLE_HEADER_TOPBAR,
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Disable Theme Header Top', 'cit' ),
					'section'       => 'cit_overall_site',
					'settings'      => citthemestarter_DISABLE_HEADER_TOPBAR,
			) )
		);

		$wp_customize->add_control(
			new citthemestarter_Toggle_Switch_Control(
				$wp_customize,
				citthemestarter_DISABLE_HEADER,
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Disable Theme Header', 'cit' ),
					'section'       => 'cit_overall_site',
					'settings'      => citthemestarter_DISABLE_HEADER,
			) )
		);

		$wp_customize->add_control(
			new citthemestarter_Toggle_Switch_Control(
				$wp_customize,
				citthemestarter_DISABLE_FOOTER,
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Disable Theme Footer', 'cit' ),
					'section'       => 'cit_overall_site',
					'settings'      => citthemestarter_DISABLE_FOOTER,
			) )
		);

		$wp_customize->add_control(
			new citthemestarter_Toggle_Switch_Control(
				$wp_customize,
				'cit_overall_site_featured_image',
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Featured Image', 'cit' ),
					'description'   => esc_html__( 'Show featured image for posts and pages.', 'cit' ),
					'section'       => 'cit_overall_site',
					'settings'      => 'cit_overall_site_featured_image',
				)
			)
		);

		$wp_customize->add_control(
			new citthemestarter_Toggle_Switch_Control(
				$wp_customize,
				cit_overall_site_enable_breadcrum,
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Enable Breadcrumb', 'cit' ),
					'section'       => 'cit_overall_site',
					'settings'      => cit_overall_site_enable_breadcrum,
			) )
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_overall_site_featured_image_width',
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Featured Image Width', 'cit' ),
					'section'       => 'cit_overall_site',
					'settings'      => 'cit_overall_site_featured_image_width',
					'choices'       => array(
						'full_width' => esc_html__( 'Full width (default)', 'cit' ),
						'boxed' => esc_html__( 'Boxed', 'cit' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_overall_site_featured_image_height',
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Featured Image Height', 'cit' ),
					'section'       => 'cit_overall_site',
					'settings'      => 'cit_overall_site_featured_image_height',
					'choices'       => array(
						'auto'              => esc_html__( 'Auto (default)', 'cit' ),
						'full_height'       => esc_html__( 'Full height', 'cit' ),
						'custom'            => esc_html__( 'Custom', 'cit' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_overall_site_featured_image_custom_height',
				array(
					'label'                     => esc_html__( 'Custom Height', 'cit' ),
					'description'               => esc_html__( 'Please specify featured image height in pixels (ex. 400px).', 'cit' ),
					'section'                   => 'cit_overall_site',
					'settings'                  => 'cit_overall_site_featured_image_custom_height',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_overall_content_area_size',
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Content Area Size Customization', 'cit' ),
					'description'   => esc_html__( 'Default content area size is defined as Boxed and Full width.', 'cit' ),
					'section'       => 'cit_overall_site',
					'settings'      => 'cit_overall_content_area_size',
					'choices'       => array(
						'boxed'         => esc_html__( 'Boxed (default)', 'cit' ),
						'full_width'    => esc_html__( 'Full width', 'cit' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				citthemestarter_PAGE_SIDEBAR,
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Page Sidebar Position', 'cit' ),
					'section'       => 'cit_overall_site',
					'settings'      => citthemestarter_PAGE_SIDEBAR,
					'choices'       => array(
						'none'  => esc_html__( 'None (default)', 'cit' ),
						'left'  => esc_html__( 'Left', 'cit' ),
						'right' => esc_html__( 'Right', 'cit' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				citthemestarter_POST_SIDEBAR,
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Post Sidebar Position', 'cit' ),
					'section'       => 'cit_overall_site',
					'settings'      => citthemestarter_POST_SIDEBAR,
					'choices'       => array(
						'none'  => esc_html__( 'None (default)', 'cit' ),
						'left'  => esc_html__( 'Left', 'cit' ),
						'right' => esc_html__( 'Right', 'cit' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				citthemestarter_ARCHIVE_AND_CATEGORY_SIDEBAR,
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Archive/Category Sidebar Position', 'cit' ),
					'section'       => 'cit_overall_site',
					'settings'      => citthemestarter_ARCHIVE_AND_CATEGORY_SIDEBAR,
					'choices'       => array(
						'none'  => esc_html__( 'None (default)', 'cit' ),
						'left'  => esc_html__( 'Left', 'cit' ),
						'right' => esc_html__( 'Right', 'cit' ),
					),
				)
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
			'label'   => esc_html__( 'Site Background', 'cit' ),
			'section' => 'cit_overall_site',
		) ) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_overall_site_content_background',
				array(
					'label'         => esc_html__( 'Content Background', 'cit' ),
					'section'       => 'cit_overall_site',
					'settings'      => 'cit_overall_site_content_background',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_overall_site_comments_background',
				array(
					'label'         => esc_html__( 'Comments Background', 'cit' ),
					'section'       => 'cit_overall_site',
					'settings'      => 'cit_overall_site_comments_background',
				)
			)
		);
	}

	/**
	 * Section: Header Section
	 *
	 * @param WP_Customize_Manager $wp_customize Customize manager class.
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function header_and_menu_section( $wp_customize ) {
		$wp_customize->add_setting( 'cit_header_background',  array(
			'default'       => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'cit_header_menu_hover_background',  array(
			'default'       => '#eeeeee',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'cit_header_text_color',  array(
			'default'       => '#555555',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'cit_header_text_active_color',  array(
			'default'       => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'cit_header_padding',  array(
			'default'       => '25px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'cit_header_position',  array(
			'default'       => 'top',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_header_sandwich_style',  array(
			'default'       => '#333333',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_header_top_header_width',  array(
			'default'       => 'boxed',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_header_top_header_width',  array(
			'default'       => 'custom_container',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_header_reserve_space_for_header',  array(
			'default'       => true,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_setting( 'cit_header_sticky_header',  array(
			'default'       => false,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_setting( 'cit_header_sandwich_icon_color',  array(
			'default'       => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_header_position',
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Header Style', 'cit' ),
					'section'       => 'cit_header_and_menu_area',
					'settings'      => 'cit_header_position',
					'choices'       => array(
						'top'           => esc_html__( 'Top (default)', 'cit' ),
						'sandwich'      => esc_html__( 'Sandwich', 'cit' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_header_top_header_width',
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Header Width', 'cit' ),
					'section'       => 'cit_header_and_menu_area',
					'settings'      => 'cit_header_top_header_width',
					'choices'       => array(
						'boxed'             => esc_html__( 'Boxed (default)', 'cit' ),
						'full_width_boxed'  => esc_html__( 'Full width boxed', 'cit' ),
						'full_width'        => esc_html__( 'Full width', 'cit' ),
						'custom_container'        => esc_html__( 'Custom width', 'cit' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_header_background',
				array(
					'label'         => esc_html__( 'Background Color', 'cit' ),
					'description'   => esc_html__( 'Define header and submenu background color.', 'cit' ),
					'section'       => 'cit_header_and_menu_area',
					'settings'      => 'cit_header_background',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_header_menu_hover_background',
				array(
					'label'         => esc_html__( 'Submenu Background Hover Color', 'cit' ),
					'section'       => 'cit_header_and_menu_area',
					'settings'      => 'cit_header_menu_hover_background',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_header_text_color',
				array(
					'label'         => esc_html__( 'Text Color', 'cit' ),
					'section'       => 'cit_header_and_menu_area',
					'settings'      => 'cit_header_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_header_text_active_color',
				array(
					'label'         => esc_html__( 'Active Text Color', 'cit' ),
					'section'       => 'cit_header_and_menu_area',
					'settings'      => 'cit_header_text_active_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_header_padding',
				array(
					'label'    => esc_html__( 'Header Padding', 'cit' ),
					'section'  => 'cit_header_and_menu_area',
					'settings' => 'cit_header_padding',
					'type'     => 'text',
				) )
		);

		$wp_customize->add_control(
			new citthemestarter_Toggle_Switch_Control(
				$wp_customize,
				'cit_header_reserve_space_for_header',
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Reserve Space For Header', 'cit' ),
					'description'   => esc_html__( 'By default header will be placed on the top of featured image.', 'cit' ),
					'section'       => 'cit_header_and_menu_area',
					'settings'      => 'cit_header_reserve_space_for_header',
				)
			)
		);

		$wp_customize->add_control(
			new citthemestarter_Toggle_Switch_Control(
				$wp_customize,
				'cit_header_sticky_header',
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Sticky Header', 'cit' ),
					'description'   => esc_html__( 'If set to \'On\' header will stay fixed on the top when scrolling.', 'cit' ),
					'section'       => 'cit_header_and_menu_area',
					'settings'      => 'cit_header_sticky_header',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_header_sandwich_style',
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Sandwich Style', 'cit' ),
					'description'   => esc_html__( 'Define sandwich background and control style.', 'cit' ),
					'section'       => 'cit_header_and_menu_area',
					'settings'      => 'cit_header_sandwich_style',
					'choices'       => array(
						'#333333'      => esc_html__( 'Dark (default)', 'cit' ),
						'#FFFFFF'      => esc_html__( 'Light', 'cit' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_header_sandwich_icon_color',
				array(
					'label'         => esc_html__( 'Sandwich Icon Color', 'cit' ),
					'section'       => 'cit_header_and_menu_area',
					'settings'      => 'cit_header_sandwich_icon_color',
				)
			)
		);

	}

	/**
	 * Section: Footer Section
	 *
	 * @param WP_Customize_Manager $wp_customize Customize manager class.
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function footer_section( $wp_customize ) {
		$wp_customize->add_setting( 'cit_footer_area_background_image',  array(
			'default'       => get_template_directory_uri().'/images/footer-bg.png',
		) );

		$wp_customize->add_setting( 'cit_footer_area_background',  array(
			'default'       => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'cit_footer_area_text_color',  array(
			'default'       => '#777777',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'cit_footer_area_text_active_color',  array(
			'default'       => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'cit_footer_area_widget_area',  array(
			'default'       => false,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_setting( 'cit_footer_area_contact_widget_area',  array(
			'default'       => false,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );


		$wp_customize->add_setting( 'cit_footer_area_textarea_widget_area',  array(
			'default' => '',
			'sanitize_callback' => 'wp_kses_post',
		) );

		$wp_customize->add_setting( 'cit_footer_area_widgetized_columns',  array(
			'default'       => 1,
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_footer_area_widgetized_textarea_columns',  array(
			'default'       => "",
		) );

		$wp_customize->add_setting( 'cit_footer_area_social_icons',  array(
			'default'       => false,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'cit_footer_area_background_image',
				array(
					'label'         => esc_html__( 'Footer Background Image', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_background_image',
					'library_filter' => array( 'gif', 'jpg', 'jpeg', 'png', 'ico' ),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_footer_area_background',
				array(
					'label'         => esc_html__( 'Footer Background Color', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_background',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_footer_area_text_color',
				array(
					'label'         => esc_html__( 'Text Color', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_footer_area_text_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_text_active_color',
				)
			)
		);

		$wp_customize->add_control(
			new citthemestarter_Toggle_Switch_Control(
				$wp_customize,
				'cit_footer_area_contact_widget_area',
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Download App Setting', 'cit' ),
					'description'   => esc_html__( 'Theme footer allows inserting widget area at the top of the footer.', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_contact_widget_area',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_footer_area_textarea_widget_area',
				array(
					'type'          => 'textarea',
					'label'         => esc_html__( 'Download Flash App Description', 'cit' ),
					'description'   => esc_html__( 'Download Flash App Description', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_textarea_widget_area',
				)
			)
		);

		$wp_customize->add_control(
			new citthemestarter_Toggle_Switch_Control(
				$wp_customize,
				'cit_footer_area_widget_area',
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Widget Area', 'cit' ),
					'description'   => esc_html__( 'Theme footer allows inserting widget area at the top of the footer.', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_widget_area',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_footer_area_widgetized_columns',
				array(
					'label'         => esc_html__( 'Number of Columns', 'cit' ),
					'description'   => esc_html__( 'Widget area can be divided into up to four columns.', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_widgetized_columns',
					'type'    => 'select',
					'choices'  => array(
						1 => esc_html__( 'One', 'cit' ),
						2 => esc_html__( 'Two', 'cit' ),
						3 => esc_html__( 'Three', 'cit' ),
						4 => esc_html__( 'Four', 'cit' ),
						4 => esc_html__( '3/9', 'cit' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_footer_area_widgetized_textarea_columns',
				array(
					'label'         => esc_html__( 'About Footer', 'cit' ),
					'description'   => esc_html__( 'Enter here About Footer text', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_widgetized_textarea_columns',
					'type'    => 'textarea',
				)
			)
		);

		$wp_customize->add_control(
			new citthemestarter_Toggle_Switch_Control(
				$wp_customize,
				'cit_footer_area_social_icons',
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Social Icons', 'cit' ),
					'description'   => esc_html__( 'Add url to your social network profiles.', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_social_icons',
				)
			)
		);

		$wp_customize->add_setting( 'cit_footer_area_social_link_facebook',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'cit_footer_area_social_link_twitter',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'cit_footer_area_social_link_linkedin',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'cit_footer_area_social_link_github',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'cit_footer_area_social_link_instagram',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'cit_footer_area_social_link_pinterest',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'cit_footer_area_social_link_flickr',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'cit_footer_area_social_link_youtube',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'cit_footer_area_social_link_vimeo',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'cit_footer_area_social_link_email', array(
			'default' => '',
			'sanitize_callback' => 'sanitize_email',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_footer_area_social_link_facebook',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Facebook', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_social_link_facebook',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_footer_area_social_link_twitter',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Twitter', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_social_link_twitter',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_footer_area_social_link_linkedin',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'LinkedIn', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_social_link_linkedin',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_footer_area_social_link_instagram',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Instagram', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_social_link_instagram',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_footer_area_social_link_pinterest',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Pinterest', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_social_link_pinterest',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_footer_area_social_link_youtube',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'YouTube', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_social_link_youtube',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_footer_area_social_link_vimeo',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Vimeo', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_social_link_vimeo',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_footer_area_social_link_flickr',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Yelp', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_social_link_flickr',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_footer_area_social_link_github',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Github', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_social_link_github',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'cit_footer_area_social_link_email',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Email', 'cit' ),
					'section'       => 'cit_footer_area',
					'settings'      => 'cit_footer_area_social_link_email',
				)
			)
		);
	}

	/**
	 * Section: Body Fonts & Styles Section
	 *
	 * @param WP_Customize_Manager $wp_customize Customize manager class.
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function fonts_and_style_panel( $wp_customize ) {
		$wp_customize->add_section( 'cit_fonts_and_style_h1', array(
			'title'         => esc_html__( 'H1', 'cit' ),
			'priority'      => 100,
			'capability'    => 'edit_theme_options',
			'panel'         => 'cit_fonts_and_style',
		) );
		$wp_customize->add_section( 'cit_fonts_and_style_h2', array(
			'title'         => esc_html__( 'H2', 'cit' ),
			'priority'      => 101,
			'capability'    => 'edit_theme_options',
			'panel'         => 'cit_fonts_and_style',
		) );
		$wp_customize->add_section( 'cit_fonts_and_style_h3', array(
			'title'         => esc_html__( 'H3', 'cit' ),
			'priority'      => 102,
			'capability'    => 'edit_theme_options',
			'panel'         => 'cit_fonts_and_style',
		) );
		$wp_customize->add_section( 'cit_fonts_and_style_h4', array(
			'title'         => esc_html__( 'H4', 'cit' ),
			'priority'      => 103,
			'capability'    => 'edit_theme_options',
			'panel'         => 'cit_fonts_and_style',
		) );
		$wp_customize->add_section( 'cit_fonts_and_style_h5', array(
			'title'         => esc_html__( 'H5', 'cit' ),
			'priority'      => 104,
			'capability'    => 'edit_theme_options',
			'panel'         => 'cit_fonts_and_style',
		) );
		$wp_customize->add_section( 'cit_fonts_and_style_h6', array(
			'title'         => esc_html__( 'H6', 'cit' ),
			'priority'      => 105,
			'capability'    => 'edit_theme_options',
			'panel'         => 'cit_fonts_and_style',
		) );
		$wp_customize->add_section( 'cit_fonts_and_style_body', array(
			'title'         => esc_html__( 'Body', 'cit' ),
			'priority'      => 106,
			'capability'    => 'edit_theme_options',
			'panel'         => 'cit_fonts_and_style',
		) );
		$wp_customize->add_section( 'cit_fonts_and_style_buttons', array(
			'title'         => esc_html__( 'Buttons', 'cit' ),
			'priority'      => 107,
			'capability'    => 'edit_theme_options',
			'panel'         => 'cit_fonts_and_style',
		) );

		$this->fonts_and_style_section_h1( $wp_customize );
		$this->fonts_and_style_section_h2( $wp_customize );
		$this->fonts_and_style_section_h3( $wp_customize );
		$this->fonts_and_style_section_h4( $wp_customize );
		$this->fonts_and_style_section_h5( $wp_customize );
		$this->fonts_and_style_section_h6( $wp_customize );
		$this->fonts_and_style_section_body( $wp_customize );
		$this->fonts_and_style_section_buttons( $wp_customize );
	}

	/**
	 * Check if header cart is enabled
	 *
	 * @return true|false
	 */
	public function header_cart_enabled() {
		$header_cart = get_theme_mod( 'woocommerce_header_cart_icon' );
		if ( $header_cart ) {
			return true;
		}

		return false;
	}

	/**
	 * Section: Woocommerce custom settings
	 *
	 * @param WP_Customize_Manager $wp_customize Customize manager class.
	 *
	 * @access private
	 * @since  2.0.4
	 * @return void
	 */
	private function cit_woocommerce( $wp_customize ) {
		$wp_customize->add_section( 'cit_woocommerce_settings', array(
			'title' => esc_html__( 'CIT Theme Starterr Theme', 'cit' ),
			'priority' => 90,
			'panel' => 'woocommerce',
		) );

		$wp_customize->add_setting( 'woocommerce_header_cart_icon', array(
			'default' => true,
			'capability' => 'manage_woocommerce',
			'sanitize_callback' => array(
				$this,
				'sanitize_checkbox',
			),
			'transport' => 'postMessage',
		) );
		$wp_customize->add_control(
			new citthemestarter_Toggle_Switch_Control(
				$wp_customize,
				'woocommerce_header_cart_icon',
				array(
					'label' => __( 'Cart Icon', 'cit' ),
					'description' => __( 'If enabled, this show the cart icon right next to the main menu.', 'cit' ),
					'section' => 'cit_woocommerce_settings',
					'settings' => 'woocommerce_header_cart_icon',
					'type' => 'toggle-switch',
				)
			)
		);

		$wp_customize->add_setting( 'woo_cart_color',  array(
			'default'       => '#2b4b80',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_color',
				array(
					'label'             => esc_html__( 'Cart icon color', 'cit' ),
					'description'       => esc_html__( 'Color for header cart icon color.', 'cit' ),
					'section'           => 'cit_woocommerce_settings',
					'settings'          => 'woo_cart_color',
				)
			)
		);

		$wp_customize->add_setting( 'woo_cart_text_color',  array(
			'default'       => '#fff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_cart_text_color',
				array(
					'label'         => esc_html__( 'Cart icon text color', 'cit' ),
					'description'   => esc_html__( 'Color for header cart text color.', 'cit' ),
					'section'       => 'cit_woocommerce_settings',
					'settings'      => 'woo_cart_text_color',
				)
			)
		);

		$wp_customize->add_setting( 'woocommerce_coupon_from', array(
			'default' => true,
			'capability' => 'manage_woocommerce',
			'sanitize_callback' => array(
				$this,
				'sanitize_checkbox',
			),
		) );
		$wp_customize->add_control(
			new citthemestarter_Toggle_Switch_Control(
				$wp_customize,
				'woocommerce_coupon_from',
				array(
					'label' => __( 'Always open coupon form', 'cit' ),
					'description' => __( 'If enabled, this show will leave the coupon form always open.', 'cit' ),
					'section' => 'cit_woocommerce_settings',
					'settings' => 'woocommerce_coupon_from',
					'type' => 'toggle-switch',
				)
			)
		);

		$wp_customize->add_setting( 'woo_on_sale_color',  array(
			'default'       => '#FAC917',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_on_sale_color',
				array(
					'label'         => esc_html__( 'On sale badge color', 'cit' ),
					'description'   => esc_html__( 'Color for "On Sale" badge that is appearing on product image.', 'cit' ),
					'section'       => 'cit_woocommerce_settings',
					'settings'      => 'woo_on_sale_color',
				)
			)
		);

		/** Price tag color. */
		$wp_customize->add_setting( 'woo_price_tag_color',  array(
			'default'       => '#2b4b80',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_price_tag_color',
				array(
					'label'         => esc_html__( 'Price tag color', 'cit' ),
					'description'   => esc_html__( 'Color for each items price tag.', 'cit' ),
					'section'       => 'cit_woocommerce_settings',
					'settings'      => 'woo_price_tag_color',
				)
			)
		);

		/** Old price tag color. */
		$wp_customize->add_setting( 'woo_old_price_tag_color',  array(
			'default'       => '#d5d5d5',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_old_price_tag_color',
				array(
					'label'         => esc_html__( 'Old price tag color', 'cit' ),
					'description'   => esc_html__( 'Color for each items old price, in case there is a discount set.', 'cit' ),
					'section'       => 'cit_woocommerce_settings',
					'settings'      => 'woo_old_price_tag_color',
				)
			)
		);

		/** Link color */
		$wp_customize->add_setting( 'woo_link_color',  array(
			'default'       => '#d5d5d5',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_link_color',
				array(
					'label'         => esc_html__( 'Secondary link color', 'cit' ),
					'description'   => esc_html__( 'Color for links like categories, tabs links etc.', 'cit' ),
					'section'       => 'cit_woocommerce_settings',
					'settings'      => 'woo_link_color',
				)
			)
		);

		/** Link hover color */
		$wp_customize->add_setting( 'woo_link_hover_color',  array(
			'default'       => '#2b4b80',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_link_hover_color',
				array(
					'label'         => esc_html__( 'Link hover color', 'cit' ),
					'section'       => 'cit_woocommerce_settings',
					'settings'      => 'woo_link_hover_color',
				)
			)
		);

		/** Active tab color */
		$wp_customize->add_setting( 'woo_link_active_color',  array(
			'default'       => '#2b4b80',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_link_active_color',
				array(
					'label'         => esc_html__( 'Active tab color', 'cit' ),
					'description'   => esc_html__( 'Color for active tab.', 'cit' ),
					'section'       => 'cit_woocommerce_settings',
					'settings'      => 'woo_link_active_color',
				)
			)
		);

		/** Outline button color */
		$wp_customize->add_setting( 'woo_outline_button_color',  array(
			'default'       => '#4e4e4e',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_outline_button_color',
				array(
					'label'         => esc_html__( 'Outline button color', 'cit' ),
					'section'       => 'cit_woocommerce_settings',
					'settings'      => 'woo_outline_button_color',
				)
			)
		);

		/** Price filter widget range color */
		$wp_customize->add_setting( 'woo_price_filter_widget_color',  array(
			'default'       => '#2b4b80',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_price_filter_widget_color',
				array(
					'label'         => esc_html__( 'Price filter color', 'cit' ),
					'description'   => esc_html__( 'Color for price filter widget range bar.', 'cit' ),
					'section'       => 'cit_woocommerce_settings',
					'settings'      => 'woo_price_filter_widget_color',
				)
			)
		);

		/** Widget links */
		$wp_customize->add_setting( 'woo_widget_links_color',  array(
			'default'       => '#000',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_widget_links_color',
				array(
					'label'         => esc_html__( 'Widget link color', 'cit' ),
					'description'   => esc_html__( 'Color for links in sidebar widgets.', 'cit' ),
					'section'       => 'cit_woocommerce_settings',
					'settings'      => 'woo_widget_links_color',
				)
			)
		);

		/** Widget links hover color */
		$wp_customize->add_setting( 'woo_widget_links_hover_color',  array(
			'default'       => '#2b4b80',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_widget_links_hover_color',
				array(
					'label'         => esc_html__( 'Widget link hover color', 'cit' ),
					'description'   => esc_html__( 'Color for links hover in sidebar widgets.', 'cit' ),
					'section'       => 'cit_woocommerce_settings',
					'settings'      => 'woo_widget_links_hover_color',
				)
			)
		);

		/** Delete icon color */
		$wp_customize->add_setting( 'woo_delete_icon_color',  array(
			'default'       => '#d5d5d5',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'woo_delete_icon_color',
				array(
					'label'         => esc_html__( 'Delete icon color', 'cit' ),
					'description'   => esc_html__( 'Color for "X" icon in cart, cart widgets etc.', 'cit' ),
					'section'       => 'cit_woocommerce_settings',
					'settings'      => 'woo_delete_icon_color',
				)
			)
		);
	}

	/**
	 * H1 fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_h1( $wp_customize ) {
		$wp_customize->add_setting( 'cit_fonts_and_style_h1_text_color', array(
			'default'        => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h1_active_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h1_font_family', array(
			'default'        => 'Playfair Display',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h1_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h1_font_size', array(
			'default'        => '42px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h1_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h1_line_height', array(
			'default'        => '1.1',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h1_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h1_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h1_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h1_margin_bottom', array(
			'default'        => '2.125rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h1_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_h1_text_color',
				array(
					'label'         => esc_html__( 'Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_h1',
					'settings'      => 'cit_fonts_and_style_h1_text_color',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_h1_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_h1',
					'settings'      => 'cit_fonts_and_style_h1_active_color',
				)
			)
		);
		$wp_customize->add_control( 'cit_fonts_and_style_h1_font_family', array(
			'label'   => esc_html__( 'Font-family', 'cit' ),
			'section' => 'cit_fonts_and_style_h1',
			'settings'   => 'cit_fonts_and_style_h1_font_family',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_choices(),
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h1_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'cit' ),
			'section' => 'cit_fonts_and_style_h1',
			'settings'   => 'cit_fonts_and_style_h1_subsets',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_subsets(),
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h1_weight', array(
			'label'   => esc_html__( 'Font Weight', 'cit' ),
			'section' => 'cit_fonts_and_style_h1',
			'settings'   => 'cit_fonts_and_style_h1_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'cit' ),
				'400' => esc_html__( 'Normal (default)', 'cit' ),
				'600' => esc_html__( 'Semi-Bold', 'cit' ),
				'700' => esc_html__( 'Bold', 'cit' ),
			),
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h1_font_style', array(
			'label'   => esc_html__( 'Font Style', 'cit' ),
			'section' => 'cit_fonts_and_style_h1',
			'settings'   => 'cit_fonts_and_style_h1_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'cit' ),
				'italic' => esc_html__( 'Italic', 'cit' ),
				'oblique' => esc_html__( 'Oblique', 'cit' ),
				'inherit' => esc_html__( 'Inherit', 'cit' ),
			),
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h1_font_size', array(
			'label'   => esc_html__( 'Size', 'cit' ),
			'section' => 'cit_fonts_and_style_h1',
			'settings'   => 'cit_fonts_and_style_h1_font_size',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h1_line_height', array(
			'label'   => esc_html__( 'Line Height', 'cit' ),
			'section' => 'cit_fonts_and_style_h1',
			'settings'   => 'cit_fonts_and_style_h1_line_height',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h1_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'cit' ),
			'section' => 'cit_fonts_and_style_h1',
			'settings'   => 'cit_fonts_and_style_h1_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h1_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'cit' ),
			'section' => 'cit_fonts_and_style_h1',
			'settings'   => 'cit_fonts_and_style_h1_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h1_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'cit' ),
			'section' => 'cit_fonts_and_style_h1',
			'settings'   => 'cit_fonts_and_style_h1_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h1_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'cit' ),
			'section' => 'cit_fonts_and_style_h1',
			'settings'   => 'cit_fonts_and_style_h1_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'cit' ),
				'uppercase' => esc_html__( 'Uppercase', 'cit' ),
				'lowercase' => esc_html__( 'Lowercase', 'cit' ),
				'capitalize' => esc_html__( 'Capitalize', 'cit' ),
			),
		) );
	}

	/**
	 * H2 fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_h2( $wp_customize ) {
		$wp_customize->add_setting( 'cit_fonts_and_style_h2_text_color', array(
			'default'        => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h2_active_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h2_font_family', array(
			'default'        => 'Playfair Display',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h2_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h2_font_size', array(
			'default'        => '36px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h2_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h2_line_height', array(
			'default'        => '1.1',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h2_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h2_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h2_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h2_margin_bottom', array(
			'default'        => '0.625rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h2_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_h2_text_color',
				array(
					'label'         => esc_html__( 'Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_h2',
					'settings'      => 'cit_fonts_and_style_h2_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_h2_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_h2',
					'settings'      => 'cit_fonts_and_style_h2_active_color',
				)
			)
		);

		$wp_customize->add_control( 'cit_fonts_and_style_h2_font_family', array(
			'label'   => esc_html__( 'Font-family', 'cit' ),
			'section' => 'cit_fonts_and_style_h2',
			'settings'   => 'cit_fonts_and_style_h2_font_family',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h2_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'cit' ),
			'section' => 'cit_fonts_and_style_h2',
			'settings'   => 'cit_fonts_and_style_h2_subsets',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h2_weight', array(
			'label'   => esc_html__( 'Font Weight', 'cit' ),
			'section' => 'cit_fonts_and_style_h2',
			'settings'   => 'cit_fonts_and_style_h2_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'cit' ),
				'400' => esc_html__( 'Normal (default)', 'cit' ),
				'600' => esc_html__( 'Semi-Bold', 'cit' ),
				'700' => esc_html__( 'Bold', 'cit' ),
			),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h2_font_style', array(
			'label'   => esc_html__( 'Font Style', 'cit' ),
			'section' => 'cit_fonts_and_style_h2',
			'settings'   => 'cit_fonts_and_style_h2_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'cit' ),
				'italic' => esc_html__( 'Italic', 'cit' ),
				'oblique' => esc_html__( 'Oblique', 'cit' ),
				'inherit' => esc_html__( 'Inherit', 'cit' ),
			),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h2_font_size', array(
			'label'   => esc_html__( 'Size', 'cit' ),
			'section' => 'cit_fonts_and_style_h2',
			'settings'   => 'cit_fonts_and_style_h2_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h2_line_height', array(
			'label'   => esc_html__( 'Line Height', 'cit' ),
			'section' => 'cit_fonts_and_style_h2',
			'settings'   => 'cit_fonts_and_style_h2_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h2_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'cit' ),
			'section' => 'cit_fonts_and_style_h2',
			'settings'   => 'cit_fonts_and_style_h2_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h2_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'cit' ),
			'section' => 'cit_fonts_and_style_h2',
			'settings'   => 'cit_fonts_and_style_h2_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h2_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'cit' ),
			'section' => 'cit_fonts_and_style_h2',
			'settings'   => 'cit_fonts_and_style_h2_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h2_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'cit' ),
			'section' => 'cit_fonts_and_style_h2',
			'settings'   => 'cit_fonts_and_style_h2_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'cit' ),
				'uppercase' => esc_html__( 'Uppercase', 'cit' ),
				'lowercase' => esc_html__( 'Lowercase', 'cit' ),
				'capitalize' => esc_html__( 'Capitalize', 'cit' ),
			),
		) );
	}

	/**
	 * H3 fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_h3( $wp_customize ) {
		$wp_customize->add_setting( 'cit_fonts_and_style_h3_text_color', array(
			'default'        => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h3_active_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h3_font_family', array(
			'default'        => 'Playfair Display',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h3_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h3_font_size', array(
			'default'        => '30px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h3_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h3_line_height', array(
			'default'        => '1.1',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h3_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h3_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h3_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h3_margin_bottom', array(
			'default'        => '0.625rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h3_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_h3_text_color',
				array(
					'label'         => esc_html__( 'Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_h3',
					'settings'      => 'cit_fonts_and_style_h3_text_color',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_h3_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_h3',
					'settings'      => 'cit_fonts_and_style_h3_active_color',
				)
			)
		);
		$wp_customize->add_control( 'cit_fonts_and_style_h3_font_family', array(
			'label'   => esc_html__( 'Font-family', 'cit' ),
			'section' => 'cit_fonts_and_style_h3',
			'settings'   => 'cit_fonts_and_style_h3_font_family',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_choices(),
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h3_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'cit' ),
			'section' => 'cit_fonts_and_style_h3',
			'settings'   => 'cit_fonts_and_style_h3_subsets',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_subsets(),
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h3_weight', array(
			'label'   => esc_html__( 'Font Weight', 'cit' ),
			'section' => 'cit_fonts_and_style_h3',
			'settings'   => 'cit_fonts_and_style_h3_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'cit' ),
				'400' => esc_html__( 'Normal (default)', 'cit' ),
				'600' => esc_html__( 'Semi-Bold', 'cit' ),
				'700' => esc_html__( 'Bold', 'cit' ),
			),
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h3_font_style', array(
			'label'   => esc_html__( 'Font Style', 'cit' ),
			'section' => 'cit_fonts_and_style_h3',
			'settings'   => 'cit_fonts_and_style_h3_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'cit' ),
				'italic' => esc_html__( 'Italic', 'cit' ),
				'oblique' => esc_html__( 'Oblique', 'cit' ),
				'inherit' => esc_html__( 'Inherit', 'cit' ),
			),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h3_font_size', array(
			'label'   => esc_html__( 'Size', 'cit' ),
			'section' => 'cit_fonts_and_style_h3',
			'settings'   => 'cit_fonts_and_style_h3_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h3_line_height', array(
			'label'   => esc_html__( 'Line Height', 'cit' ),
			'section' => 'cit_fonts_and_style_h3',
			'settings'   => 'cit_fonts_and_style_h3_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h3_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'cit' ),
			'section' => 'cit_fonts_and_style_h3',
			'settings'   => 'cit_fonts_and_style_h3_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h3_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'cit' ),
			'section' => 'cit_fonts_and_style_h3',
			'settings'   => 'cit_fonts_and_style_h3_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h3_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'cit' ),
			'section' => 'cit_fonts_and_style_h3',
			'settings'   => 'cit_fonts_and_style_h3_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h3_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'cit' ),
			'section' => 'cit_fonts_and_style_h3',
			'settings'   => 'cit_fonts_and_style_h3_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'cit' ),
				'uppercase' => esc_html__( 'Uppercase', 'cit' ),
				'lowercase' => esc_html__( 'Lowercase', 'cit' ),
				'capitalize' => esc_html__( 'Capitalize', 'cit' ),
			),
		) );
	}

	/**
	 * H4 fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_h4( $wp_customize ) {
		$wp_customize->add_setting( 'cit_fonts_and_style_h4_text_color', array(
			'default'        => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h4_active_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h4_font_family', array(
			'default'        => 'Playfair Display',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h4_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h4_font_size', array(
			'default'        => '22px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h4_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h4_line_height', array(
			'default'        => '1.1',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h4_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h4_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h4_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h4_margin_bottom', array(
			'default'        => '0.625rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h4_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_h4_text_color',
				array(
					'label'         => esc_html__( 'Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_h4',
					'settings'      => 'cit_fonts_and_style_h4_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_h4_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_h4',
					'settings'      => 'cit_fonts_and_style_h4_active_color',
				)
			)
		);

		$wp_customize->add_control( 'cit_fonts_and_style_h4_font_family', array(
			'label'   => esc_html__( 'Font-family', 'cit' ),
			'section' => 'cit_fonts_and_style_h4',
			'settings'   => 'cit_fonts_and_style_h4_font_family',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h4_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'cit' ),
			'section' => 'cit_fonts_and_style_h4',
			'settings'   => 'cit_fonts_and_style_h4_subsets',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h4_weight', array(
			'label'   => esc_html__( 'Font Weight', 'cit' ),
			'section' => 'cit_fonts_and_style_h4',
			'settings'   => 'cit_fonts_and_style_h4_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'cit' ),
				'400' => esc_html__( 'Normal (default)', 'cit' ),
				'600' => esc_html__( 'Semi-Bold', 'cit' ),
				'700' => esc_html__( 'Bold', 'cit' ),
			),
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h4_font_style', array(
			'label'   => esc_html__( 'Font Style', 'cit' ),
			'section' => 'cit_fonts_and_style_h4',
			'settings'   => 'cit_fonts_and_style_h4_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'cit' ),
				'italic' => esc_html__( 'Italic', 'cit' ),
				'oblique' => esc_html__( 'Oblique', 'cit' ),
				'inherit' => esc_html__( 'Inherit', 'cit' ),
			),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h4_font_size', array(
			'label'   => esc_html__( 'Size', 'cit' ),
			'section' => 'cit_fonts_and_style_h4',
			'settings'   => 'cit_fonts_and_style_h4_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h4_line_height', array(
			'label'   => esc_html__( 'Line Height', 'cit' ),
			'section' => 'cit_fonts_and_style_h4',
			'settings'   => 'cit_fonts_and_style_h4_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h4_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'cit' ),
			'section' => 'cit_fonts_and_style_h4',
			'settings'   => 'cit_fonts_and_style_h4_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h4_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'cit' ),
			'section' => 'cit_fonts_and_style_h4',
			'settings'   => 'cit_fonts_and_style_h4_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h4_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'cit' ),
			'section' => 'cit_fonts_and_style_h4',
			'settings'   => 'cit_fonts_and_style_h4_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h4_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'cit' ),
			'section' => 'cit_fonts_and_style_h4',
			'settings'   => 'cit_fonts_and_style_h4_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'cit' ),
				'uppercase' => esc_html__( 'Uppercase', 'cit' ),
				'lowercase' => esc_html__( 'Lowercase', 'cit' ),
				'capitalize' => esc_html__( 'Capitalize', 'cit' ),
			),
		) );
	}

	/**
	 * H5 fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_h5( $wp_customize ) {
		$wp_customize->add_setting( 'cit_fonts_and_style_h5_text_color', array(
			'default'        => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h5_active_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h5_font_family', array(
			'default'        => 'Playfair Display',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h5_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h5_font_size', array(
			'default'        => '18px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h5_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h5_line_height', array(
			'default'        => '1.1',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h5_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h5_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h5_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h5_margin_bottom', array(
			'default'        => '0.625rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h5_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_h5_text_color',
				array(
					'label'         => esc_html__( 'Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_h5',
					'settings'      => 'cit_fonts_and_style_h5_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_h5_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_h5',
					'settings'      => 'cit_fonts_and_style_h5_active_color',
				)
			)
		);

		$wp_customize->add_control( 'cit_fonts_and_style_h5_font_family', array(
			'label'   => esc_html__( 'Font-family', 'cit' ),
			'section' => 'cit_fonts_and_style_h5',
			'settings'   => 'cit_fonts_and_style_h5_font_family',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h5_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'cit' ),
			'section' => 'cit_fonts_and_style_h5',
			'settings'   => 'cit_fonts_and_style_h5_subsets',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h5_weight', array(
			'label'   => esc_html__( 'Font Weight', 'cit' ),
			'section' => 'cit_fonts_and_style_h5',
			'settings'   => 'cit_fonts_and_style_h5_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'cit' ),
				'400' => esc_html__( 'Normal (default)', 'cit' ),
				'600' => esc_html__( 'Semi-Bold', 'cit' ),
				'700' => esc_html__( 'Bold', 'cit' ),
			),
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h5_font_style', array(
			'label'   => esc_html__( 'Font Style', 'cit' ),
			'section' => 'cit_fonts_and_style_h5',
			'settings'   => 'cit_fonts_and_style_h5_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'cit' ),
				'italic' => esc_html__( 'Italic', 'cit' ),
				'oblique' => esc_html__( 'Oblique', 'cit' ),
				'inherit' => esc_html__( 'Inherit', 'cit' ),
			),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h5_font_size', array(
			'label'   => esc_html__( 'Size', 'cit' ),
			'section' => 'cit_fonts_and_style_h5',
			'settings'   => 'cit_fonts_and_style_h5_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h5_line_height', array(
			'label'   => esc_html__( 'Line Height', 'cit' ),
			'section' => 'cit_fonts_and_style_h5',
			'settings'   => 'cit_fonts_and_style_h5_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h5_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'cit' ),
			'section' => 'cit_fonts_and_style_h5',
			'settings'   => 'cit_fonts_and_style_h5_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h5_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'cit' ),
			'section' => 'cit_fonts_and_style_h5',
			'settings'   => 'cit_fonts_and_style_h5_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h5_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'cit' ),
			'section' => 'cit_fonts_and_style_h5',
			'settings'   => 'cit_fonts_and_style_h5_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_h5_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'cit' ),
			'section' => 'cit_fonts_and_style_h5',
			'settings'   => 'cit_fonts_and_style_h5_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'cit' ),
				'uppercase' => esc_html__( 'Uppercase', 'cit' ),
				'lowercase' => esc_html__( 'Lowercase', 'cit' ),
				'capitalize' => esc_html__( 'Capitalize', 'cit' ),
			),
		) );
	}

	/**
	 * H6 fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_h6( $wp_customize ) {
		$wp_customize->add_setting( 'cit_fonts_and_style_h6_text_color', array(
			'default'        => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h6_active_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h6_font_family', array(
			'default'        => 'Playfair Display',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h6_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_h6_font_size', array(
			'default'        => '16px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h6_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h6_line_height', array(
			'default'        => '1.1',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h6_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h6_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h6_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h6_margin_bottom', array(
			'default'        => '0.625rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_h6_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_h6_text_color',
				array(
					'label'         => esc_html__( 'Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_h6',
					'settings'      => 'cit_fonts_and_style_h6_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_h6_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_h6',
					'settings'      => 'cit_fonts_and_style_h6_active_color',
				)
			)
		);

		$wp_customize->add_control( 'cit_fonts_and_style_h6_font_family', array(
			'label'   => esc_html__( 'Font-family', 'cit' ),
			'section' => 'cit_fonts_and_style_h6',
			'settings'   => 'cit_fonts_and_style_h6_font_family',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h6_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'cit' ),
			'section' => 'cit_fonts_and_style_h6',
			'settings'   => 'cit_fonts_and_style_h6_subsets',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h6_weight', array(
			'label'   => esc_html__( 'Font Weight', 'cit' ),
			'section' => 'cit_fonts_and_style_h6',
			'settings'   => 'cit_fonts_and_style_h6_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'cit' ),
				'400' => esc_html__( 'Normal (default)', 'cit' ),
				'600' => esc_html__( 'Semi-Bold', 'cit' ),
				'700' => esc_html__( 'Bold', 'cit' ),
			),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h6_font_style', array(
			'label'   => esc_html__( 'Font Style', 'cit' ),
			'section' => 'cit_fonts_and_style_h6',
			'settings'   => 'cit_fonts_and_style_h6_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'cit' ),
				'italic' => esc_html__( 'Italic', 'cit' ),
				'oblique' => esc_html__( 'Oblique', 'cit' ),
				'inherit' => esc_html__( 'Inherit', 'cit' ),
			),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h6_font_size', array(
			'label'   => esc_html__( 'Size', 'cit' ),
			'section' => 'cit_fonts_and_style_h6',
			'settings'   => 'cit_fonts_and_style_h6_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h6_line_height', array(
			'label'   => esc_html__( 'Line Height', 'cit' ),
			'section' => 'cit_fonts_and_style_h6',
			'settings'   => 'cit_fonts_and_style_h6_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h6_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'cit' ),
			'section' => 'cit_fonts_and_style_h6',
			'settings'   => 'cit_fonts_and_style_h6_letter_spacing',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h6_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'cit' ),
			'section' => 'cit_fonts_and_style_h6',
			'settings'   => 'cit_fonts_and_style_h6_margin_top',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h6_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'cit' ),
			'section' => 'cit_fonts_and_style_h6',
			'settings'   => 'cit_fonts_and_style_h6_margin_bottom',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_h6_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'cit' ),
			'section' => 'cit_fonts_and_style_h6',
			'settings'   => 'cit_fonts_and_style_h6_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'cit' ),
				'uppercase' => esc_html__( 'Uppercase', 'cit' ),
				'lowercase' => esc_html__( 'Lowercase', 'cit' ),
				'capitalize' => esc_html__( 'Capitalize', 'cit' ),
			),
		) );
	}

	/**
	 * Body fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_body( $wp_customize ) {
		$wp_customize->add_setting( 'cit_fonts_and_style_body_primary_color', array(
			'default'        => '#555555',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_body_secondary_text_color', array(
			'default'        => '#777777',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_body_active_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_body_font_family', array(
			'default'        => 'Roboto',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_body_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_body_font_size', array(
			'default'        => '16px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_body_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_body_line_height', array(
			'default'        => '1.7',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_body_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_body_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_body_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_body_margin_bottom', array(
			'default'        => '1.5rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_body_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_body_primary_color',
				array(
					'label'         => esc_html__( 'Primary Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_body',
					'settings'      => 'cit_fonts_and_style_body_primary_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_body_secondary_text_color',
				array(
					'label'         => esc_html__( 'Secondary Color', 'cit' ),
					'description'   => esc_html__( 'Secondary text color will be applied to block quotes, image captions, etc.', 'cit' ),
					'section'       => 'cit_fonts_and_style_body',
					'settings'      => 'cit_fonts_and_style_body_secondary_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_body_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'cit' ),
					'description'   => esc_html__( 'Active color that will be applied to links and bullets.', 'cit' ),
					'section'       => 'cit_fonts_and_style_body',
					'settings'      => 'cit_fonts_and_style_body_active_color',
				)
			)
		);

		$wp_customize->add_control( 'cit_fonts_and_style_body_font_family', array(
			'label'   => esc_html__( 'Font-family', 'cit' ),
			'section' => 'cit_fonts_and_style_body',
			'settings'   => 'cit_fonts_and_style_body_font_family',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_body_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'cit' ),
			'section' => 'cit_fonts_and_style_body',
			'settings'   => 'cit_fonts_and_style_body_subsets',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_body_weight', array(
			'label'   => esc_html__( 'Font Weight', 'cit' ),
			'section' => 'cit_fonts_and_style_body',
			'settings'   => 'cit_fonts_and_style_body_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'cit' ),
				'400' => esc_html__( 'Normal (default)', 'cit' ),
				'600' => esc_html__( 'Semi-Bold', 'cit' ),
				'700' => esc_html__( 'Bold', 'cit' ),
			),
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_body_font_style', array(
			'label'   => esc_html__( 'Font Style', 'cit' ),
			'section' => 'cit_fonts_and_style_body',
			'settings'   => 'cit_fonts_and_style_body_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'cit' ),
				'italic' => esc_html__( 'Italic', 'cit' ),
				'oblique' => esc_html__( 'Oblique', 'cit' ),
				'inherit' => esc_html__( 'Inherit', 'cit' ),
			),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_body_font_size', array(
			'label'   => esc_html__( 'Size', 'cit' ),
			'section' => 'cit_fonts_and_style_body',
			'settings'   => 'cit_fonts_and_style_body_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_body_line_height', array(
			'label'   => esc_html__( 'Line Height', 'cit' ),
			'section' => 'cit_fonts_and_style_body',
			'settings'   => 'cit_fonts_and_style_body_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_body_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'cit' ),
			'section' => 'cit_fonts_and_style_body',
			'settings'   => 'cit_fonts_and_style_body_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_body_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'cit' ),
			'section' => 'cit_fonts_and_style_body',
			'settings'   => 'cit_fonts_and_style_body_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_body_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'cit' ),
			'section' => 'cit_fonts_and_style_body',
			'settings'   => 'cit_fonts_and_style_body_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_body_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'cit' ),
			'section' => 'cit_fonts_and_style_body',
			'settings'   => 'cit_fonts_and_style_body_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'cit' ),
				'uppercase' => esc_html__( 'Uppercase', 'cit' ),
				'lowercase' => esc_html__( 'Lowercase', 'cit' ),
				'capitalize' => esc_html__( 'Capitalize', 'cit' ),
			),
		) );
	}

	/**
	 * Buttons fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_buttons( $wp_customize ) {
		$wp_customize->add_setting( 'cit_fonts_and_style_buttons_background_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_buttons_text_color', array(
			'default'        => '#f4f4f4',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_buttons_background_hover_color', array(
			'default'        => '#3c63a6',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_buttons_text_hover_color', array(
			'default'        => '#f4f4f4',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_buttons_font_family', array(
			'default'        => 'Playfair Display',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_buttons_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_buttons_font_size', array(
			'default'        => '16px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'cit_fonts_and_style_buttons_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_buttons_line_height', array(
			'default'        => '1',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_buttons_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_buttons_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_buttons_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_buttons_margin_bottom', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'cit_fonts_and_style_buttons_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_buttons_background_color',
				array(
					'label'         => esc_html__( 'Background Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_buttons',
					'settings'      => 'cit_fonts_and_style_buttons_background_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_buttons_text_color',
				array(
					'label'         => esc_html__( 'Text Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_buttons',
					'settings'      => 'cit_fonts_and_style_buttons_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_buttons_background_hover_color',
				array(
					'label'         => esc_html__( 'Background Hover Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_buttons',
					'settings'      => 'cit_fonts_and_style_buttons_background_hover_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cit_fonts_and_style_buttons_text_hover_color',
				array(
					'label'         => esc_html__( 'Text Hover Color', 'cit' ),
					'section'       => 'cit_fonts_and_style_buttons',
					'settings'      => 'cit_fonts_and_style_buttons_text_hover_color',
				)
			)
		);

		$wp_customize->add_control( 'cit_fonts_and_style_buttons_font_family', array(
			'label'   => esc_html__( 'Font-family', 'cit' ),
			'section' => 'cit_fonts_and_style_buttons',
			'settings'   => 'cit_fonts_and_style_buttons_font_family',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_buttons_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'cit' ),
			'section' => 'cit_fonts_and_style_buttons',
			'settings'   => 'cit_fonts_and_style_buttons_subsets',
			'type'    => 'select',
			'choices'     => citthemestarter_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_buttons_weight', array(
			'label'   => esc_html__( 'Font Weight', 'cit' ),
			'section' => 'cit_fonts_and_style_buttons',
			'settings'   => 'cit_fonts_and_style_buttons_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'cit' ),
				'400' => esc_html__( 'Normal (default)', 'cit' ),
				'600' => esc_html__( 'Semi-Bold', 'cit' ),
				'700' => esc_html__( 'Bold', 'cit' ),
			),
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_buttons_font_style', array(
			'label'   => esc_html__( 'Font Style', 'cit' ),
			'section' => 'cit_fonts_and_style_buttons',
			'settings'   => 'cit_fonts_and_style_buttons_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'cit' ),
				'italic' => esc_html__( 'Italic', 'cit' ),
				'oblique' => esc_html__( 'Oblique', 'cit' ),
				'inherit' => esc_html__( 'Inherit', 'cit' ),
			),
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_buttons_font_size', array(
			'label'   => esc_html__( 'Size', 'cit' ),
			'section' => 'cit_fonts_and_style_buttons',
			'settings'   => 'cit_fonts_and_style_buttons_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_buttons_line_height', array(
			'label'   => esc_html__( 'Line Height', 'cit' ),
			'section' => 'cit_fonts_and_style_buttons',
			'settings'   => 'cit_fonts_and_style_buttons_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'cit_fonts_and_style_buttons_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'cit' ),
			'section' => 'cit_fonts_and_style_buttons',
			'settings'   => 'cit_fonts_and_style_buttons_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_buttons_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'cit' ),
			'section' => 'cit_fonts_and_style_buttons',
			'settings'   => 'cit_fonts_and_style_buttons_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_buttons_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'cit' ),
			'section' => 'cit_fonts_and_style_buttons',
			'settings'   => 'cit_fonts_and_style_buttons_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'cit_fonts_and_style_buttons_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'cit' ),
			'section' => 'cit_fonts_and_style_buttons',
			'settings'   => 'cit_fonts_and_style_buttons_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'cit' ),
				'uppercase' => esc_html__( 'Uppercase', 'cit' ),
				'lowercase' => esc_html__( 'Lowercase', 'cit' ),
				'capitalize' => esc_html__( 'Capitalize', 'cit' ),
			),
		) );
	}
}




function theme_contact_customizer( $wp_customize ) {           
    //your section
        $wp_customize->add_section( 
            'theme_contact_customizer_your_section', 
            array(
                'title' => esc_html__( 'Contact', 'cit' ),
                'priority' => 103
            )
        );      
          
                  
    //add setting to Phone
        $wp_customize->add_setting( 
            'theme_contact_customizer_number', 
            array(
				'default' => '+1 206-551-0461',
                'sanitize_callback' => 'wp_filter_nohtml_kses' //cleans URL from all invalid characters
            )
        );
          
        $wp_customize->add_control( 
            'theme_contact_customizer_number', 
            array(
                'label' => esc_html__( 'Phone', 'cit' ),
                'section' => 'theme_contact_customizer_your_section',
                'type' => 'text'
            )
        );
		
		
		//add setting to Email
        $wp_customize->add_setting( 
            'theme_contact_customizer_email', 
            array(
				'default' => 'info@Bezgever.com',
                'sanitize_callback' => 'sanitize_email' //cleans URL from all invalid characters
            )
        );
          
        $wp_customize->add_control( 
            'theme_contact_customizer_email', 
            array(
                'label' => esc_html__( 'Email', 'cit' ),
                'section' => 'theme_contact_customizer_your_section',
                'type' => 'email'
            )
        );    

		//add setting to Address
        $wp_customize->add_setting( 
            'theme_contact_customizer_address', 
            array(
				'default' => '3525 Route d Cupelin, Terminalgatan, Vellinge ',
                'sanitize_callback' => 'wp_filter_nohtml_kses' //cleans URL from all invalid characters
            )
        );
          
        $wp_customize->add_control( 
            'theme_contact_customizer_address', 
            array(
                'label' => esc_html__( 'Address', 'cit' ),
                'section' => 'theme_contact_customizer_your_section',
                'type' => 'text'
            )
        );

		//add setting to Button Text
        $wp_customize->add_setting( 
            'theme_contact_customizer_repair', 
            array(
				'default' => '662-688-1463',
                'sanitize_callback' => 'wp_filter_nohtml_kses' //cleans URL from all invalid characters
            )
        );
          
        $wp_customize->add_control( 
            'theme_contact_customizer_repair', 
            array(
                'label' => esc_html__( 'Fax', 'cit' ),
                'section' => 'theme_contact_customizer_your_section',
                'type' => 'text'
            )
        );

		//add setting to Button Url
        $wp_customize->add_setting( 
            'theme_contact_customizer_url', 
            array(
				'default' => home_url().'/forum',
                'sanitize_callback' => 'wp_filter_nohtml_kses' //cleans URL from all invalid characters
            )
        );
          
        $wp_customize->add_control( 
            'theme_contact_customizer_url', 
            array(
                'label' => esc_html__( 'Top Header Forum Url', 'cit' ),
                'section' => 'theme_contact_customizer_your_section',
                'type' => 'text'
            )
        );

		//add setting to Button Url
        $wp_customize->add_setting( 
            'theme_contact_customizer_radio_url', 
            array(
				'default' => home_url().'/radio',
                'sanitize_callback' => 'wp_filter_nohtml_kses' //cleans URL from all invalid characters
            )
        );
          
        $wp_customize->add_control( 
            'theme_contact_customizer_radio_url', 
            array(
                'label' => esc_html__( 'Top Header Radio Show Url', 'cit' ),
                'section' => 'theme_contact_customizer_your_section',
                'type' => 'text'
            )
        );
      
}
add_action( 'customize_register', 'theme_contact_customizer' );