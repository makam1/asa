<?php
/**
 * Add to wishlist template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.0
 */

global $product;
?>

<div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo esc_attr($product_id); ?>">
    <div class="yith-wcwl-add-button <?php echo ( esc_attr($exists) && ! $available_multi_wishlist ) ? 'hide': 'show' ?>" style="display:<?php echo ( esc_attr($exists) && ! esc_attr($available_multi_wishlist) ) ? 'none': 'block' ?>">

        <?php yith_wcwl_get_template( 'add-to-wishlist-' . esc_attr($template_part) . '.php', wp_kses_post($atts) ); ?>

    </div>

    <div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
        <span class="feedback"><?php _e( 'Added!','trend' ) ?></span>
        <a href="<?php echo esc_url( $wishlist_url )?>" >
            <?php echo apply_filters( 'yith-wcwl-browse-wishlist-label', __( 'Browse Wishlist', 'trend' ) )?>
        </a>
    </div>

    <div class="yith-wcwl-wishlistexistsbrowse <?php echo ( esc_attr($exists) && ! $available_multi_wishlist ) ? 'show' : 'hide' ?>" style="display:<?php echo ( esc_attr($exists) && ! esc_attr($available_multi_wishlist) ) ? 'block' : 'none' ?>">
        <a href="<?php echo esc_url( $wishlist_url ) ?>" class="button">
            <?php echo apply_filters( 'yith-wcwl-browse-wishlist-label', __( 'Already Added', 'trend' ) )?>
        </a>
    </div>

    <div style="clear:both"></div>
    <div class="yith-wcwl-wishlistaddresponse"></div>

</div>

<div class="clear"></div>