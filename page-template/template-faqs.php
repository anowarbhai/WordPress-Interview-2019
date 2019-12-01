<?php
/**
 * Page template
 *
 * @package WordPress
 * @subpackage CIT Theme Starterr
 * @since CIT Theme Starterr 1.0
 * 
 * Template name: Faq's
 */

get_header(); ?>
	
	<section class="TabsPanel faq">
		<ul class="nav nav-pills">
			<?php 
				$i = 1;
				$topics = get_terms( array(
					'hide_empty' => 0,
					'taxonomy' => 'faq_cat',
					'orderby' => 'id',
				));     
			 
				foreach($topics as $topic){ 
					if($i == 1):
						$active = 'active';
					else:
						$active = '';
					endif;
				?>
				<li class="<?php echo $active; ?>"><a data-toggle="pill" href="#<?php echo $topic->slug; ?>"><?php echo $topic->name; ?></a></li>
			<?php
			 $i++;	}
			?>
		</ul>
	<div class="<?php echo esc_attr( citthemestarter_get_content_container_class() ); ?>">
			<div class="row">
				<div class="<?php echo esc_attr( citthemestarter_get_maincontent_block_class() ); ?>">
					<div class="main-content">
						<div class="tab-content faq-tab">
							<?php
							$custom_terms = get_terms('faq_cat');
							$j = 1;
							
							foreach($custom_terms as $custom_term) {
								wp_reset_query();
								$args = array(
									'post_type' => 'faq',
									'posts_per_page'   => 10,
									'tax_query' => array(
										array(
											'taxonomy' => 'faq_cat',
											'field' => 'slug',
											'terms' => $custom_term->slug,
										),
									),
								 );
								 if($j == 1):
								$fade = 'in active';
								else:
									$fade = '';
								endif;
							?>
								<div id="<?php echo $custom_term->slug; ?>" class="tab-pane fade <?php echo $fade; ?>">
									<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
										<?php
										$loop_cat = new WP_Query($args);
											if($loop_cat->have_posts()) {
											while($loop_cat->have_posts()) : $loop_cat->the_post();
										?>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="headingOne">
												<h4 class="panel-title">
													<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo get_the_ID(); ?>" aria-expanded="true" aria-controls="collapse<?php echo get_the_ID(); ?>">
														<i class="more-less  fa fa-plus" aria-hidden="true"></i>
														<?php the_title(); ?>
													</a>
												</h4>
											</div>
											<div id="collapse<?php echo get_the_ID(); ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
												<div class="panel-body">
													Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
												</div>
											</div>
										</div>
											<?php endwhile;  wp_reset_postdata();  } ?>
									</div>
								</div>
							<?php $j++; } ?>
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