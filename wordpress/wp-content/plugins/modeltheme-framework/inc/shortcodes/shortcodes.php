<?php
/*------------------------------------------------------------------
[TREND - SHORTCODES]
Project:    TREND – Multi-Purpose WordPress Template
Author:     ModelTheme
[Table of contents]
1. Recent Tweets
2. Contact Form
4. Recent Posts
5. Featured Post with thumbnail
6. Testimonials
7. Subscribe form
8. Services style 1
9. Services style 2
10. Recent Portfolios
11. Recent testimonials
12. Skill
13. Google map
14. Pricing tables
15. Jumbotron
16. Alert
17. Progress bars
18. Custom content
19. Responsive video (YouTube)
20. Heading With Border
21. Testimonials
22. List group
23. Thumbnails custom content
24. Section heading with title and subtitle
25. Heading with bottom border
26. Portfolio square
27. Call to action
28. Blog posts
29. Social Media
-------------------------------------------------------------------*/
global $trend_redux;
/*---------------------------------------------*/
/*--- 1. Recent Tweets ---*/
/*---------------------------------------------*/
function trend_twitter_time($a) {
    //get current timestampt
    $b = strtotime("now"); 
    //get timestamp when tweet created
    $c = strtotime($a);
    //get difference
    $d = $b - $c;
    //calculate different time values
    $minute = 60;
    $hour = $minute * 60;
    $day = $hour * 24;
    $week = $day * 7;
        
    if(is_numeric($d) && $d > 0) {
        //if less then 3 seconds
        if($d < 3) return "right now";
        //if less then minute
        if($d < $minute) return floor($d) . " seconds ago";
        //if less then 2 minutes
        if($d < $minute * 2) return "about 1 minute ago";
        //if less then hour
        if($d < $hour) return floor($d / $minute) . " minutes ago";
        //if less then 2 hours
        if($d < $hour * 2) return "about 1 hour ago";
        //if less then day
        if($d < $day) return floor($d / $hour) . " hours ago";
        //if more then day, but less then 2 days
        if($d > $day && $d < $day * 2) return "yesterday";
        //if less then year
        if($d < $day * 365) return floor($d / $day) . " days ago";
        //else return more than a year
        return "over a year ago";
    }
}
function trend_setup_shortcode_tweetslider( $params, $content ) {
    extract( shortcode_atts( array(
        'title'         => '', 
        'no'            => 1,
        'animation'     => ''
        ), $params ) );
    global $trend_redux;
    require_once( 'twitter/twitteroauth/twitteroauth.php' );
    # Get Theme Options Twitter Details
    $tw_username            = $trend_redux['trend_social_tw'];
    $consumer_key           = $trend_redux['trend_tw_consumer_key'];
    $consumer_secret        = $trend_redux['trend_tw_consumer_secret'];
    $access_token           = $trend_redux['trend_tw_access_token'];
    $access_token_secret    = $trend_redux['trend_tw_access_token_secret'];
    $no = $no+1;
    # Create the connection
    $twitter = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
    # Migrate over to SSL/TLS
    $twitter->ssl_verifypeer = true;
    # Load the Tweets
    $tweets = $twitter->get('statuses/user_timeline', array('screen_name' => $tw_username, 'exclude_replies' => 'true', 'include_rts' => 'false', 'count' => $no));
    if(!empty($tweets)) {
        $myContent = '';
        $myContent .= '<div class="latest-tweets animateIn" data-animate="'.$animation.'">';
            $myContent .= '<h3 class=""><i class="fa fa-retweet"></i>'.$title.'</h3>';
            $myContent .= '<div class="tweets">';
            foreach($tweets as $tweet) {
                # Access as an object
                $tweetText = $tweet->text;
                $created_at = $tweet->created_at;
                # Make links active
                $tweetText = preg_replace("/(http:\/\/|(www.))(([^s<]{4,68})[^s<]*)/", '', $tweetText);
                # Linkify user mentions
                $tweetText = preg_replace("/@(w+)/", '', $tweetText);
                # Linkify tags
                $tweetText = preg_replace("/#(w+)/", '', $tweetText);
                $myContent .= '<div class="single-tweet">';
                    $myContent .= '<div class="vc_col-md-2">';
                        $myContent .= '<div class="rotate45">';
                            $myContent .= '<i class="fa fa-twitter rotate45_back"></i>';
                        $myContent .= '</div>';
                    $myContent .= '</div>';
                    $myContent .= '<div class="vc_col-md-10">';
                        $myContent .= '<div class="tweet-content">'.$tweetText.'</div>';
                        $myContent .= '<span class="tweet-date">'.trend_twitter_time($created_at).'</span>';
                    $myContent .= '</div>';
                $myContent .= '</div>';
            }
            $myContent .= '</div>';
        $myContent .= '</div>';
        return $myContent;
    }
}
add_shortcode('tweets', 'trend_setup_shortcode_tweetslider');
/*---------------------------------------------*/
/*--- 2. Contact Form ---*/
/*---------------------------------------------*/
function trend_contact_form_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation' => ''
        ), $params ) );
    global $trend_redux;
    if (isset($_POST['contact_me'])) {
        $to = $trend_redux['trend_contact_email'];
        $subject = $_POST['user_subject'];
        $form_user_name = $_POST['user_name'];
        $form_user_email = $_POST['user_email'];
        $form_comment = $_POST['user_message'];
        $message = '';
        $message .= "Subject: " . $subject . "\r\n";
        $message .= "From: " .  $form_user_name . "\r\n";
        $message .= "Email: " . $form_user_email . "\r\n" . "\r\n";
        $message .= $form_comment . "\r\n";
        $headers = 'From: ' . $form_user_name . '<'. $form_user_email . '>';
        if( mail( $to, $subject, $message, $headers ) ) {
            #echo "<p>Your email has been sent! Thank you</p>";
        }
    }
    
    $contact_form = '';
    $contact_form .= '<form method="POST" class="animateIn" id="contact_form" novalidate="novalidate" data-animate="'.$animation.'">';
        #Name
        $contact_form .= '<div class="vc_col-md-4">';
            $contact_form .= '<input type="text" placeholder="'.__('Votre Nom','trend').'" class="form-control" name="user_name">';
        $contact_form .= '</div>';
        #Email
        $contact_form .= '<div class="vc_col-md-4">';
            $contact_form .= '<input type="text" placeholder="'.__('Votre Email','trend').'" class="form-control" name="user_email">';
        $contact_form .= '</div>';
        #Subject
        $contact_form .= '<div class="vc_col-md-4">';
            $contact_form .= '<input type="text" placeholder="'.__('Sujet','trend').'" class="form-control" name="user_subject">';
        $contact_form .= '</div>';
        $contact_form .= '<div class="mt-half-spacer"></div>';
        #Message
        $contact_form .= '<div class="vc_col-md-12">';
            $contact_form .= '<textarea name="user_message" rows="10" placeholder="'.__('Votre Message','trend').'" class="form-control"></textarea>';
        $contact_form .= '</div>';
        $contact_form .= '<div class="mt-half-spacer"></div>';
        #Submit button
        $contact_form .= '<div class="vc_col-md-12">';
            $contact_form .= '<input type="submit" class="solid-button button form-control" value="Send Now" name="contact_me">';
            $contact_form .= '<p class="success_message">'.__('Thank you! We\'ll get back to you as soon as possible.','trend').'</p>';
        $contact_form .= '</div>';
    $contact_form .= '</form>';
    return $contact_form;
}
add_shortcode('contact_form', 'trend_contact_form_shortcode');

