<?php
/**
 * Footer
 *
 * @package WordPress
 * @subpackage CIT Theme Starterr
 * @since CIT Theme Starterr 1.0
 */

if ( citthemestarter_is_the_footer_displayed() ) : ?>
		<?php citthemestarter_hook_before_footer(); ?>
		<?php if(!is_front_page()) : ?>
			<?php if ( get_theme_mod( 'cit_footer_area_contact_widget_area', false ) ) : ?>
				<!-- Download flash-->
			<section class="download-flash text-center">
				<div class="<?php echo esc_attr( citthemestarter_get_header_container_class() ); ?>">
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<?php echo  get_theme_mod( 'cit_footer_area_textarea_widget_area'); ?>
						</div>
					</div>
				</div>
			</section>
			<?php endif; ?>
		<?php endif; ?>
        <!--footer section-->
        <footer class="footer">
            <div class="<?php echo esc_attr( citthemestarter_get_header_container_class() ); ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="footer-top">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="footer-logo">
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
                                <div class="col-md-9">
									<?php if ( get_theme_mod( 'cit_footer_area_widgetized_textarea_columns', false ) ) : ?>
										<p><?php echo get_theme_mod( 'cit_footer_area_widgetized_textarea_columns', '' ); ?></p>
									<?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="footer-bottom">
                            <div class="row">
								<?php
									if ( get_theme_mod( 'cit_footer_area_widget_area', false ) ) :
									$footer_columns = get_theme_mod( 'cit_footer_area_widgetized_columns', 1 );
									$footer_columns_width = 12 / $footer_columns;
								?>
									<div class="col-md-<?php echo esc_attr( $footer_columns_width ); ?>">
										<?php if ( is_active_sidebar( 'footer' ) ) : ?>
											<?php dynamic_sidebar( 'footer' ); ?>
										<?php endif; ?>
									</div>
									<?php for ( $i = 2; $i <= $footer_columns; $i ++ ) : ?>
										<div class="col-md-<?php echo esc_attr( $footer_columns_width ); ?>">
											<?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
												<?php dynamic_sidebar( 'footer-' . $i ); ?>
											<?php endif; ?>
										</div>
									<?php endfor; ?>
								<?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="copyright">
							<p>
								<?php /* translators: 1. date, 2. blog name */
								printf( '&copy; %1$s %2$s All Rights Reserved', esc_html( date( 'Y' ) ), 'Flash Delivery,'  ); ?></p>
                        </div>
						<?php do_action( 'citthemestarter_after_footer_copyright' ); ?>
                    </div>
                </div>
            </div>
        </footer>
	<?php  citthemestarter_hook_after_footer(); ?>

<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
