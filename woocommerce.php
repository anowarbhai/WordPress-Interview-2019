<?php
/**
 * Page template
 *
 * @package WordPress
 * @subpackage CIT Theme Starterr
 * @since CIT Theme Starterr 1.0
 */

get_header(); ?>
	<div class="<?php echo esc_attr( citthemestarter_get_content_container_class() ); ?>">
		<div class="content-wrapper">
			<div class="row">
				<div class="col-md-12">
					<div class="pageTitleSection customposttitle clearfix">
						<h1>Shop</h1>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
					</div>
				</div>
				<div class="<?php echo esc_attr( citthemestarter_get_maincontent_block_class() ); ?>">
					<div class="main-content">
						<?php woocommerce_content(); ?>
					</div><!--.main-content-->
				</div><!--.<?php echo esc_html( citthemestarter_get_maincontent_block_class() ); ?>-->

				<?php if ( citthemestarter_get_sidebar_class() ) : ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>

			</div><!--.row-->
		</div><!--.content-wrapper-->
	</div><!--.<?php echo esc_html( citthemestarter_get_content_container_class() ); ?>-->
<?php get_footer();