/*---------------------------------------------*/
/*--- 4. Recent Posts ---*/
/*---------------------------------------------*/
function trend_posts_calendar_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation'     => '',
            'title'     => '',
            'number'    => ''
        ), $params ) );
    $posts_calendar = '';
    $posts_calendar .= '<div class="latest-posts animateIn" data-animate="'.$animation.'">';
        $posts_calendar .= '<h3 class=""><i class="fa fa-calendar"></i>'.$title.'</h3>';
        $args_recenposts = array(
                'posts_per_page'   => $number,
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_type'        => 'post',
                'post_status'      => 'publish' 
                ); 
        $recentposts = get_posts($args_recenposts);
        foreach ($recentposts as $post) {
            #Content
            $content_post = get_post($post->ID);
            $content = $content_post->post_content;
            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]&gt;', $content);
            #Author
            $post_author_id = get_post_field( 'post_author', $post->ID );
            $user_info = get_userdata($post_author_id);
            $posts_calendar .= '<div class="single-post">';
                $posts_calendar .= '<div class="vc_col-md-3 text-center">';
                    $posts_calendar .= '<div class="row post-date-month">'.get_the_date('M', $post->ID).'</div>';
                    $posts_calendar .= '<div class="row post-date-day">'.get_the_date('j', $post->ID).'</div>';
                $posts_calendar .= '</div>';
                $posts_calendar .= '<div class="vc_col-md-9 post-description">';
                    $posts_calendar .= '<div class="post-name">';
                        $posts_calendar .= '<a href="'. get_permalink($post->ID) .'">'. $post->post_title .'</a>';
                    $posts_calendar .= '</div>';
                    $posts_calendar .= '<div class="post-details">'.get_the_date('F j, Y', $post->ID).'</div>';
                $posts_calendar .= '</div>';
                $posts_calendar .= '<div class="clearfix"></div>';
            $posts_calendar .= '</div>';
        }
        $posts_calendar .= '</div>';
    return $posts_calendar;
}
add_shortcode('posts_calendar', 'trend_posts_calendar_shortcode');
/*---------------------------------------------*/
/*--- 5. Featured Post with thumbnail ---*/
/*---------------------------------------------*/
function trend_featured_post_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation'      => '',
            'icon'      => '',
            'postid'    => '',
            'title'     => ''
        ), $params ) );
    $featured_post = '';
    #Content
    $content_post = get_post($postid);
    $content = $content_post->post_content;
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    #Author
    $post_author_id = get_post_field( 'post_author', $postid );
    $user_info = get_userdata($post_author_id);
    $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ),'trend_featured_post_pic500x230' );
    $featured_post .= '<div class="latest-videos animateIn" data-animate="'.$animation.'">';
        $featured_post .= '<h3 class=""><i class="'.$icon.'"></i>'.$title.'</h3>';
        $featured_post .= '<a href="'.get_permalink( $postid ).'">';
            if($thumbnail_src) { $featured_post .= '<img class="img-responsive" src="'. $thumbnail_src[0] . '" alt="" />';
            }else{ $featured_post .= '<img class="img-responsive" src="http://placehold.it/500x230" alt="" />'; }
        $featured_post .= '</a>';
        $featured_post .= '<div class="video-title">';
            $featured_post .= '<a href="'.get_permalink( $postid ).'">'.get_the_title( $postid ).'</a>';
            $featured_post .= '<span class="post-date"><i class="fa fa-calendar"></i>'.get_the_date('', $postid ).'</span>';
            $featured_post .= '</div>';
        $featured_post .= '<div class="video-excerpt">'.trend_excerpt_limit($content,20).'</div>';
    $featured_post .= '</div>';
    return $featured_post;
}
add_shortcode('featured_post', 'trend_featured_post_shortcode');
/*---------------------------------------------*/
/*--- 6. Testimonials ---*/
/*---------------------------------------------*/
function trend_testimonials_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation'                 =>'',
            'number'                    =>'',
            'testimonial_border_color'  =>'',
            'visible_items'             =>''
        ), $params ) );
    $myContent = '';
    $myContent .= '<style type="text/css" scoped>
        .testimonial-img-holder .testimonial-img {
            border-color: '.$testimonial_border_color.' !important;
        }
    </style>';
    $myContent .= '<div class="vc_row">';
        $myContent .= '<div data-animate="'.$animation.'" class="testimonials-container-'.$visible_items.' owl-carousel owl-theme animateIn">';
        $args_testimonials = array(
                'posts_per_page'   => $number,
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_type'        => 'testimonial',
                'post_status'      => 'publish' 
                ); 
        $testimonials = get_posts($args_testimonials);
            foreach ($testimonials as $testimonial) {
                #metaboxes
                $metabox_job_position = get_post_meta( $testimonial->ID, 'job-position', true );
                $metabox_company = get_post_meta( $testimonial->ID, 'company', true );
                $testimonial_id = $testimonial->ID;
                $content_post   = get_post($testimonial_id);
                $content        = $content_post->post_content;
                $content        = apply_filters('the_content', $content);
                $content        = str_replace(']]>', ']]&gt;', $content);
                #thumbnail
                $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $testimonial->ID ),'av_latest_testimonials' );
                
                $myContent .= '<div class="item vc_col-md-12">';
                    $myContent .= '<div class="text-left">';
                        $myContent .= '<div class="testimonial-img-holder pull-left">';
                            $myContent .= '<div class="testimonial-img">';
                            if($thumbnail_src) { $myContent .= '<img src="'. $thumbnail_src[0] . '" alt="'. $testimonial->post_title .'" />';
                            }else{ $myContent .= '<img src="http://placehold.it/110x110" alt="'. $testimonial->post_title .'" />'; }
                            $myContent .= '</div>';
                        $myContent .= '</div>';
                        $myContent .= '<div class="testimonial-author-job">';
                            $myContent .= '<h4><strong>'. $testimonial->post_title .'</strong>, '. $metabox_company .'</h4>';
                        $myContent .= '</div>';
                    $myContent .= '</div>';
                    $myContent .= '<div class="clearfix"></div>';
                    $myContent .= '<div class="testimonail-content">'.$content.'</div>';
                $myContent .= '</div>';
            }
        $myContent .= '</div>';
    $myContent .= '</div>';
    return $myContent;
}
add_shortcode('testimonials', 'trend_testimonials_shortcode');
/*---------------------------------------------*/
/*--- 7. Subscribe form ---*/
/*---------------------------------------------*/
function trend_subscribe_form($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation'                  => '',
            'placeholder'                => '',
            'button_text'                => ''
        ), $params ) );


