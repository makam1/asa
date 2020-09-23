<?php 

# Custom Comments

function trend_custom_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'div';
        $add_below = 'div-comment';
    }
?>
    <<?php echo esc_attr($tag) ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body fullwidth single_comment parent">
        <?php endif; ?>
            <div class="comment-author vcard comment_author col-md-2">
                <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, 130 ); ?>
            </div>
        <?php if ( $comment->comment_approved == '0' ) : ?>
            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.','trend' ); ?></em>
        <?php endif; ?>

        <div class="comment-meta commentmetadata col-md-10 comment_body relative">
            <div class="row">
                <?php printf( __( '<div class="author_name col-md-5">%s</div>', 'trend' ), get_comment_author_link() ); ?>
                <span class="reply_button col-md-7 text-right">
                    <?php printf( __('%1$s at %2$s / ', 'trend'), get_comment_date(),  get_comment_time() ); ?><?php edit_comment_link( __( 'Edit', 'trend' ), '  ', '' ); ?>
                <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </span>
            </div>
            <p><?php comment_text(); ?></p>
        </div>
    </div>

    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php } ?>