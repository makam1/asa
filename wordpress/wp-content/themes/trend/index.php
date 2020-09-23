<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.WordPress.org/Template_Hierarchy
 *
 * @package Trend
 */

get_header(); 


#Redux global variable
global $trend_redux;

$class = "";
$sidebar = "sidebar-1";

if ( $trend_redux['trend_blog_layout'] == 'trend_blog_fullwidth' ) {
    $class = "row";
}elseif ( $trend_redux['trend_blog_layout'] == 'trend_blog_right_sidebar' or $trend_redux['trend_blog_layout'] == 'trend_blog_left_sidebar') {
    $class = "col-md-9";
}
$sidebar = $trend_redux['trend_blog_layout_sidebar'];

?>

	<!-- Breadcrumbs -->
	<div class="trend-breadcrumbs">
	    <div class="container">
	        <div class="row">
	            <div class="col-md-8">
	                <h2>
	                    <?php echo esc_html__('Blog','trend'); ?>
	                </h2>
	            </div>
                <div class="col-md-4">
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

                <?php if ( ! class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
                    <div class="col-md-9 main-content">
                <?php }else{ ?>
                    <div class="<?php echo esc_attr($class); ?> main-content">
                <?php } ?>
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

                <?php if (! class_exists( 'ReduxFrameworkPlugin' ) && is_active_sidebar( $sidebar )){ ?>
                    <div class="col-md-3 sidebar-content">
                        <?php  dynamic_sidebar( 'sidebar' ); ?>
                    </div>
                <?php }else{ ?>
                    <?php if ( $trend_redux['trend_blog_layout'] == 'trend_blog_right_sidebar' && is_active_sidebar( $sidebar )) { ?>
                    <div class="col-md-3 sidebar-content">
                        <?php  dynamic_sidebar( $sidebar ); ?>
                    </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>