if (isset($_POST['mailchimp_email'])) {

    #Global variable - REDUX FRAMEWORK
    global $trend_redux;

    
    $apiKey         = $trend_redux['trend_mailchimp_apikey'];
    $listId         = $trend_redux['trend_mailchimp_listid'];
    $double_optin   = false;
    $send_welcome   = false;
    $email_type     = 'html';
    $email          = $_POST['mailchimp_email'];
    //replace us2 with your actual datacenter
    $submit_url = "http://" . $trend_redux['trend_mailchimp_data_center'] . ".api.mailchimp.com/1.3/?method=listSubscribe";
    $data = array(
        'email_address' => $email,
        'apikey'        => $apiKey,
        'id'            => $listId,
        'double_optin'  => $double_optin,
        'send_welcome'  => $send_welcome,
        'email_type'    => $email_type
    );
    $payload = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $submit_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
    $result = curl_exec($ch);
    curl_close ($ch);
    $data = json_decode($result);
    if ($data->error){
        echo esc_attr($data->error);
    } else {
        echo esc_attr__('Got it, you\'ve been added to our email list.', 'trend');
    }
}


    $service = '';

    $service .= '<div class="mc_embed_signup animateIn" data-animate="'.$animation.'">';
        $service .= '<div class="email">';
            $service .= '<form class="subscribe" method="POST">';
                $service .= '<input type="text" placeholder="'.$placeholder.'" name="mailchimp_email" class="emaddress" data-validate="validate(required, email)"/>';
                $service .= '<button name="submit_mailchimp" type="submit">'.$button_text.'</button>';
                $service .= '<span class="result section-description"></span>';
            $service .= '</form>';
        $service .= '</div>';
    $service .= '</div>';
    return $service;
}
add_shortcode('subscribe_form', 'trend_subscribe_form');



/*---------------------------------------------*/
/*--- 7. Subscribe form ---*/
/*---------------------------------------------*/
function trend_subscribe_form2($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation' => '',
            'placeholder' => '',
            'infotitle' => '',
            'newsletter_title' => '',
            'infosubtitle' => '',
            'email_box_background'       => '',
            'button_background'          => '',
            'button_hover_background'    => '',
            'button_text' => ''
        ), $params ) );


if (isset($_POST['mailchimp_email'])) {

    #Global variable - REDUX FRAMEWORK
    global $trend_redux;

    
    $apiKey         = $trend_redux['trend_mailchimp_apikey'];
    $listId         = $trend_redux['trend_mailchimp_listid'];
    $double_optin   = false;
    $send_welcome   = false;
    $email_type     = 'html';
    $email          = $_POST['mailchimp_email'];
    //replace us2 with your actual datacenter
    $submit_url = "http://" . $trend_redux['trend_mailchimp_data_center'] . ".api.mailchimp.com/1.3/?method=listSubscribe";
    $data = array(
        'email_address' => $email,
        'apikey'        => $apiKey,
        'id'            => $listId,
        'double_optin'  => $double_optin,
        'send_welcome'  => $send_welcome,
        'email_type'    => $email_type
    );
    $payload = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $submit_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
    $result = curl_exec($ch);
    curl_close ($ch);
    $data = json_decode($result);
    if ($data->error){
        echo esc_attr($data->error);
    } else {
        echo esc_attr__('Got it, you\'ve been added to our email list.', 'trend');
    }
}


    $service = '';
    $service .= '<style type="text/css" scoped>
        .mc_embed_signup .newspaper-info {
            background: '.$email_box_background.'!important;
        }
        .mc_embed_signup .subscribe button {
           background: '.$button_background.'!important;
        }
        .mc_embed_signup .subscribe button:hover {
           background: '.$button_hover_background.'!important;
        }
    </style>';
    $service .= '<div class="mc_embed_signup animateIn complex-layout" data-animate="'.$animation.'">';
        $service .= '<div class="email">';
            $service .= '<div class="col-md-9">';
                $service .= '<form class="subscribe">';
                    $service .= '<H3><i class="fa fa-envelope-o"></i>'.$newsletter_title.'</H3>';
                    $service .= '<input type="text" placeholder="'.$placeholder.'" name="mailchimp_email" class="emaddress" data-validate="validate(required, email)"/>';
                    $service .= '<button name="submit_mailchimp" type="submit">'.$button_text.'</button>';
                    $service .= '<span class="result section-description"></span>';
                $service .= '</form>';
            $service .= '</div>';
            $service .= '<div class="col-md-3 newspaper-info">';
                $service .= '<div class="newspaper-info-bordered">';
                    $service .= '<div class="row">';
                        $service .= '<div class="col-md-7"><div class="holder"><span>'.$infotitle.'</span><span>'.$infosubtitle.'</span></div></div>';
                        $service .= '<div class="col-md-5"><i class="fa fa-envelope-o"></i></div>';
                    $service .= '</div>';
                $service .= '</div>';
            $service .= '</div>';
        $service .= '</div>';
    $service .= '</div>';
    return $service;
}
add_shortcode('subscribe_form2', 'trend_subscribe_form2');
/*---------------------------------------------*/
/*--- 8. Services style 1 ---*/
/*---------------------------------------------*/
function trend_service_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'icon'          => '', 
            'title'         => '', 
            'description'   => '',
            'animation'     => ''
        ), $params ) );
    $service = '';
    $service .= '<div class="block-container animateIn" data-animate="'.$animation.'">';
        $service .= '<div class="block-icon">';
            $service .= '<div class="block-triangle">';
                $service .= '<div data-angle="SE" class="flat-icon">';
                    $service .= '<i class="'.$icon.'"></i>';
                $service .= '</div>';
            $service .= '</div>';
        $service .= '</div>';
        $service .= '<div class="block-title">';
            $service .= '<p>'.$title.'</p>';
        $service .= '</div>';
        $service .= '<div class="block-content">';
            $service .= '<p>'.$description.'</p>';
        $service .= '</div>';
    $service .= '</div>';
    return $service;
}
add_shortcode('service', 'trend_service_shortcode');
/*---------------------------------------------*/
/*--- 9. Services style 2 ---*/
/*---------------------------------------------*/
function trend_service_style2_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'icon'          => '', 
            'title'         => '', 
            'description'   => '',
            'animation'     => ''
        ), $params ) );
    $service = '';
    $service .= '<div class="left-block-container animateIn" data-animate="'.$animation.'">';
        $service .= '<div class="block-icon vc_col-md-2">';
            $service .= '<div class="block-triangle">';
                $service .= '<div data-angle="SE" class="flat-icon">';
                    $service .= '<i class="'.$icon.'"></i>';
                $service .= '</div>';
            $service .= '</div>';
        $service .= '</div>';
        $service .= '<div class="vc_col-md-9 vc_col-md-offset-1">';
            $service .= '<div class="block-title">';
                $service .= '<p>'.$title.'</p>';
            $service .= '</div>';
            $service .= '<div class="block-content">';
                $service .= '<p>'.$description.'</p>';
            $service .= '</div>';
        $service .= '</div>';
        $service .= '<div class="clearfix"></div>';
    $service .= '</div>';
    return $service;
}
add_shortcode('service_style2', 'trend_service_style2_shortcode');

