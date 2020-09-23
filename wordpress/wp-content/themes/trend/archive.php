<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.WordPress.org/Template_Hierarchy
 *
 * @package Trend
 */

get_header(); 


#Redux global variable
global $trend_redux;

$class = "";
$sidebar = "sidebar-1";

if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
    if ( $trend_redux['trend_blog_layout'] == 'trend_blog_fullwidth' ) {
        $class = "row";
    }elseif ( $trend_redux['trend_blog_layout'] == 'trend_blog_right_sidebar' or $trend_redux['trend_blog_layout'] == 'trend_blog_left_sidebar') {
        $class = "col-md-9";
    }
    $sidebar = $trend_redux['trend_blog_layout_sidebar'];
}
?>

    <!-- Breadcrumbs -->
    <div class="trend-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>
                        <?php the_archive_title(); ?>
                        <span><?php the_archive_description(); ?></span>
                    </h2>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb pull-right">
                        <?php trend_breadcrumb(); ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="high-padding">
        <!-- Blog content -->
        <div class="container blog-posts">
            <div class="row">

            <?php if ( $trend_redux['trend_blog_layout'] == 'trend_blog_left_sidebar' && is_active_sidebar( $sidebar )) { ?>
            <div class="col-md-3 sidebar-content">
                <?php  dynamic_sidebar( $sidebar ); ?>
            </div>
            <?php } ?>

                <div class="<?php echo esc_attr($class); ?> main-content">
                <?php if ( have_posts() ) : ?>
                    <div class="row">
                        <?php /* Start the Loop */ ?>
                        <?php while ( have_posts() ) : the_post(); ?>

                            <?php
                                /* Include the Post-Format-specific template for the content.
                                 * If you want to override this in a child theme, then include a file
                                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                 */
                                get_template_part( 'content', get_post_format() );
                            ?>

                        <?php endwhile; ?>

                        <div class="trend-pagination pagination col-md-12">             
                            <?php trend_pagination(); ?>
                        </div>
                    </div>

                <?php else : ?>

                    <?php get_template_part( 'content', 'none' ); ?>

                <?php endif; ?>
                </div>

                <?php if ( $trend_redux['trend_blog_layout'] == 'trend_blog_right_sidebar' && is_active_sidebar( $sidebar )) { ?>
                <div class="col-md-3 sidebar-content">
                    <?php  dynamic_sidebar( $sidebar ); ?>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>

    <?php get_footer(); ?>