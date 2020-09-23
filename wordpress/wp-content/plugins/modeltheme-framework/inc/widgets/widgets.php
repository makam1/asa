<?php 


/* ========= social_icons ===================================== */
class social_icons extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct('social_icons', esc_attr__('TREND - Social icons widget', 'trend'),array( 'description' => esc_attr__( 'TREND - Social icons widget', 'trend' ), ) );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        global $trend_redux;
        $widget_title = $instance[ 'widget_title' ];

        echo  $args['before_widget']; ?>

        <div class="sidebar-social-networks">
            <?php if($widget_title) { ?>
               <h3 class="widget-title"><?php echo esc_attr($widget_title); ?></h3>
            <?php } ?>
            <ul>
            <?php if ( isset($trend_redux['trend_social_fb']) && $trend_redux['trend_social_fb'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_fb'] ) ?>"><i class="fa fa-facebook"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_tw']) && $trend_redux['trend_social_tw'] != '' ) { ?>
                <li><a href="https://twitter.com/<?php echo esc_attr( $trend_redux['trend_social_tw'] ) ?>"><i class="fa fa-twitter"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_gplus']) && $trend_redux['trend_social_gplus'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_gplus'] ) ?>"><i class="fa fa-google-plus"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_youtube']) && $trend_redux['trend_social_youtube'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_youtube'] ) ?>"><i class="fa fa-youtube"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_pinterest']) && $trend_redux['trend_social_pinterest'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_pinterest'] ) ?>"><i class="fa fa-pinterest"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_linkedin']) && $trend_redux['trend_social_linkedin'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_linkedin'] ) ?>"><i class="fa fa-linkedin"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_skype']) && $trend_redux['trend_social_skype'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_skype'] ) ?>"><i class="fa fa-skype"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_instagram']) && $trend_redux['trend_social_instagram'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_instagram'] ) ?>"><i class="fa fa-instagram"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_dribbble']) && $trend_redux['trend_social_dribbble'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_dribbble'] ) ?>"><i class="fa fa-dribbble"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_deviantart']) && $trend_redux['trend_social_deviantart'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_deviantart'] ) ?>"><i class="fa fa-deviantart"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_digg']) && $trend_redux['trend_social_digg'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_digg'] ) ?>"><i class="fa fa-digg"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_flickr']) && $trend_redux['trend_social_flickr'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_flickr'] ) ?>"><i class="fa fa-flickr"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_stumbleupon']) && $trend_redux['trend_social_stumbleupon'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_stumbleupon'] ) ?>"><i class="fa fa-stumbleupon"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_tumblr']) && $trend_redux['trend_social_tumblr'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_tumblr'] ) ?>"><i class="fa fa-tumblr"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_vimeo']) && $trend_redux['trend_social_vimeo'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_vimeo'] ) ?>"><i class="fa fa-vimeo-square"></i></a></li>
            <?php } ?>
            </ul>
        </div>
        <?php echo  $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        
        # Widget Title
        if ( isset( $instance[ 'widget_title' ] ) ) {
            $widget_title = $instance[ 'widget_title' ];
        } else {
            $widget_title = esc_attr__( 'Social icons', 'trend' );;
        }

        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'widget_title' )); ?>"><?php esc_attr_e( 'Widget Title:','trend' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'widget_title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'widget_title' )); ?>" type="text" value="<?php echo esc_attr( $widget_title ); ?>">
        </p>
        <p><?php esc_attr_e( '* Social Network account must be set from TREND - Theme Panel.','trend' ); ?></p>
        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['widget_title'] = ( ! empty( $new_instance['widget_title'] ) ) ?  $new_instance['widget_title']  : '';

        return $instance;
    }

}












/* ========= social_icons ===================================== */
class address_social_icons extends WP_Widget {



    function __construct() {
        parent::__construct('address_social_icons', esc_attr__('TREND - Contact + Social links', 'trend'),array( 'description' => esc_attr__( 'TREND - Contact information + Social icons', 'trend' ), ) );
    }