/*---------------------------------------------*/
/*--- 11. Recent testimonials ---*/
/*---------------------------------------------*/
function trend_testimonials2_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'number'=>'',
            'animation'=>''
        ), $params ) );
        $args_recenposts = array(
                'posts_per_page'   => $number,
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_type'        => 'testimonial',
                'post_status'      => 'publish' 
                );
        $recentposts = get_posts($args_recenposts);
        $content  = "";
        $content .= '<div class="testimonials_slider owl-carousel owl-theme animateIn" data-animate="'.$animation.'">';
        foreach ($recentposts as $post) {
            $job_position = get_post_meta( $post->ID, 'job-position', true );
            $content .= '<div class="item">';
                $content .= '<div class="testimonial-content relative">';
                    $content .= '<span>'.get_post_field('post_content', $post->ID).'</span>';
                    $content .= '<div class="testimonial-client-details">';
                        $content .= '<div class="testimonial-name">'.$post->post_title.'</div>';
                        $content .= '<div class="testimonial-job">'.$job_position.'</div>';
                    $content .= '</div>';
                $content .= '</div>';
            $content .= '</div>';
        }
        $content .= '</div>';
        return $content;
}
add_shortcode('testimonials-style2', 'trend_testimonials2_shortcode');
/*---------------------------------------------*/
/*--- 12. Skill ---*/
/*---------------------------------------------*/
function trend_skills_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation'          => '', 
            'icon'          => '', 
            'title'         => '',
            'skillvalue'    => '',
            'has_border'    => ''
        ), $params ) );
    $skill = '';
    $skill .= '<div class="stats-block statistics '.$has_border.' animateIn" data-animate="'.$animation.'">';
        $skill .= '<div class="stats-head">';
            $skill .= '<p class="stat-number skill percentage" data-perc="'.$skillvalue.'">';
                $skill .= '<i class="'.$icon.'"></i>';
                $skill .= '<span class="skill-count">'.$skillvalue.'</span>';
            $skill .= '</p>';
        $skill .= '</div>';
        $skill .= '<div class="stats-content">';
            $skill .= '<p>'.$title.'</p>';
        $skill .= '</div>';
    $skill .= '</div>';
    return $skill;
}
add_shortcode('skill', 'trend_skills_shortcode');
/*---------------------------------------------*/
/*--- 13. Google map ---*/
/*---------------------------------------------*/
function trend_gmap_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation' => '', 
            'latitude'  => '', 
            'longitude' => ''
        ), $params ) );

    global $trend_redux;
    $maker = $trend_redux['trend_map_maker']['url'];
    $content = '';
    $content .= '<section id="cd-google-map" data-animate="'.$animation.'" class="animateIn">';
        $content .= '<input class="latitude" type="hidden" value="'.$latitude.'">';
        $content .= '<input class="longitude" type="hidden" value="'.$longitude.'">';
        $content .= '<input class="pin_point_maker" type="hidden" value="'.$maker.'">';
        $content .= '<div id="google-container"></div>';
        $content .= '<div id="cd-zoom-in"></div>';
        $content .= '<div id="cd-zoom-out"></div>';
    $content .= '</section>';
    return $content;
}
add_shortcode('map', 'trend_gmap_shortcode');
/*---------------------------------------------*/
/*--- 14. Pricing tables ---*/
/*---------------------------------------------*/
function trend_pricing_table_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'package_currency'  => '',
            'package_price'     => '',
            'package_name'      => '',
            'package_basis'     => '',
            'package_feature1'  => '',
            'package_feature2'  => '',
            'package_feature3'  => '',
            'package_feature4'  => '',
            'package_feature5'  => '',
            'package_feature6'  => '',
            'animation'         => '',
            'button_url'        => '',
            'recommended'       => '',
            'button_text'       => ''
        ), $params ) );
    $pricing_table = '';
    $pricing_table .= '<div class="pricing-table animateIn '.$recommended.'" data-animate="'.$animation.'">';
        $pricing_table .= '<div class="triangle-container">';
            $pricing_table .= '<div class="block-triangle">';
                $pricing_table .= '<div class="triangle-content">';
                    $pricing_table .= '<p class="text-center">';
                        $pricing_table .= '<small>'.$package_currency.'</small><span class="price">'.$package_price.'</span>';
                    $pricing_table .= '</p>';
                    $pricing_table .= '<p class="sub text-center">'.$package_basis.'</p>';
                $pricing_table .= '</div>';
            $pricing_table .= '</div>';
        $pricing_table .= '</div>';
        $pricing_table .= '<div class="table-content">';
            $pricing_table .= '<h2 class="text-center">'.$package_name.'</h2>';
            $pricing_table .= '<ul class="text-center">';
                $pricing_table .= '<li>'.$package_feature1.'</li>';
                $pricing_table .= '<li>'.$package_feature2.'</li>';
                $pricing_table .= '<li>'.$package_feature3.'</li>';
                $pricing_table .= '<li>'.$package_feature4.'</li>';
                $pricing_table .= '<li>'.$package_feature5.'</li>';
                $pricing_table .= '<li>'.$package_feature6.'</li>';
            $pricing_table .= '</ul>';
            $pricing_table .= '<div class="button-holder text-center">';
                $pricing_table .= '<a href="'.$button_url.'" class="solid-button button">'.$button_text.'</a>';
            $pricing_table .= '</div>';
        $pricing_table .= '</div>';
    $pricing_table .= '</div>';
    return $pricing_table;
}
add_shortcode('pricing-table', 'trend_pricing_table_shortcode');
/*---------------------------------------------*/
/*--- 15. Jumbotron ---*/
/*---------------------------------------------*/
function trend_jumbotron_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'heading'       => '', 
            'sub_heading'   => '', 
            'button_text'   => '',
            'button_url'    => '',
            'animation'    => ''
        ), $params ) ); 
    $content = '';
    $content .= '<div class="jumbotron animateIn" data-animate="'.$animation.'">';
        $content .= '<h1>'.$heading.'</h1>';
        $content .= '<p>'.$sub_heading.'</p>';
        $content .= '<p><a role="button" href="'.$button_url.'" class="btn btn-primary btn-lg">'.$button_text.'</a></p>';
    $content .= '</div>';
    return $content;
}
add_shortcode('jumbotron', 'trend_jumbotron_shortcode');
/*---------------------------------------------*/
/*--- 16. Alert ---*/
/*---------------------------------------------*/
function trend_alert_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'alert_style'           => '', 
            'alert_dismissible'     => '', // yes/no
            'alert_text'            => '',
            'animation'            => ''
        ), $params ) );
    $content = '';
    $content .= '<div role="alert" class="alert alert-'.$alert_style.' animateIn" data-animate="'.$animation.'">';
        if ($alert_dismissible == 'yes') {
            $content .= '<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>';
        }
        $content .= $alert_text;
    $content .= '</div>';
    return $content;
}
add_shortcode('alert', 'trend_alert_shortcode');
/*---------------------------------------------*/
/*--- 17. Progress bars ---*/
/*---------------------------------------------*/
function trend_progress_bar_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'bar_scope'  => '', // success/info/warning/danger
            'bar_style'  => '', // normal/progress-bar-striped
            'bar_label'  => '', // optional
            'bar_value'  => '',
            'animation'  => ''
        ), $params ) );
    $content = '';
    $content .= '<div class="animateIn progress" data-animate="'.$animation.'" >';
        $content .= '<div class="progress-bar progress-bar-'.$bar_scope . ' ' . $bar_style.'" role="progressbar" aria-valuenow="'.$bar_value.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$bar_value.'%">';
            if(!isset($bar_label)){
                $content .= '<span class="sr-only">'.$bar_label.'</span>.';
            }else{ 
                $content .= $bar_label;
            }
        $content .= '</div>';
    $content .= '</div>';
    return $content;
}
add_shortcode('progress_bar', 'trend_progress_bar_shortcode');
/*---------------------------------------------*/
/*--- 18. Custom content ---*/
/*---------------------------------------------*/
function trend_panel_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'panel_style'    => '', // success/info/warning/danger
            'panel_title'    => '', 
            'panel_content'  => '',
            'animation'  => ''
        ), $params ) ); ?>
    <div class="panel animateIn panel-<?php echo esc_attr($panel_style); ?>" data-animate="<?php echo esc_attr($animation); ?>">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo esc_attr($panel_title); ?></h3>
        </div>
        <div class="panel-body">
            <?php echo esc_attr($panel_content); ?>
        </div>
    </div>
    
