<?php
/**
 * Page template
 *
 * @package WordPress
 * @subpackage CIT Theme Starterr
 * @since CIT Theme Starterr 1.0
 * Template name: Works
 */

get_header(); ?>
	<div class="slideshow">
		<div class="<?php echo esc_attr( citthemestarter_get_content_container_class() ); ?>">
			<div class="content-wrapper">
				<div class="row">
					<div class="<?php echo esc_attr( citthemestarter_get_maincontent_block_class() ); ?>">
						<div class="main-content">
							<?php
							// Start the loop.
							while ( have_posts() ) : the_post();
								get_template_part( 'template-parts/content', 'page' );
							endwhile; // End the loop.
							?>
						</div><!--.main-content-->
						<section id="dg-container" class="dg-container">
							<div class="dg-wrapper">
							<?php 
								$args = array(
									'post_type'    		=> 'words',
									'posts_per_page'    => 100,
									'orderby'           => 'DESC',
									'order'             => 'date'
									
								);
								$posts = new WP_Query($args);
								while($posts->have_posts()) : $posts->the_post();
									$thumbnails = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full');	
									$site_url = get_field('site_url');
							?>
								<a target="_blank" href="<?php echo $site_url; ?>"><img src="<?php echo $thumbnails[0]; ?>" alt="<?php the_title(); ?>">
									<div><?php the_title(); ?></div>
								</a>
							<?php endwhile; ?>
							</div>
							<nav>
								<span class="dg-prev"><i class="fa fa-angle-left fa-2x"></i></span>
								<span class="dg-next"><i class="fa fa-angle-right fa-2x"></i></span>
							</nav>
							<div class="pointer">
								<?php 
								$args = array(
									'post_type'    		=> 'words',
									'posts_per_page'    => 100,
									'orderby'           => 'DESC',
									'order'             => 'date'
									
								);
								$posts = new WP_Query($args);
								$i = 1;
								while($posts->have_posts()) : $posts->the_post();
									$site_url = get_field('site_url');
							?>
									<a class="" href="<?php echo $site_url; ?>"><?php echo $i; ?></a>
								<?php $i++; endwhile; wp_reset_postdata(); ?>
							</div>
						</section>
					</div><!--.<?php echo esc_html( citthemestarter_get_maincontent_block_class() ); ?>-->

					<?php if ( citthemestarter_get_sidebar_class() ) : ?>
						<?php get_sidebar(); ?>
					<?php endif; ?>

				</div><!--.row-->
			</div><!--.content-wrapper-->
		</div><!--.<?php echo esc_html( citthemestarter_get_content_container_class() ); ?>-->
	</div>
<?php get_footer();
