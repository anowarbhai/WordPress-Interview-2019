<?php
/**
 * Header
 *
 * @package WordPress
 * @subpackage CIT Theme Starterr
 * @since CIT Theme Starterr 1.0
 */
?>
	<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<?php citthemestarter_hook_after_head(); ?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php wp_head() ?>
	</head>
<body <?php body_class(); ?>>

<?php if ( citthemestarter_is_the_header_displayed() ) : ?>

	 <div id="animatedDiv">
		<div class="animatedInner">
			<img src="<?php echo get_template_directory_uri(); ?>/images/blu/animated_header.png" class="img-responsive" alt="">
			<span class="cross"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/blu/cross.png"></a></span>
			<h2>Hi There,</h2>
			<h3>Are you a corporate customer?</h3>
			<p>Lorem Ipsum is simply dummy text of the printing and ype setting industry. </p>
			<a href="<?php echo home_url(); ?>/contact-us">enquery now</a>    
		</div>
	</div>
	
	<?php citthemestarter_hook_before_header(); ?>
	<!-- header top section-->
	<header class="navbar-fixed-top" data-spy="affix" data-offset-top="197">
		<div class="<?php echo esc_attr( citthemestarter_get_header_container_class() ); ?>">
			<div class="row">
				<div class="header_top clearfix">
					<div class="col-md-2">
						<div class="logo_img">
							<?php
								if ( has_custom_logo() ) :
									the_custom_logo();
								else : ?>
									<h1>
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
											<?php bloginfo( 'name' ); ?>
										</a>
									</h1>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-md-10">
						<?php if ( citthemestarter_is_the_header_top_displayed() ) : ?>
							<div class="menu_top">
								<?php
									wp_nav_menu( array(
										'theme_location' => 'top_menu',
										'menu_class'     => 'nav navbar-nav',
										'container'      => '',
									) );
								?>
							</div>
						<?php endif; ?>
						<div class="menu_bar">
							<nav role="navigation" class="navbar navbar-default">
								<?php do_action( 'citthemestarter_after_navbar_brand' ); ?>
								<?php if ( has_nav_menu( 'primary' ) ) : ?>
									<div class="navbar-header">
										<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
											<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'cit' ) ?></span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
										</button>
									</div>
								<?php endif; ?>
								<?php if ( has_nav_menu( 'primary' ) ) : ?>
									<div class="collapse navbar-collapse" id="navbar">
										
										<?php
										wp_nav_menu( array(
											'theme_location' => 'primary',
											'menu_class'     => 'nav navbar-nav',
											'container'      => '',
										) );
										?>
										<?php do_action( 'citthemestarter_after_header_widget_area' ); ?>
									</div><!--#main-menu-->
								<?php endif; ?>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<?php citthemestarter_hook_after_header(); ?>
	<!-- header top section-->
		<?php endif; ?>

		<?php
			$banner = get_field('banner_image');
			$banner_title = get_field('banner_title');
			
			if(!empty($banner)){
				$banners = $banner;
			}else{
				if(is_blog()){
					$pageid = get_queried_object_ID();
					$imagemeta     = get_post_meta( $pageid, 'banner_image', true );
					$thumbnail_url = wp_get_attachment_image_src($imagemeta, 'full', true );
					if(!empty($imagemeta)){
						$banners = $thumbnail_url[0];
					}else{
						$banners = get_template_directory_uri().'/images/banner.png';
					}
				}else{
					$banners = get_template_directory_uri().'/images/banner.png';
				}
			}
			
		?>
		<!-- banner section-->
		<section id="home" class="top_banner_bg text-center">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?php if(is_tax('product_cat') || is_category()){ ?>
							<span class="top_banner_title"><?php single_cat_title();?></span>
						<?php }elseif(is_blog()){ ?>
							<span class="top_banner_title"><?php printf( __( 'Our Blog', 'cit')); ?></span>
						<?php }elseif(is_search()){ ?>
							<span class="top_banner_title"><?php printf( __( 'Search Results for: %s', 'cit' ), get_search_query() ); ?></span>
						<?php }elseif(is_404()){ ?>
							<span class="top_banner_title"><?php printf( __( '404 Page Not Found: ', 'cit')); ?></span>
						<?php }else{ 
								if(!empty($banner_title)){
							?>
							<span class="top_banner_title"><?php echo $banner_title; ?></span>
							<?php }else{ ?>
								<span class="top_banner_title"><?php the_title(); ?></span>
							<?php } ?>
						
						<?php } ?>
						<?php if(is_front_page()) : ?>
							<form action="" method="">
								<span class="select-wrapper">
									<select>
										<option value="">From</option>
										<option>sdfsd</option>
										<option>sdfsd</option>
										<option>sdfsd</option>
									</select>
								</span>
								<span class="select-wrapper">
									<select>
										<option value="">To</option>
										<option>sdfsd</option>
										<option>sdfsd</option>
										<option>sdfsd</option>
									</select>
								</span>
								<span class="select-wrapper select_service">
									<select>
										<option value="">Select Service</option>
										<option>sdfsd</option>
										<option>sdfsd</option>
										<option>sdfsd</option>
									</select>
								</span>
								<input type="submit" value="check pricing">
							</form>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php if(is_front_page()) : ?>
				<?php if ( get_theme_mod( 'cit_overall_site_enable_breadcrum', false ) ) : ?>
					<!--.breadcrumb start-->
					<div class="breadcrumb">
						<div class="container">
							<div class="row">
								<div class="breadcrumb-section">
									<?php echo custom_breadcrumbs(); ?>
								</div>
							</div>
						</div>
					</div>
					<!--.breadcrumb end-->
				<?php endif; ?>
			<?php endif; ?>
		</section>
		<!-- Download bar section-->
		<?php if(is_front_page()) : ?>
			<?php if ( get_theme_mod( 'cit_footer_area_contact_widget_area', false ) ) : ?>
				<!-- Download flash-->
			<section class="download_bar text-center">
				<div class="<?php echo esc_attr( citthemestarter_get_header_container_class() ); ?>">
					<div class="row">
						<div class="download_button">
							<?php echo  get_theme_mod( 'cit_footer_area_textarea_widget_area'); ?>
						</div>
					</div>
				</div>
			</section>
			<?php endif; ?>
		<?php endif; ?>

	

