<?php

use Premmerce\Wishlist\WishlistPlugin;

global $wishlistPage;
global $wishlist_current;
$wishlistPage = true;

?>
<?php

global $premmerce_wishlist_frontend;

?>

<?php if(count($wishlists) == 0): ?>

    <div class="typo">
        <h2>
			<?php _e('Your wishlist is empty', WishlistPlugin::DOMAIN); ?>
        </h2>
        <p>
			<?php _e('Once added new items, you\'ll be able to continue shopping any time and also share the information about the purchase with your friends.', WishlistPlugin::DOMAIN); ?>
        </p>
    </div>

<?php else : ?>

	<?php foreach($wishlists as $wl): ?>
		<?php $wishlist_current = $wl; ?>
        <section class="content__row woocommerce">
            <div class="wl-frame">
                <!-- Frame header start -->
                <div class="wl-frame__header">
					<?php do_action("premmerce_wishlist_page_before_header_fields", $wl, $onlyView); ?>
                    <!-- Name -->
                    <?php
                        $wishlist_url = esc_url(home_url($pageSlug));
                        $wishlist_url .= (parse_url($wishlist_url, PHP_URL_QUERY) ? '&' : '?') . 'key=' . $wl['wishlist_key'];
                    ?>
                    <div class="wl-frame__title">
                        <a class="wl-frame__title-link"
							<?php if(!$onlyView): ?>
                                href="<?php echo $wishlist_url ?>"
							<?php endif; ?>
                           rel="nofollow">
							<?php echo $wl['name']; ?>
                        </a>
                    </div>
					<?php if(!$onlyView): ?>
                        <!--  Edit -->
                        <div class="wl-frame__header-nav">
                            <button class="wl-frame__header-link"
                                    data-modal-wishlist="<?php echo wp_nonce_url(home_url($apiUrlWishListRename . $wl['wishlist_key']), 'wp_rest'); ?>">
								<?php _e('Rename', WishlistPlugin::DOMAIN); ?>
                            </button>
                        </div>
                        <!-- Delete -->
                        <div class="wl-frame__header-nav">
                            <a class="wl-frame__header-link"
                               href="<?php echo wp_nonce_url(home_url($apiUrlWishListDelete . $wl['wishlist_key']), 'wp_rest'); ?>">
								<?php _e('Delete', WishlistPlugin::DOMAIN); ?>
                            </a>
                        </div>
					<?php endif; ?>
					<?php do_action("premmerce_wishlist_page_after_header_fields", $wl, $onlyView); ?>
                </div><!-- Frame header end -->

                <div class="wl-frame__inner wl-content__row wl-content__row--sm">
					<?php if($wl['products']): ?>
						<?php $productsIds = array_map(function($product){
							return $product->get_ID();
						}, $wl['products']);

						$query = new WP_Query([
							'post_type' => 'product',
							'post__in'  => $productsIds,
						]); ?>
                        <ul class="wl-product-list products">
							<?php while($query->have_posts()) : ?>
								<?php $query->the_post(); ?>
								<?php wc_get_template_part('content', 'product'); ?>
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
                        </ul>
					<?php else: ?>
                        <div class="typo">
                            <h3>
								<?php _e('This list is empty', WishlistPlugin::DOMAIN); ?>
                            </h3>
                            <p>
								<?php _e('Once added new items, you\'ll be able to continue shopping any time and also share the information about the purchase with your friends.', WishlistPlugin::DOMAIN); ?>
                            </p>
                        </div>
					<?php endif; ?>
                </div>

            </div>
        </section>

	<?php endforeach ?>

<?php endif; ?>
<?php $wishlistPage = false; ?>