<?php }
add_shortcode('panel', 'trend_panel_shortcode');
/*---------------------------------------------*/
/*--- 20. Heading With Border ---*/
/*---------------------------------------------*/
function trend_heading_with_border( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'align'       => 'left',
            'animation'   => ''
        ), $params ) );
    $content = do_shortcode($content);
    echo '<h2 data-animate="'.$animation.'" class="'.$align.'-border animateIn">'.$content.'</h2>';
}
add_shortcode('heading-border', 'trend_heading_with_border');
/*---------------------------------------------*/
/*--- 21. Testimonials ---*/
/*---------------------------------------------*/
function trend_clients_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation'=>'',
            'number'=>''
        ), $params ) );
    $myContent = '';
    $myContent .= '<div data-animate="'.$animation.'" class="clients-container animateIn owl-carousel owl-theme ">';
    $args_clients = array(
            'posts_per_page'   => $number,
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_type'        => 'client',
            'post_status'      => 'publish' 
            ); 
    $clients = get_posts($args_clients);
        foreach ($clients as $client) {
            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $client->ID ),'full' );
            
            $myContent .= '<div class="item">';
                if($thumbnail_src) { $myContent .= '<img src="'. $thumbnail_src[0] . '" alt="'. $client->post_title .'" />';
                }else{ $myContent .= '<img src="http://placehold.it/110x110" alt="'. $client->post_title .'" />'; }
            $myContent .= '</div>';
        }
    $myContent .= '</div>';
    return $myContent;
}
add_shortcode('clients', 'trend_clients_shortcode');
/*---------------------------------------------*/
/*--- 22. List group ---*/
/*---------------------------------------------*/
function trend_list_group_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'heading'       => '',
            'description'   => '',
            'active'        => '',
            'animation'     => ''
        ), $params ) ); 
    $content = '';
    $content .= '<a href="#" class="list-group-item '.$active.' animateIn" data-animate="'.$animation.'">';
        $content .= '<h4 class="list-group-item-heading">'.$heading.'</h4>';
        $content .= '<p class="list-group-item-text">'.$description.'</p>';
    $content .= '</a>';
    return $content;
}
add_shortcode('list_group', 'trend_list_group_shortcode');

