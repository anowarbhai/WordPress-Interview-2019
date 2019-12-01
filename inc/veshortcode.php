<?php

//Shortcodes for Visual Composer

function cit_custom_element_for_visual_composer() {

	vc_map(array(
		'name'	=> 'Our Services',
		'description' => 'Our Services in page' ,
		'base'	=> 'our_services_view',
		'class'	=> '',
		'category'	=> esc_html__('CIT Elements', 'james'),
		'icon'	=> 'vc_mgt_clients_reviews',
		'params'	=> array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'How Many Posts?', 'james' ),
				'param_name' => 'how_many_post',
				"std"			=> "6",
			)
			
		)
	));
	
	vc_map(array(
		'name'	=> 'Fancybox Video',
		'description' => 'Fancybox Video in page' ,
		'base'	=> 'fancybox_video',
		'class'	=> '',
		'category'	=> esc_html__('CIT Elements', 'james'),
		'icon'	=> 'vc_mgt_clients_reviews',
		'params'	=> array(
			array(
				"type"			=> "textfield",
				"holder"		=> "h3",
				"class" 		=> "hide_in_vc_editor",
				"admin_label" 	=> true,
				'description' 	=> "YouTube Video Link Or ID Ex: https://www.youtube.com/watch?v=kxPCFljwJws) Or (QY6v5SO_X7E)",
				"heading"		=> "YouTube Video",
				"param_name"	=> "video_link",
				"value"			=> '',
				"std"			=> "https://www.youtube.com/watch?v=kxPCFljwJws",
			),
			 array(
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				"admin_label" => false,
				'heading' => esc_html__( 'Video Poster', 'james' ),
				'param_name' => 'thumbnail_image',
				"std"			=> "",
			),
			
		)
	));

	vc_map(array(
		'name'	=> 'Program View',
		'description' => 'Show Program View in page' ,
		'base'	=> 'program_show_view',
		'class'	=> '',
		'category'	=> esc_html__('CIT Elements', 'james'),
		'icon'	=> 'vc_mgt_clients_reviews',
		'params'	=> array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'How Many Posts?', 'james' ),
				'param_name' => 'blog_view',
				"std"			=> "9",
			)
		)
	));

	vc_map(array(
		'name'	=> 'Publication View',
		'description' => 'Show Publication View in page' ,
		'base'	=> 'publication_view',
		'class'	=> '',
		'category'	=> esc_html__('CIT Elements', 'james'),
		'icon'	=> 'vc_mgt_clients_reviews',
		'params'	=> array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'How Many Posts?', 'james' ),
				'param_name' => 'item_show',
				"std"			=> "12",
			)
		)
	));
	vc_map(array(
		'name'	=> 'Post View',
		'description' => 'Show Post View in page' ,
		'base'	=> 'home_post_view',
		'class'	=> '',
		'category'	=> esc_html__('CIT Elements', 'james'),
		'icon'	=> 'vc_mgt_clients_reviews',
		'params'	=> array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'How Many Posts?', 'james' ),
				'param_name' => 'blog_how',
				"std"			=> "3",
			)
		)
	));


	vc_map(array(
		'name'	=> 'Image Gallery',
		'description' => 'Show Gallery' ,
		'base'	=> 'gallery_iamge',
		'class'	=> '',
		'category'	=> esc_html__('CIT Elements', 'james'),
		'icon'	=> 'vc_mgt_clients_reviews',
		'params'	=> array(
			array(
				'type' => 'attach_images',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				"admin_label" => false,
				'heading' => esc_html__( 'Slider Image', 'james' ),
				'param_name' => 'thumbnail_image',
				"std"			=> "",
			)
		)
	));


		vc_map(array(
		'name'	=> 'Social Link',
		'description' => 'Show Social Link' ,
		'base'	=> 'social_view',
		'class'	=> '',
		'category'	=> esc_html__('CIT Elements', 'james'),
		'icon'	=> 'vc_mgt_clients_reviews',
		'params'	=> array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				"admin_label" 	=> true,
				'heading' => esc_html__( 'Facebook', 'james' ),
				'param_name' => 'facebook_link',
				"std"			=> "",
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				"admin_label" 	=> true,
				'heading' => esc_html__( 'Twitter Link', 'james' ),
				'param_name' => 'twitter_link',
				"std"			=> "",
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				"admin_label" 	=> true,
				'heading' => esc_html__( 'Linked In', 'james' ),
				'param_name' => 'linkedin_link',
				"std"			=> "",
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				"admin_label" 	=> true,
				'heading' => esc_html__( 'Instagram', 'james' ),
				'param_name' => 'instagram_link',
				"std"			=> "",
			),
		)
	));

	
	
	
		vc_map(array(
		"name" 			=> "Footer Slider",
		"description"	=> "Show Footer Slider",
		"base" 			=> "footer_carosels",
		"class" 			=> "",
		"category" => esc_html__( 'CIT Elements', 'james'),
		"icon" 			=> "vc_mgt_clients_reviews",
		"params" 	=> array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Widget title', 'james' ),
				'param_name' => 'slide_title',
				"std"			=> "",
			),
			array(
				'type' => 'attach_images',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Slider Images', 'james' ),
				'param_name' => 'slide_items',
				"std"			=> "",
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Extra class name', 'james' ),
				'param_name' => 'slide_class',
				"std"			=> "",
			),
	   )
	));
	
	
	
		vc_map(array(
		"name" 			=> "Mission Slider",
		"description"	=> "Show Mission Slider",
		"base" 			=> "missionSileder",
		"class" 			=> "",
		"category" => esc_html__( 'CIT Elements', 'james'),
		"icon" 			=> "vc_mgt_clients_reviews",
		"params" 	=> array(
			array(
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Slider Images', 'james' ),
				'param_name' => 'slide_items',
				"std"			=> "",
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Title', 'james' ),
				'param_name' => 'title',
				"std"			=> "",
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Description', 'james' ),
				'param_name' => 'content',
				"std"			=> "",
			),
	   )
	));


	vc_map(array(
		"name" 			=> "Home Service",
		"description"	=> "Show Home Service",
		"base" 			=> "our_service",
		"class" 			=> "",
		"category" => esc_html__( 'CIT Elements', 'james'),
		"icon" 			=> "vc_mgt_clients_reviews",
		"params" 	=> array(
			array(
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Image', 'james' ),
				'param_name' => 'service_image',
				"std"			=> "",
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Title', 'james' ),
				'param_name' => 'title',
				"std"			=> "",
			),
			array(
				'type' => 'vc_link',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Page Url', 'james' ),
				'param_name' => 'page_url',
				"std"			=> "",
			)
	   )
	));


	vc_map(array(
		"name" 			=> "Learn",
		"description"	=> "Show Learn",
		"base" 			=> "our_learn",
		"class" 			=> "",
		"category" => esc_html__( 'CIT Elements', 'james'),
		"icon" 			=> "vc_mgt_clients_reviews",
		"params" 	=> array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Title', 'james' ),
				'param_name' => 'title',
				"std"			=> "",
			),
			array(
				'type' => 'vc_link',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Page Url', 'james' ),
				'param_name' => 'page_url',
				"std"			=> "",
			),
			array(
				'type' => 'colorpicker',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'BG Color', 'james' ),
				'param_name' => 'color',
				"value" => '#FF0000',
				"description" => esc_html__( "Choose BG color", "james" )
			)
	   )
	));

	vc_map(array(
		"name" 			=> "Our Team",
		"description"	=> "Show Our Team",
		"base" 			=> "our_team",
		"class" 			=> "",
		"category" => esc_html__( 'CIT Elements', 'james'),
		"icon" 			=> "vc_mgt_clients_reviews",
		"params" 	=> array(
			array(
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Team Image', 'james' ),
				'param_name' => 'team_image',
				"std"			=> "",
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Team Name', 'james' ),
				'param_name' => 'teamname',
				"std"			=> "",
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Designation', 'james' ),
				'param_name' => 'designation',
				"std"			=> "",
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Description', 'james' ),
				'param_name' => 'content',
				"std"			=> "",
			),
	   )
	));

	vc_map(array(
		"name" 			=> "Property",
		"description"	=> "Property View",
		"base" 			=> "property_list",
		"class" 			=> "",
		"category" => esc_html__( 'CIT Elements', 'james'),
		"icon" 			=> "vc_mgt_clients_reviews",
		"params" 	=> array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Headding', 'james' ),
				'param_name' => 'headding_text',
				"std"			=> "",
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Sub Hedding', 'james' ),
				'param_name' => 'subhedding',
				"std"			=> "",
			),
			array(
				'type'		=>'param_group',
				'holder' 	=> 'div',
				'heading'	=>'Step List',
				'class' => 'hide_in_vc_editor',
				'param_name'=>'step_list',
				'params'	=>array(
					array(
						'type' => 'textfield',
						'holder' => 'div',
						'class' => 'hide_in_vc_editor',
						'heading' => esc_html__( 'List Item', 'james' ),
						'param_name' => 'title_text',
						"std"			=> "",
					),
					array(
						"type"        => "checkbox",
						"heading"     => __("Is this list inactive?"),
						"param_name"  => "inactive",
						"admin_label" => true,
					   "value"       => array('Yes'=>'inactive'), //value
						"std"         => " ",
						"description" => __("If you want inactive info. So check please!")
					),
				)
			),
			array(
				'type' => 'vc_link',
				'holder' => 'div',
				'class' => 'hide_in_vc_editor',
				'heading' => esc_html__( 'Set Link', 'james' ),
				'param_name' => 'menu_link',
				'std'			=> "#",
				'description' => __( "Choose Url", "james" )
			),
		)
	));
	
}
add_action( 'vc_before_init', 'cit_custom_element_for_visual_composer' );

