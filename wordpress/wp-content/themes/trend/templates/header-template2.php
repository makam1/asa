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


<div class="top-header">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-6">
        <?php if ( is_user_logged_in() ) { 
          esc_attr_e('Welcome! ', 'trend') . wp_register('', '') . esc_attr_e(' or ', 'trend') . wp_loginout();
        }else{
          if ( get_option( 'users_can_register' ) ) {
            esc_attr_e('Welcome! Please ', 'trend') . wp_register('', '') . esc_attr_e(' or ', 'trend') . wp_loginout();
          }else{
            esc_attr_e('Welcome! Please ', 'trend') . wp_register('', '') . wp_loginout();
          }
        } ?> 
      </div>
      <div class="col-md-6 col-sm-6 text-right account-urls">
        <a class="top-wishliist" href="<?php echo esc_url($wishlist_url); ?>">
          <i class="fa fa-heart-o"></i>
          <?php esc_attr_e('Wishlist', 'trend'); ?>
        </a>
        <a href="<?php echo esc_url($myaccount_page_url); ?>">
          <i class="fa fa-user"></i>
          <?php esc_attr_e('My account', 'trend'); ?>
        </a>
      </div>
    </div>
  </div>
</div>

<div id="trend-main-head">
  <nav class="navbar navbar-default">
    <div class="container">
        <div class="row">
            <div class="navbar-header col-md-3">

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
            <?php if (! class_exists( 'ReduxFrameworkPlugin' )){ ?>
              <?php if ( class_exists( 'mega_main_init' ) ) { ?>
                <div id="navbar" class="navbar-collapse collapse in col-md-9">
              <?php }else{ ?>
                <div id="navbar" class="navbar-collapse collapse col-md-9">
              <?php } ?>
            <?php }else{ ?>
              <?php if ( class_exists( 'mega_main_init' ) ) { ?>
                <div id="navbar" class="navbar-collapse collapse in col-md-9">
              <?php }else{ ?>
                <div id="navbar" class="navbar-collapse collapse col-md-9">
              <?php } ?>
            <?php } ?>
                <ul class="menu nav navbar-nav pull-right nav-effect nav-menu">
                    <?php if ( class_exists( 'WooCommerce' ) ) { ?>
                    <li class="shop_cart">
                      <a href="<?php echo esc_url($cart_url); ?>"><i class="fa fa-shopping-cart"></i></a>
                    </li>
                    <?php } ?>
                    <li class="search_products">
                      <div class="nav_search_holder">
                        <div id="trend-search" class="trend-search">
                          <form method="GET" action="<?php echo esc_url(home_url('/')); ?>">
                            <input class="trend-search-input" placeholder="<?php esc_attr_e('Enter your search term...', 'trend'); ?>" type="search" value="" name="s" id="search">
                            <input class="trend-search-submit" type="submit" value="">
                            <?php if (isset($trend_redux['search_for']) && $trend_redux['search_for'] == 'products') { ?>
                              <input type="hidden" value="product" name="post_type">
                            <?php } ?>
                            <span class="trend-icon-search"></span>
                          </form>
                        </div>
                      </div>
                    </li>
                </ul>
                <?php if ( class_exists( 'WooCommerce' ) ) { ?>
                <div class="header_mini_cart">
                  <?php the_widget( 'WC_Widget_Cart' ); ?>
                </div>
                <?php } ?>
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