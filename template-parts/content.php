<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage CIT Theme Starterr
 * @since CIT Theme Starterr 1.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-preview clearfix' ); ?>>
	<div class="col-md-4 col-sm-4">
		<?php citthemestarter_post_thumbnail(); ?>
	</div>

	<div class="col-md-8 col-sm-8">
		<div class="entry-content">

			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			<?php citthemestarter_entry_meta(); ?>
			
			<?php the_excerpt(); ?>

		</div><!--.entry-content-->

		<?php if ( ! is_singular() ) :?>
			<a href="<?php echo esc_url( get_permalink( get_the_ID() ) ) ?>" class="blue-button readMore2"><?php echo esc_html__( 'Read More', 'cit' ) ?></a>
		<?php endif;?>
	</div>
</article><!--.entry-preview-->