function trend_btn_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'btn_text'      => '',
            'btn_url'       => '',
            'btn_size'      => '',
            'align'      => ''
        ), $params ) ); 
    $content = '';
    $content .= '<div class="'.$align.'">';
    $content .= '<a href="'.$btn_url.'" class="button-winona '.$btn_size.'">'.$btn_text.'</a>';
    $content .= '</div>';
    return $content;
}
add_shortcode('trend_btn', 'trend_btn_shortcode');
/*---------------------------------------------*/
/*--- 23. Thumbnails custom content ---*/
/*---------------------------------------------*/
function trend_thumbnails_custom_content_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'image'         => '',
            'heading'       => '',
            'description'   => '',
            'active'        => '',
            'button_url'    => '',
            'button_text'   => '',
            'animation'     => ''
        ), $params ) ); 
    $thumb      = wp_get_attachment_image_src($image, "large");
    $thumb_src  = $thumb[0]; 
    $content = '';
    $content .= '<div class="thumbnail animateIn" data-animate="'.$animation.'">';
        $content .= '<img data-holder-rendered="true" src="'.$thumb_src.'" data-src="'.$thumb_src.'" alt="'.$heading.'">';
        $content .= '<div class="caption">';
            if (!empty($heading)) {
                $content .= '<h3>'.$heading.'</h3>';  
            }
            if (!empty($description)) {
                $content .= '<p>'.$description.'</p>';
            }
            if (!empty($button_text)) {
                $content .= '<p><a href="'.$button_url.'" class="btn btn-primary" role="button">'.$button_text.'</a></p>';
            }
        $content .= '</div>';
    $content .= '</div>';
    return $content;
}
add_shortcode('thumbnails_custom_content', 'trend_thumbnails_custom_content_shortcode');
/*---------------------------------------------*/
/*--- 24. Section heading with title and subtitle ---*/
/*---------------------------------------------*/
function trend_heading_title_subtitle_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'title'         => '',
            'subtitle'      => ''
        ), $params ) ); 
    $content = '<div class="title-subtile-holder">';
    $content .= '<h1 class="section-title">'.$title.'</h1>';
    $content .= '<div class="section-border"></div>';
    $content .= '<div class="section-subtitle">'.$subtitle.'</div>';
    $content .= '</div>';
    return $content;
}
add_shortcode('heading_title_subtitle', 'trend_heading_title_subtitle_shortcode');
/*---------------------------------------------*/
/*--- 25. Heading with bottom border ---*/
/*---------------------------------------------*/
function trend_heanding_bottom_border_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'heading'    => '',
            'text_align' => ''
        ), $params ) );
    $content = '<h2 class="heading-bottom '.$text_align.'">'.$heading.'</h2>';
    return $content;
}
add_shortcode('heading_border_bottom', 'trend_heanding_bottom_border_shortcode');
/*---------------------------------------------*/
/*--- 26. Portfolio square ---*/
/*---------------------------------------------*/
function trend_portfolio_sqare_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'number'       => ''
           ), $params ) 
        );

    $args = array(
        'posts_per_page'   => $number,
        'post_type'        => 'portfolio',
        'post_status'      => 'publish',
    );
    $posts = new WP_Query( $args );
    $content = '<div class="portfolio-overlay"></div>';
    $content = '<div class="blog-posts portfolio-posts portfolio-shortcode quick-view-items">';
    foreach ( $posts->posts as $portfolio ) {
        
        $project_url = get_post_meta( $portfolio->ID, 'av-project-url', true );
        $project_skills = get_post_meta( $portfolio->ID, 'av-project-category', true );
        $excerpt = get_post_field( 'post_content', $portfolio->ID );
        $thumbnail_src      = wp_get_attachment_image_src( get_post_thumbnail_id( $portfolio->ID ), 'trend_portfolio_pic700x450' );
        $content .= '<article id="post-'.$portfolio->ID.'" class="vc_col-md-4 single-portfolio-item trend-item relative portfolio">';
        
        if($thumbnail_src) { 
            $content .= '<img src="'. $thumbnail_src[0] . '" alt="'.$portfolio->post_title.'" />';
        }else{ 
            $content .= '<img src="http://placehold.it/700x450" alt="'.$portfolio->post_title.'" />'; 
        }
            $content .= '<div class="item-description absolute">';
                $content .= '<div class="holder-top">';
                    $content .= '<a class="trend-trigger" href="#"><i class="fa fa-expand"></i></a>';
                    $content .= '<a href="'.get_the_permalink($portfolio->ID).'"><i class="fa fa-plus"></i></a>';
                $content .= '</div>';
                $content .= '<div class="holder-bottom">';
                    $content .= '<h3>'.$portfolio->post_title.'</h3>';
                    $content .= '<h5>'.$project_skills.'</h5>';
                $content .= '</div>';
            $content .= '</div>';



            $content .= '<div class="trend-quick-view portfolio-shortcode high-padding post-'.$portfolio->ID.'">';
                $content .= '<div class="trend-slider-wrapper">';
                    $content .= '<ul class="trend-slider">';
                        if($thumbnail_src) { 
                            $content .= '<li class="selected single-slide"><img class="portfolio-item-img" src="'. $thumbnail_src[0] . '" alt="'.$portfolio->post_title.'" /></li>';
                        }
                        if( class_exists('Dynamic_Featured_Image') ) {
                            global $dynamic_featured_image;
                            $featured_images = $dynamic_featured_image->get_featured_images($portfolio->ID);

                            $i = 0;
                            foreach ($featured_images as $row=>$innerArray) {
                                $id = $featured_images[$i]['attachment_id'];
                                $mediumSizedImage = $dynamic_featured_image->get_image_url($id,'trend_portfolio_pic700x450'); 
                                $caption = $dynamic_featured_image->get_image_caption( $mediumSizedImage );
                                $content .= '<li class="single-slide"><img src="'.$mediumSizedImage.'" alt="'.$caption.'"></li>';
                                $i++;
                            }
                        }            
                    $content .= '</ul>';
                    $content .= '<ul class="trend-slider-navigation">';
                        $content .= '<li><a class="trend-next" href="#0"><i class="fa fa-angle-left"></i></a></li>';
                        $content .= '<li><a class="trend-prev" href="#0"><i class="fa fa-angle-right"></i></a></li>';
                    $content .= '</ul>';
                $content .= '</div>';

                $content .= '<div class="trend-item-info col-md-5">';
                    $content .= '<h2 class="heading-bottom top">'.$portfolio->post_title.'</h2>';
                    $content .= '<div class="desc">'.get_post_field('post_content', $portfolio->ID).'</div>';

                    $content .= '<div class="portfolio-details">';
                        $content .= '<div class="vc_row">';
                            $content .= '<div class="vc_col-md-4 portfolio_label">'.esc_attr__('Customer:', 'trend').'</div>';
                            $content .= '<div class="vc_col-md-8 portfolio_label_value">'.get_the_author().'</div>';
                        $content .= '</div>';
                        $content .= '<div class="vc_row">';
                            $content .= '<div class="vc_col-md-4 portfolio_label">'.esc_attr__('Live demo:', 'trend').'</div>';
                            $content .= '<div class="vc_col-md-8 portfolio_label_value">'.$project_url.'</div>';
                        $content .= '</div>';
                        $content .= '<div class="vc_row">';
                            $content .= '<div class="vc_col-md-4 portfolio_label">'.esc_attr__('Skills:', 'trend').'</div>';
                            $content .= '<div class="vc_col-md-8 portfolio_label_value">'.$project_skills.'</div>';
                        $content .= '</div>';
                        $content .= '<div class="vc_row">';
                            $content .= '<div class="vc_col-md-4 portfolio_label">'.esc_attr__('Date post:', 'trend').'</div>';
                            $content .= '<div class="vc_col-md-8 portfolio_label_value">'.get_the_date().'</div>';
                        $content .= '</div>';
                    $content .= '</div>';
                    $content .= '<a href="'.get_the_permalink($portfolio->ID).'" class="vc_btn vc_btn-blue">More details</a>';
                $content .= '</div>';
                $content .= '<a href="#0" class="trend-close"><i class="fa fa-times"></i></a>';
            $content .= '</div>';
        $content .= '</article>';
    }
    $content .= '<div class="clearfix"></div>';
    $content .= '<div class="portfolio-overlay"></div>';
    $content .= '</div>';
    return $content;
}
add_shortcode('portfolio-square', 'trend_portfolio_sqare_shortcode');
/*---------------------------------------------*/
/*--- 27. Call to action ---*/
/*---------------------------------------------*/
function trend_call_to_action_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'heading'       => '',
            'heading_type'  => '',
            'subheading'    => '',
            'align'         => '',
            'button_text'   => '',
            'url'           => ''
        ), $params ) );
    $shortcode_content = '<div class="trend_call-to-action">';
    $shortcode_content .= '<div class="vc_col-md-12">';
    $shortcode_content .= '<'.$heading_type.' class="'.$align.'">'.$heading.'</'.$heading_type.'>';
    $shortcode_content .= '<p class="'.$align.'">'.$subheading.'</p>';
    $shortcode_content .= '</div>';
    $shortcode_content .= '<div class="clearfix"></div>';
    $shortcode_content .= '</div>';
    return $shortcode_content;
}
add_shortcode('trend-call-to-action', 'trend_call_to_action_shortcode');


/*---------------------------------------------*/
/*--- 27. Call to action ---*/
/*---------------------------------------------*/
function trend_shop_feature_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'heading'       => '',
            'subheading'    => '',
            'icon'          => ''
        ), $params ) );

    $shortcode_content = '<div class="shop_feature">';
        $shortcode_content .= '<div class="pull-left shop_feature_icon">';
            $shortcode_content .= '<i class="'.$icon.'"></i>';
        $shortcode_content .= '</div>';
        $shortcode_content .= '<div class="pull-left shop_feature_description">';
            $shortcode_content .= '<h4>'.$heading.'</h4>';
            $shortcode_content .= '<p>'.$subheading.'</p>';
        $shortcode_content .= '</div>';
    $shortcode_content .= '</div>';
    return $shortcode_content;
}
add_shortcode('shop-feature', 'trend_shop_feature_shortcode');


/*---------------------------------------------*/
/*--- Woocommerce Categories with thumbnails ---*/
/*---------------------------------------------*/