    public function widget( $args, $instance ) {
        global $trend_redux;
        $widget_title = $instance[ 'widget_title' ];

        echo  $args['before_widget']; ?>

        <div class="sidebar-social-networks address-social-links">
            <?php if($widget_title) { ?>
               <h3 class="widget-title"><?php echo esc_attr($widget_title); ?></h3>
            <?php } ?>

            <div class="contact-details">
                <p><i class="fa fa-home"></i> <?php echo esc_attr($trend_redux['trend_contact_address']); ?></p>
                <p><i class="fa fa-phone-square"></i> <?php echo esc_attr($trend_redux['trend_contact_phone']); ?></p>
                <p><i class="fa fa-envelope-square"></i> <?php echo esc_attr__('Email: ','trend') . $trend_redux['trend_contact_email']; ?></p>
            </div>

            <ul class="social-links">
            <?php if ( isset($trend_redux['trend_social_fb']) && $trend_redux['trend_social_fb'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_fb'] ) ?>"><i class="fa fa-facebook"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_tw']) && $trend_redux['trend_social_tw'] != '' ) { ?>
                <li><a href="https://twitter.com/<?php echo esc_attr( $trend_redux['trend_social_tw'] ) ?>"><i class="fa fa-twitter"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_gplus']) && $trend_redux['trend_social_gplus'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_gplus'] ) ?>"><i class="fa fa-google-plus"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_youtube']) && $trend_redux['trend_social_youtube'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_youtube'] ) ?>"><i class="fa fa-youtube"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_pinterest']) && $trend_redux['trend_social_pinterest'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_pinterest'] ) ?>"><i class="fa fa-pinterest"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_linkedin']) && $trend_redux['trend_social_linkedin'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_linkedin'] ) ?>"><i class="fa fa-linkedin"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_skype']) && $trend_redux['trend_social_skype'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_skype'] ) ?>"><i class="fa fa-skype"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_instagram']) && $trend_redux['trend_social_instagram'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_instagram'] ) ?>"><i class="fa fa-instagram"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_dribbble']) && $trend_redux['trend_social_dribbble'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_dribbble'] ) ?>"><i class="fa fa-dribbble"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_deviantart']) && $trend_redux['trend_social_deviantart'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_deviantart'] ) ?>"><i class="fa fa-deviantart"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_digg']) && $trend_redux['trend_social_digg'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_digg'] ) ?>"><i class="fa fa-digg"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_flickr']) && $trend_redux['trend_social_flickr'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_flickr'] ) ?>"><i class="fa fa-flickr"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_stumbleupon']) && $trend_redux['trend_social_stumbleupon'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_stumbleupon'] ) ?>"><i class="fa fa-stumbleupon"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_tumblr']) && $trend_redux['trend_social_tumblr'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_tumblr'] ) ?>"><i class="fa fa-tumblr"></i></a></li>
            <?php } ?>
            <?php if ( isset($trend_redux['trend_social_vimeo']) && $trend_redux['trend_social_vimeo'] != '' ) { ?>
                <li><a href="<?php echo esc_attr( $trend_redux['trend_social_vimeo'] ) ?>"><i class="fa fa-vimeo-square"></i></a></li>
            <?php } ?>
            </ul>
        </div>
        <?php echo  $args['after_widget'];
    }





    public function form( $instance ) {

        # Widget Title
        if ( isset( $instance[ 'widget_title' ] ) ) {
            $widget_title = $instance[ 'widget_title' ];
        } else {
            $widget_title = esc_attr__( 'Social icons', 'trend' );;
        }

        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'widget_title' )); ?>"><?php esc_attr_e( 'Widget Title:','trend' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'widget_title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'widget_title' )); ?>" type="text" value="<?php echo esc_attr( $widget_title ); ?>">
        </p>
        <p><?php esc_attr_e( '* Social Network account must be set from TREND - Theme Panel.','trend' ); ?></p>
        <?php 
    }




    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['widget_title'] = ( ! empty( $new_instance['widget_title'] ) ) ?  $new_instance['widget_title']  : '';

        return $instance;
    }
}

















