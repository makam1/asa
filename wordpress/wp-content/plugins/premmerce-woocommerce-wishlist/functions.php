<?php

use Premmerce\Wishlist\Frontend\WishlistFunctions;

if ( ! function_exists( 'premmerce_wishlist' ) ) {

    function premmerce_wishlist() {

        return WishlistFunctions::getInstance();

    }

}