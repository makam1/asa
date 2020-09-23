<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<?php
$side = "";
$class = "";
if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
    if ( $trend_redux['trend_single_product_layout'] == 'trend_shop_fullwidth' ) {
        $class = "col-md-12";
    }elseif ( $trend_redux['trend_single_product_layout'] == 'trend_shop_right_sidebar' or $trend_redux['trend_single_product_layout'] == 'trend_shop_left_sidebar') {
        $class = "col-md-9";

        if ( $trend_redux['trend_single_product_layout'] == 'trend_shop_right_sidebar' ) {
        	$side = "right";
        }else{
        	$side = "left";
        }
    }
}
?>

<div class="trend-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>
                	<?php echo get_the_title(); ?>
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
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<!-- Page content -->
	<div class="high-padding">
	    <!-- Blog content -->
        <div class="container blog-posts">
           <div class="row">

    	        <?php if ( $side == 'left' ) { ?>
    	        <div class="col-md-3 sidebar-content">
    	            <?php
    					/**
    					 * woocommerce_sidebar hook
    					 *
    					 * @hooked woocommerce_get_sidebar - 10
    					 */
    					do_action( 'woocommerce_sidebar' );
    				?>

    	        </div>
    	        <?php } ?>

                <div class="<?php echo esc_attr($class); ?> main-content">

    			<?php while ( have_posts() ) : the_post(); ?>

    				<?php wc_get_template_part( 'content', 'single-product' ); ?>

    			<?php endwhile; // end of the loop. ?>

    			</div>

    	        <?php if ( $side == 'right' ) { ?>
    	        <div class="col-md-3 sidebar-content">
    	            <?php //dynamic_sidebar( $sidebar ); ?>
    	            <?php
    					/**
    					 * woocommerce_sidebar hook
    					 *
    					 * @hooked woocommerce_get_sidebar - 10
    					 */
    					do_action( 'woocommerce_sidebar' );
    				?>
    	        </div>
    	        <?php } ?>

            </div>
	    </div>
	</div>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

<?php get_footer( 'shop' ); ?>
