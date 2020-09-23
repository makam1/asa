<?php namespace Premmerce\Wishlist\Frontend;

use Premmerce\SDK\V2\FileManager\FileManager;
use Premmerce\Wishlist\WishlistPlugin;
use Premmerce\Wishlist\Models\WishlistModel;
use Premmerce\Wishlist\WishlistStorage;
use Premmerce\Wishlist\Integration\OceanWpIntegration;

/**
 * Class Frontend
 *
 * @package Premmerce\Wishlist\Frontend
 */
class Frontend
{
    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * @var WishlistModel
     */
    private $model;

    /**
     * @var WishlistStorage
     */
    private $storage;

    /**
     * Frontend constructor.
     *
     * @param FileManager $fileManager
     * @param WishlistModel $model
     * @param WishlistStorage $storage
     */
    public function __construct(FileManager $fileManager, WishlistModel $model, WishlistStorage $storage)
    {
        $this->fileManager = $fileManager;
        $this->model       = $model;
        $this->storage     = $storage;

        add_action('woocommerce_single_product_summary', array($this, 'renderWishlistBtn'), 35);
        add_action('woocommerce_after_shop_loop_item', array($this, 'renderWishlistBtn'));
        add_action('woocommerce_after_shop_loop_item', array($this, 'renderWishListMoveBtn'));
        add_action('woocommerce_before_shop_loop_item', array($this, 'renderWishListDeleteBtn'));

        add_action('wp_login', array($this, 'assignUserWishlistFromCookie'), 10, 2);

        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_script('jquery');
            wp_enqueue_script(
                'wishlist-script',
                $this->fileManager->locateAsset('frontend/js/premmerce-wishlist.js'),
                array('jquery-blockui')
            );
            wp_enqueue_script(
                'magnific-popup',
                $this->fileManager->locateAsset('frontend/js/jquery.magnific-popup.min.js')
            );
            wp_enqueue_style('magnific-popup', $this->fileManager->locateAsset('frontend/css/magnific-popup.css'));
            wp_enqueue_style('wishlist-style', $this->fileManager->locateAsset('frontend/css/premmerce-wishlist.css'));
        });

        add_shortcode('wishlist_page', array($this, 'wishlistPage'));

        //Theme integration
        add_action('init', array($this, 'checkIntegration'));
    }

    /**
     * Render button "Add to wishlist"
     *
     * @param null $productId
     */
    public function renderWishlistBtn($productId = null)
    {
        global $product;

        $productId = $productId ? $productId : $product->get_ID();

        if (! $this->isWishListPage()) {
            $this->fileManager->includeTemplate('frontend/wishlist-btn.php', array(
                'addUrl'    => WishlistFunctions::getInstance()->getAddPopupUrl($productId),
                'productId' => $productId,
                'product'   => $product,
            ));
        }
    }

    /**
     * Render button "Move between list"
     */
    public function renderWishListMoveBtn()
    {
        global $product;

        if ($this->isWishListPage() && count($this->model->getWishlists()) >= 2 && ! $this->isOnlyView()) {
            $addRoute = 'wp-json/premmerce/wishlist/add/popup';

            global $wishlist_current;
            $this->fileManager->includeTemplate('frontend/wishlist-btn-move.php', array(
                'addUrl' => wp_nonce_url(
                    home_url($addRoute . '?wishlist_move_from=true&wishlist_key=' . $wishlist_current['wishlist_key'] . '&wishlist_product_id=' . $product->get_id()),
                    'wp_rest'
                ),
            ));
        }
    }

    /**
     * Render button "Delete from list"
     */
    public function renderWishListDeleteBtn()
    {
        if ($this->isWishListPage() && ! $this->isOnlyView()) {
            global $wishlist_current;
            global $product;

            $apiUrl = 'wp-json/premmerce/wishlist/delete/';

            $deleteUrl = wp_nonce_url(
                home_url($apiUrl . $wishlist_current['wishlist_key'] . '/' . $product->get_ID()),
                'wp_rest'
            );

            $this->fileManager->includeTemplate('frontend/wishlist-btn-delete.php', array(
                'deleteUrl' => $deleteUrl,
            ));
        }
    }

    /**
     * Check WishList page
     * @return bool
     */
    public function isWishListPage()
    {
        global $wishlistPage;

        return isset($wishlistPage) && $wishlistPage == true;
    }

    /**
     *  Render wishlist page
     */
    public function wishlistPage()
    {
        $wishlists = array();

        if (isset($_GET['key'])) {
            $wishlists = $this->model->getWishlistByKey($_GET['key']);

            if ($wishlists) {
                $wishlists = array($wishlists);
            }
        } else {
            if (is_user_logged_in()) {
                $wishlists = $this->model->getWishlistsByUserId(get_current_user_id());
            } elseif ($this->storage->cookieIsSet()) {
                $wishlists = $this->model->getWishlistsByKeys($this->storage->cookieGet());
            }
        }

        foreach ($wishlists as &$wl) {
            $wl['products'] = $this->model->getProductsByIds($wl['products']);
        }

        $pageSlug = 'wishlist';
        if ($pageId = get_option(WishlistPlugin::OPTION_PAGE)) {
            $post = get_post($pageId);

            if ($post) {
                $pageSlug = $post->post_name;
            }
        }

        $this->fileManager->includeTemplate('frontend/wishlist-page.php', array(
            'pageSlug'             => $pageSlug,
            'wishlists'            => $wishlists,
            'onlyView'             => $this->isOnlyView(),
            'showMove'             => count($wishlists) > 1 ? true : false,
            'apiUrlWishListDelete' => '/wp-json/premmerce/wishlist/delete/',
            'apiUrlWishListRename' => '/wp-json/premmerce/wishlist/page/rename/',
        ));
    }

    private function isOnlyView()
    {
        $onlyView = true;

        if (isset($_GET['key'])) {
            $wishlist = $this->model->getWishlistByKey($_GET['key']);

            if ($wishlist) {
                if (is_user_logged_in()) {
                    $onlyView = get_current_user_id() == $wishlist['user_id'] ? false : true;
                } elseif ($this->storage->cookieIsSet()) {
                    $onlyView = in_array($_GET['key'], $this->storage->cookieGet()) ? false : true;
                }
            }
        } else {
            if (is_user_logged_in()) {
                $onlyView = false;
            } elseif ($this->storage->cookieIsSet()) {
                $onlyView = false;
            }
        }

        return $onlyView;
    }

    /**
     * When user logged in assign all wishlist from cookie to user
     *
     * @param $login
     * @param $user
     */
    public function assignUserWishlistFromCookie($login, $user)
    {
        if ($this->storage->cookieIsSet()) {
            $this->model->setUserToWishlistsByKeys($user->ID, $this->storage->cookieGet());
            $this->model->combineDefaultsWishlistsByUserID($user->ID);
        }
    }

    public function checkIntegration()
    {
        $theme = wp_get_theme();

        if ('oceanwp' == $theme->get_template()) {
            new OceanWpIntegration($this, $this->fileManager);
        }
    }
}
