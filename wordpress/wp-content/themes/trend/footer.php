<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Trend
 */
?>
<?php

global $trend_redux;

?>


    <?php  if ( ! class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
        <!-- BACK TO TOP BUTTON -->
        <a class="back-to-top modeltheme-is-visible modeltheme-fade-out" href="#0">
            <span></span>
        </a>
    <?php }else{ ?>
        <?php if (trend_redux('mt_backtotop_status') == true) { ?>
            <!-- BACK TO TOP BUTTON -->
            <a class="back-to-top modeltheme-is-visible modeltheme-fade-out" href="#0">
                <span></span>
            </a>
        <?php } ?>
    <?php } ?>


    <footer>
        <?php if ( $trend_redux['trend-enable-footer-widgets'] ) { ?>

        <div class="container footer-top">
            <div class="row <?php echo esc_attr($trend_redux['trend_number_of_footer_columns']); ?>">

                <?php
                $columns    = 12/intval($trend_redux['trend_number_of_footer_columns']);
                $nr         = array("1", "2", "3", "4", "6");

                if (in_array($trend_redux['trend_number_of_footer_columns'], $nr)) {
                    $class = 'col-md-'.esc_attr($columns);
                    for ( $i=1; $i <= intval( $trend_redux['trend_number_of_footer_columns'] ) ; $i++ ) { 

                        echo '<div class="'.esc_attr($class).' widget widget_text">';
                            dynamic_sidebar( 'footer_column_'.esc_attr($i) );
                        echo '</div>';

                    }
                }elseif($trend_redux['trend_number_of_footer_columns'] == 5){
                    #First
                    if ( is_active_sidebar( 'footer_column_1' ) ) {
                        echo '<div class="col-md-3 widget widget_text">';
                            dynamic_sidebar( 'footer_column_1' );
                        echo '</div>';
                    }
                    #Second
                    if ( is_active_sidebar( 'footer_column_2' ) ) {
                        echo '<div class="col-md-2 widget widget_text">';
                            dynamic_sidebar( 'footer_column_2' );
                        echo '</div>';
                    }
                    #Third
                    if ( is_active_sidebar( 'footer_column_3' ) ) {
                        echo '<div class="col-md-2 widget widget_text">';
                            dynamic_sidebar( 'footer_column_3' );
                        echo '</div>';
                    }
                    #Fourth
                    if ( is_active_sidebar( 'footer_column_4' ) ) {
                        echo '<div class="col-md-2 widget widget_text">';
                            dynamic_sidebar( 'footer_column_4' );
                        echo '</div>';
                    }
                    #Fifth
                    if ( is_active_sidebar( 'footer_column_5' ) ) {
                        echo '<div class="col-md-3 widget widget_text">';
                            dynamic_sidebar( 'footer_column_5' );
                        echo '</div>';
                    }
                }
                ?>

            </div>
        </div>

        <?php } ?>
        <div class="footer">
            <div class="container">
                <div class="row">
                    <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
                        <div class="col-md-6">
                            <p class="copyright"><?php echo wp_kses_post($trend_redux['trend_footer_text']); ?></p>
                        </div>
                        <div class="col-md-6 payment-methods">
                            <img src="<?php echo esc_url($trend_redux['trend_card_icons']['url']); ?>" alt="card-icons" class="pull-right" />              
                        </div>
                    <?php } else { ?>
                        <div class="col-md-12 text-center">
                            <p class="copyright"><?php echo esc_html__('Copyright by ModelTheme. All Rights Reserved.','trend'); ?></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
