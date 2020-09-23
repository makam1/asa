<?php
/**
 * The template for displaying search results pages.
 *
 * @package Trend
 */

get_header(); 


#Redux global variable
global $trend_redux;

$class = "";

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
                <h2><?php printf( __( 'Search Results for: %s', 'trend' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
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

            <div class="<?php echo esc_attr($class); ?> main-content">

    		<?php if ( have_posts() ) : ?>
                <div class="row">
        			<?php /* Start the Loop */ ?>
        			<?php while ( have_posts() ) : the_post(); ?>

        				<?php
        				/**
        				 * Run the loop for the search to output the results.
        				 * If you want to overload this in a child theme then include a file
        				 * called content-search.php and that will be used instead.
        				 */
        				get_template_part( 'content', get_post_format() );
        				?>

        			<?php endwhile; ?>

                    <div class="trend-pagination pagination">             
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
