<?php namespace Premmerce\Wishlist\Integration;

use Premmerce\SDK\V2\FileManager\FileManager;
use Premmerce\Wishlist\Frontend\Frontend;

class OceanWpIntegration
{
    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * OceanWpIntegration constructor.
     *
     * @param Frontend $frontend
     * @param FileManager $fileManager
     */
    public function __construct($frontend, $fileManager)
    {
        $this->fileManager = $fileManager;

        add_action('wp_enqueue_scripts', array($this, 'registerAssets'));

        // Show button in quick view
        if (wp_doing_ajax()) {
            add_action('ocean_after_single_product_quantity-button', array($frontend, 'renderWishlistBtn'), 10);
        }

        // Show button on loop product
        remove_action('woocommerce_after_shop_loop_item', array($frontend, 'renderWishlistBtn'));
        add_action('ocean_after_archive_product_inner', array($frontend, 'renderWishlistBtn'), 10);

        // Move button on loop product
        remove_action('woocommerce_after_shop_loop_item', array($frontend, 'renderWishListMoveBtn'));
        add_action('ocean_after_archive_product_inner', array($frontend, 'renderWishListMoveBtn'), 10);
    }

    public function registerAssets()
    {
        wp_enqueue_style('premmerce_wishlist_ocean_wp_style', $this->fileManager->locateAsset('frontend/integration-css/ocean-wp.css'));
    }
}
