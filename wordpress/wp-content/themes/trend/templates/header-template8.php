<?php
  #Redux global variable
  global $trend_redux;
  #WooCommerce global variable
  global $woocommerce;
  $myaccount_page_url = '#';
  if ( class_exists( 'WooCommerce' ) ) {
    $cart_url = wc_get_cart_url();
    
    #My account url
    $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
    if ( $myaccount_page_id ) {
      $myaccount_page_url = get_permalink( $myaccount_page_id );
    }else{
      $myaccount_page_url = '#';
    }
  }else{
    $myaccount_page_url = '#';
  }
  #YITH Wishlist rul
  if( function_exists( 'YITH_WCWL' ) ){
      $wishlist_url = YITH_WCWL()->get_wishlist_url();
  }else{
      $wishlist_url = '#';
  }
?>

<div id="trend-main-head">
  <nav class="navbar navbar-default">
    <div class="container">
        <div class="row">
          <div class="navbar-header col-md-12">

              <?php if ( !class_exists( 'mega_main_init' ) ) { ?>
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
              <?php } ?>

              <?php echo trend_logo(); ?>
            </div>
          </div>
    </div>
  </nav>

  <nav class="navbar navbar-default">
    <div class="container">
      <ul class="menu nav navbar-nav pull-right nav-effect nav-menu">
      <?php
        $defaults = array(
          'menu'            => '',
          'container'       => false,
          'container_class' => '',
          'container_id'    => '',
          'menu_class'      => 'menu',
          'menu_id'         => '',
          'echo'            => true,
          'fallback_cb'     => false,
          'before'          => '',
          'after'           => '',
          'link_before'     => '',
          'link_after'      => '',
          'items_wrap'      => '%3$s',
          'depth'           => 0,
          'walker'          => ''
        );
        $defaults['theme_location'] = 'primary';

        wp_nav_menu( $defaults );
      ?>
      </ul>
    </div>
  </nav>
</div>