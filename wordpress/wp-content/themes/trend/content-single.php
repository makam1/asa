<?php
/**
 * @package Trend
 */

#Redux global variable
global $trend_redux;


$class = "col-md-12";

// BEGIN_WP5
$select_post_layout = get_post_meta( get_the_ID(), 'select_post_layout', true );
$select_post_sidebar = get_post_meta( get_the_ID(), 'select_post_sidebar', true );
$sidebar = 'sidebar-1';
if ( function_exists('modeltheme_framework')) {
    if (isset($select_post_sidebar) && $select_post_sidebar != '') {
        $sidebar = $select_post_sidebar;
    }else{
        $sidebar = $trend_redux['trend_blog_layout_sidebar'];
    }
}
$class = 'col-md-12 col-sm-12';
$sidebars_lr_meta = array("left-sidebar", "right-sidebar");
if (isset($select_post_layout) && in_array($select_post_layout, $sidebars_lr_meta)) {
    $class = 'col-md-9 col-sm-9 status-meta-sidebar';
}elseif(isset($select_post_layout) && $select_post_layout == 'no-sidebar'){
    $class = 'col-md-12 col-sm-12 status-meta-fullwidth';
}else{
    if(class_exists( 'ReduxFrameworkPlugin' )){
        $sidebars_lr_panel = array("trend_blog_left_sidebar", "trend_blog_right_sidebar");
        if (in_array($trend_redux['trend_single_blog_layout'], $sidebars_lr_panel)) {
            $class = 'col-md-9 col-sm-9 status-panel-sidebar';
        }else{
            $class = 'col-md-12 col-sm-12 status-panel-no-sidebar';
        }
    }
}
if (!is_active_sidebar($sidebar)) {
    $class = "col-md-12";
}
// END_WP5


$prev_post = get_previous_post();
$next_post = get_next_post();
$author_placeholder = 'http://placehold.it/128x128';
?>

