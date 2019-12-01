<?php
/**
 * Main template file
 *
 * @package WordPress
 * @subpackage CIT Theme Starterr
 * @since CIT Theme Starterr 1.0
 */

get_header(); ?>
<div class="<?php echo esc_attr( citthemestarter_get_content_container_class() ); ?>">
		<div class="content-wrapper">
			<div class="row">
				<div class="<?php echo esc_attr( citthemestarter_get_maincontent_block_class() ) ?>">
					<div class="pageTitleSection customposttitle clearfix">
						<div class="col-md-6">
							<?php 
								$pageid = get_queried_object_ID();
								$title = get_post($pageid);
								$titlemeta  = get_post_meta( $pageid, 'banner_title', true );
								if(!empty($titlemeta)){
									echo '<h1>'.$titlemeta.'</h1>';
								}else{
									echo '<h1>'.$title->post_title.'</h1>';
								}
							?>
						</div>
						<div class="col-md-6">
							<div class="selectBox">
								<label>
									<span>Browse</span>
									<select id="select_id">
										<option value="">Browse by category</option>
										<?php 
											$terms = get_terms( array(
												'taxonomy' => 'category',
												'hide_empty' => false,
											) );
										if(!empty($terms)){
											foreach($terms as $term){
												$link = get_term_link( $term, 'category');
											?>
											<option data-filter="<?php echo $link; ?>"><?php echo $term->name; ?></option>
											<?php 
											} }
											?>
									</select>
								</label>
							</div>
						</div>
					</div>
					<div class="main-content">
						<div class="archive">
							<?php if ( have_posts() ) :
								// Start the loop.
								while ( have_posts() ) : the_post();
									/*
									 * Include the Post-Format-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
									 */
									get_template_part( 'template-parts/content', get_post_format() );
									// End the loop.
								endwhile;

							?>
								<div class="pagination">
									<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'cit' ); ?></h2>
									<div class="nav-links archive-navigation">
										<?php
										// Previous/next page navigation.
										the_posts_pagination( array(
											'screen_reader_text' => '',
											'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'cit' ) . '</span>',
										) );
										?>
									</div><!--.nav-links archive-navigation-->
								</div><!--.pagination-->
							<?php
							// If no content, include the "No posts found" template.
							else :
								get_template_part( 'template-parts/content', 'none' );

							endif;
							?>

						</div><!--.archive-->
					</div><!--.main-content-->
				</div><!--.<?php echo esc_html( citthemestarter_get_maincontent_block_class() ) ?>-->

				<?php if ( citthemestarter_get_sidebar_class() ) :
					get_sidebar();
				endif; ?>

			</div><!--.row-->
		</div><!--.content-wrapper-->
	</div><!--.<?php echo esc_html( citthemestarter_get_content_container_class() ); ?>-->
<?php get_footer();
