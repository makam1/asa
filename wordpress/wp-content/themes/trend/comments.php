<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Trend
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

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'trend' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'trend' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'trend' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<div class="comment-list comments-area trend_comments comments">
			<h2 class="heading-bottom">
				<?php
					printf( _nx( 'One comment', '%1$s comments', get_comments_number(), 'comments title', 'trend' ),
						number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
				?>
			</h2>
			<?php wp_list_comments( 'type=comment&callback=trend_custom_comments' ); ?>
		</div><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'trend' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'trend' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'trend' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'trend' ); ?></p>
	<?php endif; ?>

	<?php 
		$args = array(
			'id_form'           => 'commentform',
			'id_submit'         => 'submit',
			'title_reply'       => __( 'Leave a <span>comment</span>', 'trend' ),
			'title_reply_to'    => __( 'Leave a <span>reply to %s</span>', 'trend' ),
			'cancel_reply_link' => __( 'Cancel <span>reply</span>', 'trend' ),
			'label_submit'      => __( 'Post comment', 'trend' ),

			'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . __( 'Comment', 'trend' ) .
				'</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
				'</textarea></p>',

			'must_log_in' => '<p class="must-log-in">' .
				sprintf(
					__( 'You must be <a href="%s">logged in</a> to post a comment.', 'trend' ),
					wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
				) . '</p>',

			'logged_in_as' => '<p class="logged-in-as">' .
				sprintf(
				__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','trend' ),
					admin_url( 'profile.php' ),
					$user_identity,
					wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
				) . '</p>',

			'comment_notes_before' => 
			'<p class="comment-notes">' . __( '', 'trend' ) . '</p>',

		    'comment_field' =>
		    	'<div class="col-md-6 form-comment">' .
		    	'<p class="comment-form-author relative">' .
		    	'<textarea cols="45" rows="5" aria-required="true" placeholder="' . __( 'Your comment', 'trend' ) . '" name="comment" id="comment"></textarea></div>',

			'fields' => apply_filters( 'comment_form_default_fields', array(
			    'author' =>
			    	'<div class="col-md-6 form-fields">' .
			    	'<p class="comment-form-author relative">' .
			    	'<input class="focus-me" placeholder="' . __( 'Your name', 'trend' ) . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
			    	'" size="30" /><i class="fa fa-user absolute"></i></p>',
			    'email' =>
			    	'<p class="comment-form-author relative">' .
			    	'<input class="focus-me" placeholder="' . __( 'Your email', 'trend' ) . '" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
			    	'" size="30" /><i class="fa fa-envelope absolute"></i></p>',
			    'url' =>
			    	'<p class="comment-form-author relative">' .
			    	'<input class="focus-me" placeholder="' . __( 'Your website', 'trend' ) . '" id="url" name="url" type="text" value="' . esc_attr(  $commenter['comment_author_url'] ) .
			    	'" size="30" /><i class="fa fa-comments absolute"></i></p></div>'
			)
		  ),
		);
		 
		comment_form($args);
	?>

</div>