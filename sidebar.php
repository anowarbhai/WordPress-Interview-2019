<?php
/**
 * Sidebar.
 *
 * @package WordPress
 * @subpackage CIT Theme Starterr
 * @since CIT Theme Starterr 1.0
 */

?>
<div class="<?php echo esc_attr( citthemestarter_get_sidebar_class() ); ?>">
	<div class="sidebar-widget-area">
<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar' ); ?>
<?php endif; ?>
	</div>
</div>