function trend_shop_categories_with_thumbnails_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'number'                               => '',
            'category'                             => '',
            'number_of_products_by_category'       => '',
            'number_of_columns'                    => '',
            'hide_empty'                           => ''
        ), $params ) );

    $cat = get_term_by( 'slug', $category, 'product_cat' );

    if ($cat) {
        $prod_categories = get_terms( 'product_cat', array(
            'number'        => $number,
            'child_of'      => $cat->term_id,
            'hide_empty'    => $hide_empty,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $category
                )
            )
        ));
    }else{
        $prod_categories = get_terms( 'product_cat', array(
            'number'        => $number,
            'hide_empty'    => $hide_empty,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $category
                )
            )
        )); 
    }

    $shortcode_content = '';
    $shortcode_content .= '<div class="woocommerce_categories">';
        $shortcode_content .= '<div class="categories categories_shortcode categories_shortcode_'.$number_of_columns.' owl-carousel owl-theme">';
        foreach( $prod_categories as $prod_cat ) {
            if ( class_exists( 'WooCommerce' ) ) {
                $cat_thumb_id   = get_term_meta( $prod_cat->term_id, 'thumbnail_id', true );
            } else {
                $cat_thumb_id = '';
            }
            $cat_thumb_url  = wp_get_attachment_image_src( $cat_thumb_id, 'pic100x75' );
            $term_link      = get_term_link( $prod_cat, 'product_cat' );

            $shortcode_content .= '<div class="category item ">';
                $shortcode_content .= '<a class="#categoryid_'.$prod_cat->term_id.'">';
                    $shortcode_content .= '<img src="'.$cat_thumb_url[0].'" alt="'.$prod_cat->name.'" />';
                $shortcode_content .= '</a>';
                $shortcode_content .= '<h5>'.$prod_cat->name.'</h5>';
            $shortcode_content .= '</div>';
        }
        $shortcode_content .= '</div>';

        $shortcode_content .= '<div class="products_category">';
            foreach( $prod_categories as $prod_cat ) {
                    $shortcode_content .= '<div id="categoryid_'.$prod_cat->term_id.'" class="products_by_category '.$prod_cat->name.'">'.do_shortcode('[product_category columns="'.$number_of_columns.'" per_page="'.$number_of_products_by_category.'" category="'.$prod_cat->name.'"]').'</div>';
            }
        $shortcode_content .= '</div>';
    $shortcode_content .= '</div>';




    wp_reset_postdata();

    return $shortcode_content;
}
add_shortcode('shop-categories-with-thumbnails', 'trend_shop_categories_with_thumbnails_shortcode');



/*---------------------------------------------*/
/*--- Masonry Banners ---*/
/*---------------------------------------------*/
function trend_shop_masonry_banners_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'default_skin_background_color'      => '',
            'dark_skin_background_color'         => '',
            'banner_1_img'                       => '',
            'banner_1_title'                     => '',
            'banner_1_url'                       => '',
            'banner_2_img'                       => '',
            'banner_2_title'                     => '',
            'banner_2_url'                       => '',
            'banner_3_img'                       => '',
            'banner_3_title'                     => '',
            'banner_3_url'                       => '',
            'banner_4_img'                       => '',
            'banner_4_title'                     => '',
            'banner_4_url'                       => ''
        ), $params ) );

    
    
    $shortcode_content = '';

    $shortcode_content .= '<style type="text/css" scoped>
        .masonry_banner.masonry_banner.default-skin {
            background-color: '.$default_skin_background_color.'!important;
        }
        .masonry_banner.masonry_banner.dark-skin {
            background-color: '.$dark_skin_background_color.'!important;
        }
    </style>';
    $shortcode_content .= '<div class="masonry_banners banners_column">';

        $img1 = wp_get_attachment_image_src($banner_1_img, "large");
        $img2 = wp_get_attachment_image_src($banner_2_img, "large");
        $img3 = wp_get_attachment_image_src($banner_3_img, "large");
        $img4 = wp_get_attachment_image_src($banner_4_img, "large");

        $shortcode_content .= '<div class="vc_col-md-6">';
            #IMG #1
            $shortcode_content .= '<div class="masonry_banner default-skin">';
                $shortcode_content .= '<a href="'.$banner_1_url.'" class="relative">';
                    $shortcode_content .= '<img src="'.$img1[0].'" alt="'.$banner_1_title.'" />';
                    $shortcode_content .= '<div class="masonry_holder">';
                        $shortcode_content .= '<h3 class="category_name">'.$banner_1_title.'</h3>';
                        $shortcode_content .= '<span class="read-more">'.esc_attr__('VOIR PLUS', 'trend').'</span>';
                    $shortcode_content .= '</div>';
                $shortcode_content .= '</a>';
            $shortcode_content .= '</div>';
            #IMG #2
            $shortcode_content .= '<div class="masonry_banner dark-skin">';
                $shortcode_content .= '<a href="'.$banner_2_url.'" class="relative">';
                    $shortcode_content .= '<img src="'.$img2[0].'" alt="'.$banner_2_title.'" />';
                    $shortcode_content .= '<div class="masonry_holder">';
                        $shortcode_content .= '<h3 class="category_name">'.$banner_2_title.'</h3>';
                        $shortcode_content .= '<span class="read-more">'.esc_attr__('VOIR PLUS', 'trend').'</span>';
                    $shortcode_content .= '</div>';
                $shortcode_content .= '</a>';
            $shortcode_content .= '</div>';
        $shortcode_content .= '</div>';

        $shortcode_content .= '<div class="vc_col-md-6">';
            #IMG #3
            $shortcode_content .= '<div class="masonry_banner dark-skin">';
                $shortcode_content .= '<a href="'.$banner_3_url.'" class="relative">';
                    $shortcode_content .= '<img src="'.$img3[0].'" alt="'.$banner_3_title.'" />';
                    $shortcode_content .= '<div class="masonry_holder">';
                        $shortcode_content .= '<h3 class="category_name">'.$banner_3_title.'</h3>';
                        $shortcode_content .= '<span class="read-more">'.esc_attr__('VOIR PLUS', 'trend').'</span>';
                    $shortcode_content .= '</div>';
                $shortcode_content .= '</a>';
            $shortcode_content .= '</div>';
            #IMG #4
            $shortcode_content .= '<div class="masonry_banner default-skin">';
                $shortcode_content .= '<a href="'.$banner_4_url.'" class="relative">';
                    $shortcode_content .= '<img src="'.$img4[0].'" alt="'.$banner_4_title.'" />';
                    $shortcode_content .= '<div class="masonry_holder">';
                        $shortcode_content .= '<h3 class="category_name">'.$banner_4_title.'</h3>';
                        $shortcode_content .= '<span class="read-more">'.esc_attr__('VOIR PLUS', 'trend').'</span>';
                    $shortcode_content .= '</div>';
                $shortcode_content .= '</a>';
            $shortcode_content .= '</div>';
        $shortcode_content .= '</div>';
    $shortcode_content .= '</div>';

    return $shortcode_content;
}
add_shortcode('shop-masonry-banners', 'trend_shop_masonry_banners_shortcode');




