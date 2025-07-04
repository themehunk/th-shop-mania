<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ThemeHunk
 * @subpackage Th Shop Mania
 * @since 1.0.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<article id="comments" class="comments-area">
	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				$comment_count = get_comments_number();
				if ( 1 === $comment_count ) {
				    printf(
				        /* translators: %s: Post title */
				        esc_html__( 'One thought on &ldquo;%s&rdquo;', 'th-shop-mania' ),
				        '<span>' . esc_html( get_the_title() ) . '</span>'
				    );

				} else {
				    printf( 
				        /* translators: 1: comment count number, 2: post title. */
				        esc_html__( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', 1, 'comments title', 'th-shop-mania' ) ),
				        esc_html( number_format_i18n( (int)$comment_count ) ), // Escaped output
				        '<span>' . esc_html( get_the_title() ) . '</span>'
				    );
				}
			?>

		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'th-shop-mania' ); ?></p>
		<?php
		endif;

	endif; // Check for have_comments().

	comment_form();
	?>
</article><!-- #comments -->