/* ========= Trend_Flickr_Feed_Widget ===================================== */
class flickr extends WP_Widget { 
    
    function __construct() {
        $widget_ops = array('description' => esc_attr__('Display latest Flickr Feed','trend') );
        $control_ops = array( 'width' => 60, 'height' => 60, 'id_base' => 'flickr' );
        parent::__construct( 'flickr', esc_attr__('MT - Flickr Feed','trend'), $widget_ops, $control_ops );
    }
    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $username = $instance['username'];
        $pics = $instance['pics'];
        
        echo  $before_widget;
        echo '<h3 class="widget-title">'.$title.'</h3>';

        echo '<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count='.$pics.'&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user='.$username.'"></script>';
        echo  $after_widget;
    }
    
    // Update
    function update( $new_instance, $old_instance ) {  
        $instance = $old_instance; 
        
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['username'] = strip_tags( $new_instance['username'] );
        $instance['pics'] = strip_tags( $new_instance['pics'] );

        return $instance;
    }
    
    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    function form($instance) {
        $defaults = array( 'title' => 'Flickr Widget', 'pics' => '9', 'username' => '49229574@N00' ); // Default Values
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e('Title of the Widget', 'trend'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'username' )); ?>"><?php esc_attr_e('Your Flickr ID:', 'trend'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'username' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'username' )); ?>" value="<?php echo esc_attr($instance['username']); ?>" /><br /><a href="<?php echo esc_url_raw( 'http://idgettr.com/' ); ?>" target="_blank"><?php esc_attr_e('Flickr idGettr','trend'); ?></a>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'pics' )); ?>"><?php esc_attr_e('Number of Photos to show:', 'trend'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'pics' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'pics' )); ?>" value="<?php echo esc_attr($instance['pics']); ?>" />
        </p>
        
    <?php }
}








/* ========= TREND_Recent_Posts_Widget ===================================== */
class recent_entries_with_thumbnail extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct('recent_entries_with_thumbnail', esc_attr__('TREND - Recent Posts with thumbnails', 'trend'),array( 'description' => esc_attr__( 'TREND - Recent Posts with thumbnails', 'trend' ), ) );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        $recent_posts_title = $instance[ 'recent_posts_title' ];
        $recent_posts_number = $instance[ 'recent_posts_number' ];

        echo  $args['before_widget'];

        $args_recenposts = array(
                'posts_per_page'   => $recent_posts_number,
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_type'        => 'post',
                'post_status'      => 'publish' 
                );

        $recentposts = get_posts($args_recenposts);
        $myContent  = "";
        $myContent .= '<h3 class="widget-title">'.$recent_posts_title.'</h3>';
        $myContent .= '<ul>';

        foreach ($recentposts as $post) {
            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'trend_post_widget_pic70x70' );

            $myContent .= '<li class="row">';
                $myContent .= '<div class="vc_col-md-3 post-thumbnail relative">';
                    $myContent .= '<a href="'. get_permalink($post->ID) .'">';
                        if($thumbnail_src) { $myContent .= '<img src="'. $thumbnail_src[0] . '" alt="'. $post->post_title .'" />';
                        }else{ $myContent .= '<img src="http://placehold.it/70x70" alt="'. $post->post_title .'" />'; }
                        $myContent .= '<div class="thumbnail-overlay absolute">';
                            $myContent .= '<i class="fa fa-plus absolute"></i>';
                        $myContent .= '</div>';
                    $myContent .= '</a>';
                $myContent .= '</div>';
                $myContent .= '<div class="vc_col-md-9 post-details">';
                    $myContent .= '<a href="'. get_permalink($post->ID) .'">'. $post->post_title.'</a>';
                    $myContent .= '<span class="post-date">'.get_the_date( "F j, Y" ).'</span>';
                $myContent .= '</div>';
            $myContent .= '</li>';
        }
        $myContent .= '</ul>';

        echo  $myContent;
        echo  $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        
        # Widget Title
        if ( isset( $instance[ 'recent_posts_title' ] ) ) {
            $recent_posts_title = $instance[ 'recent_posts_title' ];
        } else {
            $recent_posts_title = esc_attr__( 'Recent posts', 'trend' );;
        }

        # Number of posts
        if ( isset( $instance[ 'recent_posts_number' ] ) ) {
            $recent_posts_number = $instance[ 'recent_posts_number' ];
        } else {
            $recent_posts_number = esc_attr__( '5', 'trend' );;
        }

        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'recent_posts_title' )); ?>"><?php esc_attr_e( 'Widget Title:','trend' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'recent_posts_title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'recent_posts_title' )); ?>" type="text" value="<?php echo esc_attr( $recent_posts_title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'recent_posts_number' )); ?>"><?php esc_attr_e( 'Number of posts:','trend' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'recent_posts_number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'recent_posts_number' )); ?>" type="text" value="<?php echo esc_attr( $recent_posts_number ); ?>">
        </p>
        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['recent_posts_title'] = ( ! empty( $new_instance['recent_posts_title'] ) ) ?  $new_instance['recent_posts_title']  : '';
        $instance['recent_posts_number'] = ( ! empty( $new_instance['recent_posts_number'] ) ) ? strip_tags( $new_instance['recent_posts_number'] ) : '';
        return $instance;
    }

} 









