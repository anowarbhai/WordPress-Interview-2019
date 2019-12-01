<?php
/**
 * Page template
 *
 * @package WordPress
 * @subpackage CIT Theme Starterr
 * @since CIT Theme Starterr 1.0
 * 
 * Template name: Services
 */

get_header(); ?>
	
	<section class="TabsPanel">
		<ul class="nav nav-pills">
			<?php 
				$args = array(
					'post_type'    		=> 'services',
					'posts_per_page'    => 3,
					'orderby'           => 'DESC',
					'order'             => 'date'
					
				);
				$posts = new WP_Query($args);
				$i = 1;
				while($posts->have_posts()) : $posts->the_post();
					if($i == 1):
						$active = 'active';
					else:
						$active = '';
					endif;
				?>
				<li class="<?php echo $active; ?>"><a data-toggle="pill" href="#tab<?php echo get_the_ID(); ?>"><?php echo the_title(); ?></a></li>
			<?php $i++; endwhile; ?>
		</ul>
	<div class="<?php echo esc_attr( citthemestarter_get_content_container_class() ); ?>">
			<div class="row">
				<div class="<?php echo esc_attr( citthemestarter_get_maincontent_block_class() ); ?>">
					<div class="main-content">
							<div class="tab-content clearfix">
								<?php 
									$j = 1;
									while($posts->have_posts()) : $posts->the_post();
									$thumbnails = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full');		
									if($j == 1):
										$fade = 'in active';
									else:
										$fade = '';
									endif;
								?>
									<div id="tab<?php echo get_the_ID(); ?>" class="tab-pane fade <?php echo $fade; ?> text-center">
										<div class="tabitem">
											<h6><?php the_title(); ?></h6>
											<?php the_content() ?>
										</div>
										</br>
										<img class="img-responsive" src="<?php echo $thumbnails[0]; ?>">
									</div>
								<?php $j++; endwhile; wp_reset_postdata(); ?>
							</div>
							<?php
							
									get_template_part( 'template-parts/content', 'page' );
							?>
					</div><!--.main-content-->
				</div><!--.esc_html( citthemestarter_get_maincontent_block_class() )-->

				<?php if ( citthemestarter_get_sidebar_class() ) : ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>

			</div><!--.row-->
	</div><!--.<?php echo esc_html( citthemestarter_get_content_container_class() ); ?>-->
		</section><!--.content-wrapper-->
<?php get_footer(); ?>