<div class="trend-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h2><?php echo esc_html__('Blog','trend'); ?></h2>
            </div>
            <div class="col-md-4">
                <ol class="breadcrumb pull-right">
                    <?php trend_breadcrumb(); ?>
                </ol>
            </div>
        </div>
    </div>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class('post high-padding'); ?>>
    <div class="container">
       <div class="row">

            <?php // BEGIN_WP5 ?>
            <?php if (isset($select_post_layout) && $select_post_layout == 'left-sidebar') { ?>
                <div class="col-md-3 col-sm-3 sidebar-content sidebar-left">
                    <?php if (is_active_sidebar($sidebar)) { ?>
                        <?php dynamic_sidebar($sidebar); ?>
                    <?php } ?>
                </div>
            <?php }else{ ?>
                <?php if (isset($select_post_layout) && $select_post_layout == 'inherit') { ?>
                    <?php if(class_exists( 'ReduxFrameworkPlugin' )){ ?>
                        <?php if ( $trend_redux['trend_single_blog_layout'] == 'trend_blog_left_sidebar') { ?>
                            <div class="col-md-3 col-sm-3 sidebar-content sidebar-left">
                                <?php if (is_active_sidebar($sidebar)) { ?>
                                    <?php dynamic_sidebar($sidebar); ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <?php // END_WP5 ?>

            <div class="<?php echo esc_attr($class); ?> main-content">
                <div class="article-header">
                    <?php $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'trend_single_post_pic900x300' ); 
                    if($thumbnail_src) { ?>
                        <?php the_post_thumbnail( 'trend_single_post_pic900x300' ); ?>
                    <?php } ?>
                    <div class="clearfix"></div>
                    <div class="article-details">
                        <h3 class="post-name"><?php echo get_the_title(); ?></h3>
                        <div class="post-author">by <?php echo get_the_author(); ?> | <?php echo get_the_date(); ?></div>
                        <div class="article-tags-comments">
                            <div class="col-md-2 article-comments">
                                <?php comments_number( 'No Comments', '1 Comment', '% Comments' ); ?>
                            </div>

                            <?php if (get_the_tags()) { ?>
                            <div class="col-md-10 article-tags">
                                <i class="fa fa-tag"></i>
                                <?php foreach( ( get_the_tags() ) as $tag) {
                                    $tag_link = get_term_link( $tag );
                                    echo "<a class='single_tax' href='".esc_url( $tag_link )."'>".esc_html($tag->name)."</a> "; 
                                } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="article-content">
                    <?php the_content(); ?>
                    <?php
                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . __( 'Pages:', 'trend' ),
                            'after'  => '</div>',
                        ) );
                    ?>
                </div>

                <div class="article-footer">
                    <?php if (get_the_category()) { ?>
                    <div class="article-categories">
                        <h3><i class="fa fa-pencil"></i>Categories:</h3>
                        <div class="categories">
                        <?php foreach((get_the_category()) as $category) {
                            $category_link = get_term_link( $category );
                            echo "<a class='single_tax' href='".esc_url( $category_link )."'>".esc_html($category->cat_name)."</a> "; 
                        } ?>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="article-social">
                        <h3>Share post:</h3>
                        <ul class="social-sharer">
                            <li class="rotate45">
                                <a href="http://www.facebook.com/share.php?u=<?php echo esc_url(get_permalink()); ?>&amp;title=<?php the_title_attribute(); ?>"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li class="rotate45">
                                <a href="http://twitter.com/home?status=<?php echo get_the_title(); ?>+<?php echo get_permalink(); ?>"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li class="rotate45">
                                <a href="https://plus.google.com/share?url=<?php echo esc_url(get_permalink()); ?>"><i class="fa fa-google-plus"></i></a>
                            </li>
                            <li class="rotate45">
                                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url(get_permalink()); ?>&amp;title=<?php the_title_attribute(); ?>&amp;source=<?php echo get_permalink(); ?>"><i class="fa fa-linkedin"></i></a>
                            </li>
                            <li class="rotate45">
                                <a href="http://www.reddit.com/submit?url=<?php echo esc_url(get_permalink()); ?>&amp;title=<?php the_title_attribute(); ?>"><i class="fa fa-reddit"></i></a>
                            </li>
                            <li class="rotate45">
                                <a href="http://www.tumblr.com/share?v=3&amp;u=<?php echo esc_url(get_permalink()); ?>&amp;t=<?php echo get_the_title(); ?>"><i class="fa fa-tumblr"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <?php if ( $trend_redux['trend-enable-authorbio'] ) { ?>

                <?php   
                    $avatar = get_avatar( get_the_author_meta('email'), '80', get_the_author() );
                    $has_image = '';
                    if( $avatar !== false ) {
                        $has_image .= 'no-author-pic';
                    }
                ?>
                
                <div class="author-bio relative <?php echo esc_attr($has_image); ?>">
                    <?php
                        if( $avatar !== false ) {
                            echo  '<div class="author-thumbnail col-md-2">'; 
                                echo  wp_kses_post($avatar); 
                            echo  '</div>'; 
                        }
                    ?>                    
                    <div class="author-thumbnail col-md-10">
                        <div class="author-name"><?php echo get_the_author(); ?></div>
                        <div class="author-biography"><?php the_author_meta('description'); ?></div>
                    </div>
                </div>

                <?php } ?>

                <?php if ( $trend_redux['trend-enable-related-posts'] ) { ?>
 
                <div class="related-posts sticky-posts">
                    <?php
                    $orig_post = $post;  
                    global $post;  
                    $tags = wp_get_post_tags($post->ID);  
                    ?>

                    <?php  
                    if ($tags) { ?>
                    <h2 class="heading-bottom"><?php esc_attr_e('Related Posts', 'trend'); ?></h2>
                        <div class="row">
                        <?php $tag_ids = array();  
                        foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;  
                        $args=array(  
                            'tag__in'               => $tag_ids,  
                            'post__not_in'          => array($post->ID),  
                            'posts_per_page'        => 3, // Number of related posts to display.  
                            'ignore_sticky_posts'   => 1  
                        );  

                        $my_query = new wp_query( $args );  

                        while( $my_query->have_posts() ) {  
                            $my_query->the_post();  
                        ?>  
                            <div class="col-md-4 post">
                                <a href="<?php esc_url(the_permalink()); ?>" class="relative">
                                    <?php $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'trend_related_post_pic500x300' ); 
                                    if($thumbnail_src) { ?>
                                        <img src="<?php echo esc_url($thumbnail_src[0]); ?>" class="img-responsive" alt="<?php the_title(); ?>" />
                                    <?php }else{ ?>
                                        <img src="<?php echo esc_url('http://placehold.it/500x300'); ?>" class="img-responsive" alt="<?php the_title(); ?>" />
                                    <?php } ?>
                                    <div class="post-date absolute rotate45">
                                        <span class="rotate45_back"><?php echo get_the_date('j M'); ?></span>
                                    </div>
                                    <div class="thumbnail-overlay absolute">
                                        <i class="fa fa-plus absolute"></i>
                                    </div>
                                </a>
                                <h3 class="post-name"><?php the_title(); ?></h3>
                                <div class="post-author">by <?php echo get_the_author(); ?></div>
                                <div class="post-excerpt">
                                    <?php
                                        $excerpt = get_post_field('post_content', $post->ID);
                                        echo wp_kses_post( trend_excerpt_limit($excerpt,5) );
                                    ?>
                                </div>
                            </div>

                        <?php 
                        } ?>
                    </div>
                    <?php } ?>
                </div>
                    <?php 
                    $post = $orig_post;  
                    wp_reset_postdata();  
                    ?>  

                <?php } ?>

                <?php
                    // If comments are open or we have at least one comment, load up the comment template
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                ?>


                <div class="clearfix"></div>

                <?php if ( $trend_redux['trend-enable-post-navigation'] ) { ?>

                <div class="prev-next-post">
                    <?php if($prev_post){ ?>
                    <div class="col-md-6 prev-post">
                        <a href="<?php echo esc_url(get_permalink( $prev_post->ID )); ?>">
                            <div class="pull-left rotate45">                            
                                <i class="fa fa-angle-left"></i>                            
                            </div>
                            <div class="pull-left prev-text"><?php echo esc_attr__('Previous Post','trend'); ?></div>
                        </a>
                    </div>
                    <?php } ?>
                    <?php if($next_post){ ?>
                    <div class="col-md-6 next-post">
                        <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>">
                            <div class="pull-right rotate45">                            
                                <i class="fa fa-angle-right"></i>                            
                            </div>
                            <div class="pull-right next-text"><?php echo esc_attr__('Next Post','trend'); ?></div>
                        </a>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>

            <?php // BEGIN_WP5 ?>
            <?php if(class_exists( 'ReduxFrameworkPlugin' )){ ?>
                <?php if (isset($select_post_layout) && $select_post_layout == 'right-sidebar') { ?>
                    <div class="col-md-3 sidebar-content sidebar-right">
                        <?php if (is_active_sidebar($sidebar)) { ?>
                            <?php dynamic_sidebar($sidebar); ?>
                        <?php } ?>
                    </div>
                <?php }elseif(isset($select_post_layout) && $select_post_layout == 'inherit') { ?>
                    <?php if ( $trend_redux['trend_single_blog_layout'] == 'trend_blog_right_sidebar') { ?>
                        <div class="col-md-3 sidebar-content sidebar-right">
                            <?php if (is_active_sidebar($sidebar)) { ?>
                                <?php dynamic_sidebar($sidebar); ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <?php // END_WP5 ?>
        </div>
    </div>
</article>