/* ========= Tabs Widget ===================================== */
class popular_recent_tabs extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct('popular_recent_tabs', esc_attr__('TREND - TABS: Random, Recent posts', 'trend'),array( 'description' => esc_attr__( 'TREND - TABS: Random, Recent posts', 'trend' ), ) );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        $recent_posts_title = $instance[ 'recent_posts_title' ];
        $title_first_tab = $instance[ 'title_first_tab' ];
        $recent_posts_number = $instance[ 'recent_posts_number' ];

        $title_second_tab = $instance[ 'title_second_tab' ];
        $popular_posts_number = $instance[ 'popular_posts_number' ];

        echo $args['before_widget'];

        $args_popularposts = array(
            'posts_per_page'   => $popular_posts_number,
            'orderby'          => 'rand',
            'post_type'        => 'post',
            'post_status'      => 'publish' 
        );
        $popularposts = get_posts($args_popularposts);

        $args_recenposts = array(
            'posts_per_page'   => $recent_posts_number,
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_type'        => 'post',
            'post_status'      => 'publish' 
        );
        $recentposts = get_posts($args_recenposts);



        $myContent  = "";
        $myContent .= '<h3 class="widget-title">'.$recent_posts_title.'</h3>';
        $myContent .= '<div class="widget_body">';
            $myContent .= '<ul class="nav nav-tabs">';
                $myContent .= '<li class="active"><a data-toggle="tab" href="#popular-posts">'.$title_first_tab.'</a></li>';
                $myContent .= '<li><a data-toggle="tab" href="#recent-posts">'.$title_second_tab.'</a></li>';
            $myContent .= '</ul>';
            $myContent .= '<div class="tab-content">';
                $myContent .= '<div id="popular-posts" class="tab-pane fade in active">';
                foreach ($popularposts as $post) {
                    $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'trend_post_pic700x450' );
                    $excerpt = get_post_field('post_content', $post->ID);

                    $myContent .= '<div class="recent-post">';
                        $myContent .= '<a href="'. get_permalink($post->ID) .'">';
                            if($thumbnail_src) { $myContent .= '<img src="'. $thumbnail_src[0] . '" alt="'. $post->post_title .'" />';
                            }else{ $myContent .= '<img src="http://placehold.it/700x450" alt="'. $post->post_title .'" />'; }
                        $myContent .= '</a>';
                        $myContent .= '<div class="post-title">'. $post->post_title .'</div>';
                        $myContent .= '<div class="post-date">'.get_the_date( 'F j, Y', $post->ID ).'</div>';
                        $myContent .= '<div class="post-description">'.trend_excerpt_limit($excerpt,10).'</div>';
                    $myContent .= '</div>';
                }
                $myContent .= '</div>';

                $myContent .= '<div id="recent-posts" class="tab-pane fade">';
                foreach ($recentposts as $post) {
                    $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'trend_post_pic700x450' );
                    $excerpt = get_post_field('post_content', $post->ID);
                    
                    $myContent .= '<div class="popular-post">';
                        $myContent .= '<a href="'. get_permalink($post->ID) .'">';
                            if($thumbnail_src) { $myContent .= '<img src="'. $thumbnail_src[0] . '" alt="'. $post->post_title .'" />';
                            }else{ $myContent .= '<img src="http://placehold.it/500x300" alt="'. $post->post_title .'" />'; }
                        $myContent .= '</a>';
                        $myContent .= '<div class="post-title">'. $post->post_title .'</div>';
                        $myContent .= '<div class="post-date">'.get_the_date( 'F j, Y', $post->ID ).'</div>';
                        $myContent .= '<div class="post-description">'.trend_excerpt_limit($excerpt,10).'</div>';
                    $myContent .= '</div>';
                }
                $myContent .= '</div>';
            $myContent .= '</div>';
        $myContent .= '</div>';

        echo  $myContent;
        echo  $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        
        # Widget Title
        if ( isset( $instance[ 'recent_posts_title' ] ) ) {
            $recent_posts_title = $instance[ 'recent_posts_title' ];
        } else {
            $recent_posts_title = esc_attr__( 'Tab Widget', 'trend' );;
        }



        /*Tab 1 title*/
        if ( isset( $instance[ 'title_first_tab' ] ) ) {
            $title_first_tab = $instance[ 'title_first_tab' ];
        } else {
            $title_first_tab = esc_attr__( 'Random posts', 'trend' );;
        }
        # Number of posts
        if ( isset( $instance[ 'popular_posts_number' ] ) ) {
            $popular_posts_number = $instance[ 'popular_posts_number' ];
        } else {
            $popular_posts_number = esc_attr__( '2', 'trend' );;
        }


        /*Tab 2 title*/
        if ( isset( $instance[ 'title_second_tab' ] ) ) {
            $title_second_tab = $instance[ 'title_second_tab' ];
        } else {
            $title_second_tab = esc_attr__( 'Recent posts', 'trend' );;
        }
        # Number of posts
        if ( isset( $instance[ 'recent_posts_number' ] ) ) {
            $recent_posts_number = $instance[ 'recent_posts_number' ];
        } else {
            $recent_posts_number = esc_attr__( '2', 'trend' );;
        }

        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'recent_posts_title' )); ?>"><?php esc_attr_e( 'Widget Title:','trend' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'recent_posts_title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'recent_posts_title' )); ?>" type="text" value="<?php echo esc_attr( $recent_posts_title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title_first_tab' )); ?>"><?php esc_attr_e( 'Number of recent posts:','trend' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title_first_tab' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title_first_tab' )); ?>" type="text" value="<?php echo esc_attr( $title_first_tab ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'recent_posts_number' )); ?>"><?php esc_attr_e( 'Number of recent posts:','trend' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'recent_posts_number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'recent_posts_number' )); ?>" type="text" value="<?php echo esc_attr( $recent_posts_number ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title_second_tab' )); ?>"><?php esc_attr_e( 'Number of popular posts:','trend' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title_second_tab' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title_second_tab' )); ?>" type="text" value="<?php echo esc_attr( $title_second_tab ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'popular_posts_number' )); ?>"><?php esc_attr_e( 'Number of popular posts:','trend' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'popular_posts_number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'popular_posts_number' )); ?>" type="text" value="<?php echo esc_attr( $popular_posts_number ); ?>">
        </p>
        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['recent_posts_title'] = ( ! empty( $new_instance['recent_posts_title'] ) ) ?  $new_instance['recent_posts_title']  : '';
        $instance['title_first_tab'] = ( ! empty( $new_instance['title_first_tab'] ) ) ? strip_tags( $new_instance['title_first_tab'] ) : '';
        $instance['recent_posts_number'] = ( ! empty( $new_instance['recent_posts_number'] ) ) ? strip_tags( $new_instance['recent_posts_number'] ) : '';
        $instance['title_second_tab'] = ( ! empty( $new_instance['title_second_tab'] ) ) ? strip_tags( $new_instance['title_second_tab'] ) : '';
        $instance['popular_posts_number'] = ( ! empty( $new_instance['popular_posts_number'] ) ) ? strip_tags( $new_instance['popular_posts_number'] ) : '';
        return $instance;
    }

} 