/*---------------------------------------------*/
/*--- Masonry Banners ---*/
/*---------------------------------------------*/
function trend_shop_sale_banner_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'banner_img'            => '',
            'banner_button_text'    => '',
            'banner_button_url'     => ''
        ), $params ) );

    $banner = wp_get_attachment_image_src($banner_img, "large");

    $shortcode_content = '';
    #SALE BANNER
    $shortcode_content .= '<div class="sale_banner relative">';
            $shortcode_content .= '<img src="'.$banner[0].'" alt="'.$banner_button_text.'" />';
            $shortcode_content .= '<div class="sale_banner_holder">';
                $shortcode_content .= '<div class="banner_holder">';
                    $shortcode_content .= '<a href="'.$banner_button_url.'" class="button-winona" title="'.$banner_button_text.'" data-text="'.$banner_button_text.'"><span>'.$banner_button_text.'</span></a>';
                $shortcode_content .= '</div>';
            $shortcode_content .= '</div>';
    $shortcode_content .= '</div>';
       
    return $shortcode_content;
}
add_shortcode('sale-banner', 'trend_shop_sale_banner_shortcode');






/*---------------------------------------------*/
/*--- 28. BLOG POSTS ---*/
/*---------------------------------------------*/
function trend_show_blog_post_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'number'            => '',
            'category'          => '',
            'overlay_color'     => '',
            'text_color'        => '',
            'columns'           => ''
           ), $params ) );
    $args_posts = array(
            'posts_per_page'        => $number,
            'post_type'             => 'post',
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $category
                )
            ),
            'post_status'           => 'publish' 
        );
    $posts = get_posts($args_posts);

    $shortcode_content = '';
    $shortcode_content .= '<div class="trend_shortcode_blog vc_row sticky-posts">';
    foreach ($posts as $post) { 
        $excerpt = get_post_field('post_content', $post->ID);
        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'trend_portfolio_pic700x450' );
        $author_id = $post->post_author;
        $url = get_permalink($post->ID); 
        $shortcode_content .= '<div class="'.$columns.' post">';
            $shortcode_content .= '<a href="'.$url.'" class="relative">';
                if($thumbnail_src) { 
                    $shortcode_content .= '<img src="'. $thumbnail_src[0] . '" alt="'. $post->post_title .'" />';
                }else{ 
                    $shortcode_content .= '<img src="http://placehold.it/700x450" alt="'. $post->post_title .'" />'; 
                }
                $shortcode_content .= '<div class="post-date absolute rotate45" style="background: '.$text_color.'!important;">';
                    $shortcode_content .= '<span class="rotate45_back">'.get_the_date( "j M", $post->ID ).'</span>';
                $shortcode_content .= '</div>';
                $shortcode_content .= '<div class="thumbnail-overlay absolute" style="background: '.$overlay_color.'!important;">';
                    $shortcode_content .= '<i class="fa fa-plus absolute"></i>';
                $shortcode_content .= '</div>';
            $shortcode_content .= '</a>';
            $shortcode_content .= '<h3 class="post-name"><a href="'.$url.'" style="color: '.$text_color.'!important;">'.$post->post_title.'</a></h3>';
            $shortcode_content .= '<div class="post-author">by '.get_the_author_meta( 'display_name', $author_id ).'</div>';
            $shortcode_content .= '<div class="post-excerpt">'.trend_excerpt_limit($excerpt,10).'</div>';
        $shortcode_content .= '</div>';
    } 
    $shortcode_content .= '</div>';
    return $shortcode_content;
}
add_shortcode('trend-blog-posts', 'trend_show_blog_post_shortcode');
/*---------------------------------------------*/
/*--- 29. Social Media ---*/
/*---------------------------------------------*/
function trend_social_icons_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'facebook'      => '',
            'twitter'       => '',
            'pinterest'     => '',
            'skype'         => '',
            'instagram'     => '',
            'youtube'       => '',
            'dribbble'      => '',
            'googleplus'    => '',
            'linkedin'      => '',
            'deviantart'    => '',
            'digg'          => '',
            'flickr'        => '',
            'stumbleupon'   => '',
            'tumblr'        => '',
            'vimeo'         => '',
            'animation'     => ''
        ), $params ) ); 
        $content = '';
        $content .= '<div class="sidebar-social-networks vc_social-networks widget_social_icons animateIn vc_row" data-animate="'.$animation.'">';
            $content .= '<ul class="vc_col-md-12">';
            if ( isset($facebook) && $facebook != '' ) {
                $content .= '<li><a href="'.esc_attr( $facebook ).'"><i class="fa fa-facebook"></i></a></li>';
            }
            if ( isset($twitter) && $twitter != '' ) {
                $content .= '<li><a href="'.esc_attr( $twitter ).'"><i class="fa fa-twitter"></i></a></li>';
            }
            if ( isset($pinterest) && $pinterest != '' ) {
                $content .= '<li><a href="'.esc_attr( $pinterest ).'"><i class="fa fa-pinterest"></i></a></li>';
            }
            if ( isset($youtube) && $youtube != '' ) {
                $content .= '<li><a href="'.esc_attr( $youtube ).'"><i class="fa fa-youtube"></i></a></li>';
            }
            if ( isset($instagram) && $instagram != '' ) {
                $content .= '<li><a href="'.esc_attr( $instagram ).'"><i class="fa fa-instagram"></i></a></li>';
            }
            if ( isset($linkedin) && $linkedin != '' ) {
                $content .= '<li><a href="'.esc_attr( $linkedin ).'"><i class="fa fa-linkedin"></i></a></li>';
            }
            if ( isset($skype) && $skype != '' ) {
                $content .= '<li><a href="skype:'.esc_attr( $skype ).'?call"><i class="fa fa-skype"></i></a></li>';
            }
            if ( isset($googleplus) && $googleplus != '' ) {
                $content .= '<li><a href="'.esc_attr( $googleplus ).'"><i class="fa fa-google-plus"></i></a></li>';
            }
            if ( isset($dribbble) && $dribbble != '' ) {
                $content .= '<li><a href="'.esc_attr( $dribbble ).'"><i class="fa fa-dribbble"></i></a></li>';
            }
            if ( isset($deviantart) && $deviantart != '' ) {
                $content .= '<li><a href="'.esc_attr( $deviantart ).'"><i class="fa fa-deviantart"></i></a></li>';
            }
            if ( isset($digg) && $digg != '' ) {
                $content .= '<li><a href="'.esc_attr( $digg ).'"><i class="fa fa-digg"></i></a></li>';
            }
            if ( isset($flickr) && $flickr != '' ) {
                $content .= '<li><a href="'.esc_attr( $flickr ).'"><i class="fa fa-flickr"></i></a></li>';
            }
            if ( isset($stumbleupon) && $stumbleupon != '' ) {
                $content .= '<li><a href="'.esc_attr( $stumbleupon ).'"><i class="fa fa-stumbleupon"></i></a></li>';
            }
            if ( isset($tumblr) && $tumblr != '' ) {
                $content .= '<li><a href="'.esc_attr( $tumblr ).'"><i class="fa fa-tumblr"></i></a></li>';
            }
            if ( isset($vimeo) && $vimeo != '' ) {
                $content .= '<li><a href="'.esc_attr( $vimeo ).'"><i class="fa fa-vimeo-square"></i></a></li>';
            }
            $content .= '</ul>';
        $content .= '</div>';
        return $content;
}
add_shortcode('social_icons', 'trend_social_icons_shortcode');


include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// check for plugin using plugin name
if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
  require_once('vc-shortcodes.inc.php');
} 
?>
