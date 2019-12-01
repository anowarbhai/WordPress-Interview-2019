<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage CIT Theme Starterr
 * @since CIT Theme Starterr 1.0
 */

?>
<?php if ( citthemestarter_is_the_title_displayed() && get_the_title() ) : ?>
<h1 class="entry-title"><?php the_title(); ?></h1>
<?php endif; ?>
<div class="entry-content">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php the_content( '', true ); ?>
		<?php
			wp_link_pages(
				array(
					'before' => '<div class="nav-links post-inner-navigation">',
					'after' => '</div>',
					'link_before' => '<span>',
					'link_after' => '</span>',
				)
			);
		?>
	</article>
	<?php citthemestarter_entry_tags(); ?>
</div><!--.entry-content-->
