<?php 

function how_many_our_services_show_in_page($atts, $content=null){
	extract(shortcode_atts( array(
		'how_many_post'		=> '6'
	), $atts ));
	
	$args = array(
		'posts_per_page'   => $how_many_post,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'services',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'author'	   => '',
		'author_name'	   => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	ob_start();
	$posts = new WP_Query($args);
	?>
		<div class="service text-center">
			<div class="row">
					<?php
					while($posts->have_posts()) : $posts->the_post();
					$description = wp_trim_words( get_the_content(), '15', '...' );	
					$iconmeta = get_field('service_icon');
					?>
					<div class="col-md-4 col-sm-6 service-single">
                        <img src="<?php echo $iconmeta; ?>" class="img-responsive">
                        <h4><strong><?php the_title(); ?></strong></h4>
                        <p><?php echo $description; ?></p>
                        <p><a href="<?php the_permalink(); ?>"><?php echo esc_html__( 'find out more', 'cit' ) ?></a></p>
                    </div>
					<?php
				endwhile; ?>
			</div>
		</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'our_services_view', 'how_many_our_services_show_in_page' );

function fancybox_video_view_show_in_page($atts, $content=null){
	extract(shortcode_atts( array(
		'video_link'  => 'https://www.youtube.com/watch?v=kxPCFljwJws',
		'thumbnail_image'  => '',
	), $atts ));

	$thumbnail_img = explode(',',$thumbnail_image);

	ob_start();
	?>

		<div class="inner-column">
        	<!--Video Box-->
            <div class="video-box">
                <figure class="image">
                <?php foreach( $thumbnail_img as $thumbnail_image){
                    $images = wp_get_attachment_image_src($thumbnail_image, 'full'); ?>
                    <img src="<?php echo $images[0]; ?>" alt="">
                <?php } ?>
                    <a href="<?php echo $video_link; ?>" data-fancybox class="lightbox-image overlay-box"><span class="flaticon-arrow"></span></a>
                </figure>
            </div>
        </div>

	<?php
	return ob_get_clean();
}
add_shortcode( 'fancybox_video', 'fancybox_video_view_show_in_page' );

function how_many_programs_view_show_in_page($atts, $content=null){
	extract(shortcode_atts( array(
		'blog_view'		=> '9'
	), $atts ));

	$args = array(
		'posts_per_page'   => $blog_view,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'programs',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'author'	   => '',
		'author_name'	   => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	ob_start();
	$posts = new WP_Query($args);
	?>
		<div class="content-section clearfix">
			<div class="row">
				<?php
					while($posts->have_posts()) : $posts->the_post();
					$thumbnails = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full');
					$description = wp_trim_words( get_the_content(), '15', '...' );	
					?>
					 <div class="col-md-4 col-sm-6">
						<article class="programs-post">	
							<div class="programs-image">	
								<img src="<?php echo $thumbnails[0]; ?>" alt="">
							</div>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title();  ?></a></h3>
						</article>
					</div>
					<?php
				endwhile; ?>
			</div>
		</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'program_show_view', 'how_many_programs_view_show_in_page' );


function how_many_gallery_iamge_in_page($atts, $content=null){
	extract(shortcode_atts( array(
		'thumbnail_image'		=> '',
	), $atts ));
	$thumbnail_img = explode(',',$thumbnail_image);
	ob_start();
	?>
		<div class="content-section clearfix">
			<div class="home_image_gallery">
				<?php 
				$q = 0;
				foreach( $thumbnail_img as $thumbnail_image){ 
					$images = wp_get_attachment_image_src($thumbnail_image, 'full'); ?>
					<div class="singleGalleryitem">
						<a data-fancybox="group<?php echo $q; ?>" href="<?php echo $images[0]; ?>"><img src="<?php echo $images[0]; ?>" alt=""></a>
					</div>
				<?php $q++;} ?>
				
				
			</div>
		</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'gallery_iamge', 'how_many_gallery_iamge_in_page' );

function how_many_publication_view_in_page($atts, $content=null){
	extract(shortcode_atts( array(
		'item_show'		=> '12'
	), $atts ));

	$args = array(
		'posts_per_page'   => $item_show,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'publications',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'author'	   => '',
		'author_name'	   => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	ob_start();
	$posts = new WP_Query($args);
	?>
		<div class="content-section clearfix">
			<div class="row">
				<div class="testimonialsarea clearfix">
				<?php
					while($posts->have_posts()) : $posts->the_post();
					
					$thumbnails = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full');
					$description = wp_trim_words( get_the_content(), '12', '...' );	
					$youtube_url = get_field('youtube_video_url');
					$other_url = get_field('youtube_other_url');
					$color_select = get_field('color_select');
					if(!empty($youtube_url)){
						$url = $youtube_url;
						$target = "fancybox";
					}else{
						$url = $other_url;
						$target = "target='_blank'";
					}
				?>
					<article class="publications-post col-md-4">	
						<div class="publications-image">	
							<img src="<?php echo $thumbnails[0]; ?>" alt="">
							<a <?php echo $target; ?> href="<?php echo $url; ?>"></a>
						</div>
						<div class="publicationsContent" style="background-color: <?php echo $color_select; ?>">
							<h3><?php the_title(); ?></h3>
							<p><?php echo $description; ?></p>
						</div>
					</article>
				<?php endwhile; ?>
				</div>
			</div>
		</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'publication_view', 'how_many_publication_view_in_page' );







function how_many_service_view_show_in_page($atts, $content=null){
	extract(shortcode_atts( array(
		'blog_how'		=> '3',
	), $atts ));

	$args = array(
		'posts_per_page'   => $blog_how,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'post',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'author'	   => '',
		'author_name'	   => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	
	$posts = new WP_Query($args);
	$html = '';

	$html .= '<div class="content-section clearfix"> ';
		$html .= '<div class="row">';
			$html .= '<div class="our-posthome clearfix">';
				while($posts->have_posts()) : $posts->the_post();
				$thumbnails = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full');
				$description = wp_trim_words( get_the_content(), '12', '...' );	
					$html .= '<div class="col-md-4 col-sm-4">';
						$html .= '<div class="single-posthome">';
							$html .= '<div class="our-posthome">';
								$html .= '<img src="'.$thumbnails[0].'" alt="" />';
								$html .= '<p>'.get_the_date('d f Y').' | News</p>';
							$html .= '</div>';
							$html .= '<div class="ourposthome">';
								$html .= '<h3>'.get_the_title().'</h3>';
								$html .= '<p>'.$description.'</p>';
							$html .= '</div>';
						$html .= '</div>';
					$html .= '</div>';
				endwhile;
			$html .= '</div>';
		$html .= '</div>';
	$html .= '</div>';
	
	return $html;
}
add_shortcode( 'home_post_view', 'how_many_service_view_show_in_page' );




function how_many_social_view_show($atts, $content=null){
	extract(shortcode_atts( array(
		'facebook_link'		=> '',
		'twitter_link'		=> '',
		'linkedin_link'		=> '',
		'instagram_link' => '',
	), $atts ));
	
	$html = '';

		$html .= '<div class="socialLink"> ';
		$html .= '<h4>Follow Us</h4>';
					$html .= '<ul>';
					if(!empty($facebook_link)){
						$html .= '<li><a target="_blank" href="'.$facebook_link.'"><i class="fa fa-facebook-square"></i></a></li>';
					}
					if(!empty($twitter_link)){
						$html .= '<li><a target="_blank" href="'.$twitter_link.'"><i class="fa fa-twitter-square"></i></a></li>';
					}
					if(!empty($linkedin_link)){
						$html .= '<li><a target="_blank" href="'.$linkedin_link.'"><i class="fa fa-linkedin-square"></i></a></li>';
					}
					if(!empty($instagram_link)){
						$html .= '<li><a target="_blank" href="'.$instagram_link.'"><i class="fa fa-instagram"></i></a></li>';
					}
				$html .= '</ul>';
				$html .= '</div>';
	return $html;
}
add_shortcode( 'social_view', 'how_many_social_view_show' );


function how_many_footer_carosel_view_show($atts, $content=null){
	extract(shortcode_atts( array(
		'slide_title'		=> '',
		'slide_items'		=> '',
		'slide_class' => ''
	), $atts ));

	$image_ids = explode(',',$slide_items);
	
	$html = '';

		$html .= '<div class="footer_carosel_area '.$slide_class.'"> ';
			if(!empty($slide_title)){
				$html .= '<h2>'.$slide_title.'</h2>';
			}
			$html .= '<div class="footer_carosel">';
			$q = 0;
			foreach( $image_ids as $image_id){
				$images = wp_get_attachment_image_src($image_id, 'full');
			$html .= '<a class="multiple" href="'.$images[0].'" data-fancybox="group'.$q.'" >';
			$html .= '<img src="'.$images[0].'" alt="" />';
			$html .= '</a>';
			}
			$q++;
			$html .= '</div>';
		$html .= '</div>';
	return $html;
}
add_shortcode( 'footer_carosels', 'how_many_footer_carosel_view_show' );


function how_many_mission_view_show($atts, $content=null){
	extract(shortcode_atts( array(
		'slide_items'		=> '',
		'title'		=> ''
	), $atts ));
	$image_ids = explode(',',$slide_items);
	
	$html = '';

		$html .= '<div class="mission_carosel_area"> ';
			$html .= '<div class="mission_carosel">';
				foreach( $image_ids as $image_id){
					$images = wp_get_attachment_image_src($image_id, 'full');
				$html .= '<div class="multipleSlider">';
					$html .= '<img src="'.$images[0].'" alt="" />';
				$html .= '</div>';
				}
				$html .= '<div class="sliderContentMission">';
					$html .= '<h4>Bezgever LLC</h4>';
					$html .= '<h1>'.$title.'</h1>';
					$html .= '<div class="contentSilde">'.$content.'</div>';
				$html .= '</div>';
			$html .= '</div>';
		$html .= '</div>';
	return $html;
}
add_shortcode( 'missionSileder', 'how_many_mission_view_show' );


function how_many_customer_team_show($atts, $content=null){
	extract(shortcode_atts( array(
		'service_image'	=> '',
		'title' => '',		
		'page_url' => ''
	), $atts ));
	$image_ids = explode(',',$service_image);
	$href = vc_build_link( $page_url );
	$html = '';
		$html .= '<div class="benefitarea">';
					foreach( $image_ids as $image_id){
						$images = wp_get_attachment_image_src($image_id, 'full');
						$html .= '<div style="background-image:url('.$images[0].');" class="course_image"></div>';
					}
				$html .= '<div class="blogContentss">';
					$html .= '<a href="'.$href['url'].'"><span>'.$title.'</span> <i class="fa fa-angle-right"></i></a>';
				$html .= '</div>';
		$html .= '</div>';
	return $html;
}
add_shortcode( 'our_service', 'how_many_customer_team_show' );

function how_many_customer_learn_show($atts, $content=null){
	extract(shortcode_atts( array(
		'title' => '',		
		'page_url' => '',
		'color' => ''
	), $atts ));
	$image_ids = explode(',',$service_image);
	$href = vc_build_link( $page_url );
	$html = '';
		$html .= '<div class="leranItem" style="background-color:'.$color.'">';
				$html .= '<div class="lernSingle">';
				$html .= '<span class="countNum">0</span>';
					$html .= '<a href="'.$href['url'].'"><span>'.$title.'</span></a>';
				$html .= '</div>';
		$html .= '</div>';
	return $html;
}
add_shortcode( 'our_learn', 'how_many_customer_learn_show' );

function how_many_our_team_show($atts, $content=null){
	extract(shortcode_atts( array(
		'team_image'	=> '',
		'teamname' => '',
		'designation' => ''
	), $atts ));
	$image_ids = explode(',',$team_image);
	$html = '';
		$html .= '<div class="teammenberarea clearfix">';
				$html .= '<div class="teams_image">';
					foreach( $image_ids as $image_id){
						$images = wp_get_attachment_image_src($image_id, 'full');
						$html .= '<img src="'.$images[0].'" alt="" />';
					}
				$html .= '</div>';
				$html .= '<div class="team_member">';
					$html .= '<h3>'.$teamname.'</h3>';
					$html .= '<p>'.$designation.'</p>';
					$html .= '<div class="teamcontent">'.$content.'</div>';
				$html .= '</div>';
		$html .= '</div>';
	return $html;
}
add_shortcode( 'our_team', 'how_many_our_team_show' );


function how_property_list_btn_view_show($atts, $content=null){
	extract(shortcode_atts( array(
		'headding_text'		=> '',
		'subhedding'		=> '',
		'title_text'		=> '',
		'inactive' => '',
		'menu_link' => '',
		'step_list' => '',
	), $atts ));
	$href = vc_build_link( $menu_link );
	$values = vc_param_group_parse_atts($atts['step_list']);
	
	  $new_accordion_value = array();
	  foreach($values as $data){
		$new_line = $data;
		$new_line['title_text'] = isset($new_line['title_text']) ? $new_line['title_text'] : '';
		$new_line['inactive'] = isset($new_line['inactive']) ? $new_line['inactive'] : '';

		$new_accordion_value[] = $new_line;

	}
	
	
	$html = '';
		$html .= '<div class="stepItemwrapper">';
	
			$html .= '<div class="stepItemsss">';
				$html .= '<div class="stepItem">';
					$html .= '<h2>'.$headding_text.'</h2>';
					$html .= '<p>'.$subhedding.'</p>';
				$html .= '</div>';
						$html .= '<ul>';
						$q = 1;
						foreach( $new_accordion_value as $accordion){
							$title_text = $accordion['title_text'];
							$contents = $accordion['inactive'];
							$inactives = empty($contents) ? '' : 'inactive';
								$html .= '<li class="'.$inactives.'">'.$title_text.'</li>';
							$q++; }
						$html .= '</ul>';
			$html .= '</div>';
			$html .= '<div class="text-center">';
				$html .= '<a class="readMore2" href="'.$href['url'].'">REQUEST MORE INFO  <i class="fa fa-arrow-right"></i></a>';
			$html .= '</div>';
		$html .= '</div>';
	return $html;
}
add_shortcode( 'property_list', 'how_property_list_btn_view_show' );