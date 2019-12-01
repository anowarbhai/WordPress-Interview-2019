<?php
/**
 * Comments wrapper
 *
 * @package WordPress
 * @subpackage CIT Theme Starterr
 * @since CIT Theme Starterr 1.0
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<div class="<?php echo esc_attr( citthemestarter_get_content_container_class() ); ?>">
		<div class="row">
			<div class="col-md-12">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php comments_number( esc_html__( 'No Comment', 'cit' ), esc_html__( 'One Comment', 'cit' ), esc_html__( '% Comments', 'cit' ) ) ?>
		</h3>
		<p class="comments-subtitle"><?php echo esc_html__( 'Join the discussion and tell us your opinion.', 'cit' ); ?></p>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php wp_list_comments(
				array(
					'callback'    => 'citthemestarter_comment',
					'reply_text'  => esc_html__( 'Reply', 'cit' ),
					'avatar_size' => 80,
					'style' 	  => 'ol',
				)
			); ?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'cit' ); ?></p>
	<?php endif; ?>

	<?php
	if ( get_comments_number() ) {
		comment_form( array(
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h2>',
			'title_reply' => esc_html__( 'Leave A Comment', 'cit' ),
		) );
	} else {
		comment_form( array(
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h2>',
			'title_reply' => esc_html__( 'Share Your Thoughts', 'cit' ),
		) );
	}

	?>

			</div><!-- .col-md-12 -->
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .comments-area -->