/* ========= post_thumbnails_slider ===================================== */
class post_thumbnails_slider extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct('post_thumbnails_slider', esc_attr__('TREND - Post thumbnails slider', 'trend'),array( 'description' => esc_attr__( 'TREND - Post thumbnails slider', 'trend' ), ) );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        $recent_posts_title = $instance[ 'recent_posts_title' ];
        $recent_posts_number = $instance[ 'recent_posts_number' ];

        echo  $args['before_widget'];

        $args_recenposts = array(
                'posts_per_page'   => $recent_posts_number,
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_type'        => 'post',
                'post_status'      => 'publish' 
                );

        $recentposts = get_posts($args_recenposts);
        $myContent  = "";
        $myContent .= '<h3 class="widget-title">'.$recent_posts_title.'</h3>';
        $myContent .= '<div class="slider_holder relative">';
            $myContent .= '<div class="slider_navigation absolute">';
                $myContent .= '<a class="btn prev pull-left"><i class="fa fa-angle-left"></i></a>';
                $myContent .= '<a class="btn next pull-right"><i class="fa fa-angle-right"></i></a>';
            $myContent .= '</div>';
            $myContent .= '<div class="post_thumbnails_slider owl-carousel owl-theme">';

            foreach ($recentposts as $post) {
                $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'trend_post_pic700x450' );
                $myContent .= '<div class="item">';
                    $myContent .= '<a href="'. get_permalink($post->ID) .'">';
                        if($thumbnail_src) { $myContent .= '<img src="'. $thumbnail_src[0] . '" alt="'. $post->post_title .'" />';
                        }else{ $myContent .= '<img src="http://placehold.it/700x450" alt="'. $post->post_title .'" />'; }
                    $myContent .= '</a>';
                $myContent .= '</div>';
            }
            $myContent .= '</div>';
        $myContent .= '</div>';

        echo  $myContent;
        echo  $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        
        # Widget Title
        if ( isset( $instance[ 'recent_posts_title' ] ) ) {
            $recent_posts_title = $instance[ 'recent_posts_title' ];
        } else {
            $recent_posts_title = esc_attr__( 'Post thumbnails slider', 'trend' );;
        }

        # Number of posts
        if ( isset( $instance[ 'recent_posts_number' ] ) ) {
            $recent_posts_number = $instance[ 'recent_posts_number' ];
        } else {
            $recent_posts_number = esc_attr__( '5', 'trend' );;
        }

        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'recent_posts_title' )); ?>"><?php esc_attr_e( 'Widget Title:','trend' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'recent_posts_title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'recent_posts_title' )); ?>" type="text" value="<?php echo esc_attr( $recent_posts_title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'recent_posts_number' )); ?>"><?php esc_attr_e( 'Number of posts:','trend' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'recent_posts_number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'recent_posts_number' )); ?>" type="text" value="<?php echo esc_attr( $recent_posts_number ); ?>">
        </p>
        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['recent_posts_title'] = ( ! empty( $new_instance['recent_posts_title'] ) ) ?  $new_instance['recent_posts_title']  : '';
        $instance['recent_posts_number'] = ( ! empty( $new_instance['recent_posts_number'] ) ) ? strip_tags( $new_instance['recent_posts_number'] ) : '';
        return $instance;
    }

} 






// Register Widgets
function trend_register_widgets() {
    register_widget( 'address_social_icons' );
    register_widget( 'social_icons' );
    register_widget( 'flickr' );
    register_widget( 'recent_entries_with_thumbnail' );
    register_widget( 'post_thumbnails_slider' );
    register_widget( 'popular_recent_tabs' );

}
add_action( 'widgets_init', 'trend_register_widgets' );
?>