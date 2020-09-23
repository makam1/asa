<?php
/**
 * @package Trend
 */
?>
<?php 
global $trend_redux;

$post_icon = "";
$post_icon = $trend_redux['post-text-format-icon']; 

if (get_post_format() == 'image') {
    $post_icon = $trend_redux['post-image-format-icon'];
}elseif (get_post_format() == 'video') {
    $post_icon = $trend_redux['post-video-format-icon'];
}elseif (get_post_format() == 'quote') {
    $post_icon = $trend_redux['post-quote-format-icon'];
}elseif (get_post_format() == 'link') {
    $post_icon = $trend_redux['post-link-format-icon'];
}



$placeholder = '700x450';
$master_class = 'col-md-12';
$thumbnail_class = 'col-md-4';
$post_details_class = 'col-md-8';
$type_class = 'list-view';
$image_size = 'trend_post_pic700x450';

if ( $trend_redux['blog-display-type'] == 'list' ) {

    $master_class = 'col-md-12';
    $thumbnail_class = 'col-md-4';
    if(wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' )) {
        $post_details_class = 'col-md-8';
    }else{
        $post_details_class = 'col-md-12';
    }
    $type_class = 'list-view';
    $image_size = 'trend_post_pic700x450';

} else {

    $type_class = 'grid-view';
    if ( $trend_redux['blog-grid-columns'] == 1 ) {
        $master_class = 'col-md-12';
        $type_class .= ' grid-one-column';
        $image_size = 'trend_portfolio_pic900x500';
        $placeholder = '900x500';
    }elseif ( $trend_redux['blog-grid-columns'] == 2 ) {
        $master_class = 'col-md-6';
        $type_class .= ' grid-two-columns';
        $image_size = 'trend_portfolio_pic900x500';
        $placeholder = '900x500';
    }elseif ( $trend_redux['blog-grid-columns'] == 3 ) {
        $master_class = 'col-md-4';
        $type_class .= ' grid-three-columns';
        $image_size = 'trend_post_pic700x450';
        $placeholder = '700x450';
    }elseif ( $trend_redux['blog-grid-columns'] == 4 ) {
        $master_class = 'col-md-3';
        $type_class .= ' grid-four-columns';
        $image_size = 'trend_post_pic700x450';
        $placeholder = '700x450';
    }

    $thumbnail_class = 'full-width-part';
    $post_details_class = 'full-width-part';

} 
$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $image_size );
$post_type_icon = $trend_redux['trend-enable-posttype-icon']; 
?>

<?php if ( ! class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('single-post grid-view col-md-12 list-view '); ?>>    
    

    <?php if($thumbnail_src) { ?>
    <div class="<?php echo esc_attr($thumbnail_class); ?> post-thumbnail">
        <a href="<?php esc_url(the_permalink()); ?>" class="relative">
            <?php if($thumbnail_src) { 
                echo '<img src="'. esc_url($thumbnail_src[0]) . '" alt="'.esc_attr(get_the_title()).'" />';
            } ?>
            <div class="thumbnail-overlay absolute">
                <i class="fa fa-plus absolute"></i>
            </div>
        </a>
    </div>
    <?php } ?>

    <div class="<?php echo esc_attr($post_details_class); ?> post-details">
        <h3 class="post-name row">
            <a title="<?php the_title_attribute() ?>" href="<?php esc_url(the_permalink()); ?>">
                <?php if ($post_type_icon == 1) { ?>
                    <span class="post-type">
                        <i class="fa <?php echo esc_attr($post_icon); ?>"></i>
                    </span>
                <?php } ?>
                <?php the_title() ?>
            </a>
        </h3>
        
        <div class="post-category-comment-date row">
            <span class="post-author"><?php echo esc_attr__('by ', 'trend') . get_the_author(); ?></span>   /   
            <span class="post-tags">
                <?php if (get_the_category()) { ?>
                    <?php foreach((get_the_category()) as $category) {
                        $category_link = get_term_link( $category );
                        echo "<a href='". esc_url( $category_link ) ."'>" . wp_kses_post($category->cat_name) . "</a> / "; 
                    } ?>
                <?php } ?>
            </span>
            <span class="post-comments"><a href="<?php esc_url(the_permalink()); ?>"><?php comments_number( 'No Comments', '1 Comment', '% Comments' ); ?></a></span>   /   
            <span class="post-date"><?php echo get_the_date(); ?></span>
        </div>
        <div class="post-excerpt row">
        <?php
            /* translators: %s: Name of current post */
            the_excerpt();
        ?>
        <?php
            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_attr__( 'Pages:', 'trend' ),
                'after'  => '</div>',
            ) );
        ?>
        </div>
    </div>
</article>
<?php }else{ ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('single-post grid-view '.esc_attr($master_class).' '.esc_attr($type_class)); ?>>    
    
    <?php if($thumbnail_src) { ?>
    <div class="<?php echo esc_attr($thumbnail_class); ?> post-thumbnail">
        <a href="<?php esc_url(the_permalink()); ?>" class="relative">
            <?php 
            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $image_size );
            if($thumbnail_src) { 
                echo '<img src="'. esc_url(wp_kses_post($thumbnail_src[0])) . '" alt="'.esc_attr(get_the_title()).'" />';
            } ?>
            <div class="thumbnail-overlay absolute">
                <i class="fa fa-plus absolute"></i>
            </div>
        </a>
    </div>
    <?php } ?>

    <div class="<?php echo esc_attr($post_details_class); ?> post-details">
        <h3 class="post-name row">
            <a title="<?php the_title_attribute() ?>" href="<?php esc_url(the_permalink()); ?>">
                <?php if ($post_type_icon == 1) { ?>
                    <span class="post-type">
                        <i class="fa <?php echo esc_attr($post_icon); ?>"></i>
                    </span>
                <?php } ?>
                <?php the_title() ?>
            </a>
        </h3>
        
        <div class="post-category-comment-date row">
            <span class="post-author"><?php echo esc_attr__('by ', 'trend') . get_the_author(); ?></span>   /   
            <span class="post-tags">
                <?php if (get_the_category()) { ?>
                    <?php foreach((get_the_category()) as $category) {
                        $category_link = get_term_link( $category );
                        echo "<a href='". esc_url( $category_link ) ."'>" . wp_kses_post($category->cat_name) . "</a> / "; 
                    } ?>
                <?php } ?>
            </span>
            <span class="post-comments"><a href="<?php esc_url(the_permalink()); ?>"><?php comments_number( 'No Comments', '1 Comment', '% Comments' ); ?></a></span>   /   
            <span class="post-date"><?php echo get_the_date(); ?></span>
        </div>
        <div class="post-excerpt row">
        <?php
            /* translators: %s: Name of current post */
            the_excerpt();
        ?>
        <?php
            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_attr__( 'Pages:', 'trend' ),
                'after'  => '</div>',
            ) );
        ?>
        </div>
    </div>
</article>
<?php } ?>