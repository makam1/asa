<?php
/**
  ReduxFramework TREND Theme Config File
  For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
 * */



if (!class_exists("Redux_Framework_trend_config")) {

    class Redux_Framework_trend_config {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }
            
            // This is needed. Bah WordPress bugs.  ;)
            if ( get_template_directory() && strpos( Redux_Helpers::cleanFilePath( __FILE__ ), Redux_Helpers::cleanFilePath( get_template_directory() ) ) !== false) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);    
            }
        }

        public function initSettings() {

            if ( !class_exists("ReduxFramework" ) ) {
                return;
            }       
            
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field   set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {

        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
    
            return $sections;
        }
        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = "Testing filter hook!";

            return $defaults;
        }

        public function setSections() {

            include_once('modeltheme-config.arrays.php');

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $trend_patterns_path = ReduxFramework::$_dir . '../polygon/patterns/';
            $trend_patterns_url = ReduxFramework::$_url . '../polygon/patterns/';
            $trend_patterns = array();

            if (is_dir($trend_patterns_path)) :

                if ($trend_patterns_dir = opendir($trend_patterns_path)) :
                    $trend_patterns = array();

                    while (( $trend_patterns_file = readdir($trend_patterns_dir) ) !== false) {

                        if (stristr($trend_patterns_file, '.png') !== false || stristr($trend_patterns_file, '.jpg') !== false) {
                            $name = explode(".", $trend_patterns_file);
                            $name = str_replace('.' . end($name), '', $trend_patterns_file);
                            $trend_patterns[] = array('alt' => $name, 'img' => $trend_patterns_url . $trend_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct = wp_get_theme();
            $this->theme = $ct;
            $item_name = $this->theme->get('Name');
            $tags = $this->theme->Tags;
            $screenshot = $this->theme->get_screenshot();
            $class = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'trend'), $this->theme->display('Name'));
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo esc_url(wp_customize_url()); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','trend'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','trend'); ?>" />
            <?php endif; ?>

                <h4>
            <?php echo  wp_kses_post($this->theme->display('Name')); ?>
                </h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'trend'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'trend'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'trend') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo  wp_kses_post($this->theme->display('Description')); ?></p>
                <?php
                if ($this->theme->parent()) {
                    printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'trend') . '</p>', __('http://codex.WordPress.org/Child_Themes', 'trend'), $this->theme->parent()->display('Name'));
                }
                ?>

                </div>

            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $pmHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $pmHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            # Section #1: General Settings

            $this->sections[] = array(
                'icon' => 'el-icon-wrench',
                'title' => __('General Settings', 'trend'),
                'fields' => array(
                    array(
                        'id'   => 'mt_general_breadcrumbs',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Breadcrumbs</h3>', 'trend' )
                    ),
                    array(
                        'id'       => 'trend-enable-breadcrumbs',
                        'type'     => 'switch', 
                        'title'    => __('Breadcrumbs', 'trend'),
                        'subtitle' => __('Enable or disable breadcrumbs', 'trend'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'breadcrumbs-delimitator',
                        'type'     => 'text',
                        'title'    => __('Breadcrumbs delimitator', 'trend'),
                        'subtitle' => __('This is a little space under the Field Title in the Options table, additional info is good in here.', 'trend'),
                        'desc'     => __('This is the description field, again good for additional info.', 'trend'),
                        'default'  => '/'
                    ),
                )
            );
            # Section #1: General Settings

            $this->sections[] = array(
                'icon' => 'el-icon-stop',
                'title' => __('Sidebars', 'trend'),
                'fields' => array(
                    array(
                        'id'   => 'mt_sidebars_generator',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Generate Unlimited Sidebars</h3>', 'trend' )
                    ),
                    array(
                        'id'       => 'dynamic_sidebars',
                        'type'     => 'multi_text',
                        'title'    => __( 'Sidebars', 'trend' ),
                        'subtitle' => __( 'Use the "Add More" button to create unlimited sidebars.', 'trend' ),
                        'add_text' => __( 'Add one more Sidebar', 'trend' ),
                        'options'   => array(
                            'Burger Navigation',
                            'Sidebar 2'
                        ),
                    )
                )
            );

            # Section #2: Styling Settings

            $this->sections[] = array(
                'icon' => 'el-icon-magic',
                'title' => __('Styling Settings', 'trend'),
                'fields' => array(
                    array(
                        'id'   => 'mt_styling_skin_color',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Skin Color</h3>', 'trend' )
                    ),
                    array(
                        'id'       => 'trend_skin_color',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Select Skin Color', 'trend' ),
                        'subtitle' => __( 'Select Skin Color.', 'trend' ),
                        'options'  => array(
                            'default' => array(
                                'alt' => 'Default - Blue',
                                'img' => get_template_directory_uri().'/redux-framework/assets/skin-colors/skin-default.jpg'
                            ),
                            'green' => array(
                                'alt' => 'Skin - Green',
                                'img' => get_template_directory_uri().'/redux-framework/assets/skin-colors/skin-green.jpg'
                            ),
                            'turquoise' => array(
                                'alt' => 'Skin - Turquoise',
                                'img' => get_template_directory_uri().'/redux-framework/assets/skin-colors/skin-turquoise.jpg'
                            ),
                            'grey' => array(
                                'alt' => 'Skin - Grey',
                                'img' => get_template_directory_uri().'/redux-framework/assets/skin-colors/skin-grey.jpg'
                            ),
                            'orange' => array(
                                'alt' => 'Skin - Orange',
                                'img' => get_template_directory_uri().'/redux-framework/assets/skin-colors/skin-orange.jpg'
                            ),
                            'red' => array(
                                'alt' => 'Skin - Red',
                                'img' => get_template_directory_uri().'/redux-framework/assets/skin-colors/skin-red.jpg'
                            ),
                            'yellow' => array(
                                'alt' => 'Skin - Yellow',
                                'img' => get_template_directory_uri().'/redux-framework/assets/skin-colors/skin-yellow.jpg'
                            ),
                            'purple' => array(
                                'alt' => 'Skin - Purple',
                                'img' => get_template_directory_uri().'/redux-framework/assets/skin-colors/skin-purple.jpg'
                            )
                        ),
                        'default'  => 'default'
                    ),
                    array(
                        'id'   => 'mt_divider_links',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Links Colors(Regular, Hover, Active/Visited)</h3>', 'trend' )
                    ),
                    array(
                        'id'       => 'mt_global_link_styling',
                        'type'     => 'link_color',
                        'title'    => esc_attr__('Links Color Option', 'trend'),
                        'subtitle' => esc_attr__('Only color validation can be done on this field type(Default Regular: #00ADEF; Default Hover: #0099d1; Default Active: #0099d1;)', 'trend'),
                        'default'  => array(
                            'regular'  => '#00ADEF', // blue
                            'hover'    => '#0099d1', // blue-x3
                            'active'   => '#0099d1',  // blue-x3
                            'visited'  => '#0099d1',  // blue-x3
                        )
                    ),
                    array(
                        'id'   => 'mt_divider_main_colors',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Main Colors & Backgrounds</h3>', 'trend' )
                    ),
                    array(
                        'id'       => 'mt_style_main_texts_color',
                        'type'     => 'color',
                        'title'    => esc_attr__('Main texts color', 'trend'), 
                        'subtitle' => esc_attr__('Default: #00ADEF', 'trend'),
                        'default'  => '#00ADEF',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'mt_style_main_backgrounds_color',
                        'type'     => 'color',
                        'title'    => esc_attr__('Main backgrounds color', 'trend'), 
                        'subtitle' => esc_attr__('Default: #00ADEF', 'trend'),
                        'default'  => '#00ADEF',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'mt_style_main_backgrounds_color_hover',
                        'type'     => 'color',
                        'title'    => esc_attr__('Main backgrounds color (hover)', 'trend'), 
                        'subtitle' => esc_attr__('Default: #0099d1', 'trend'),
                        'default'  => '#0099d1',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'mt_style_semi_opacity_backgrounds',
                        'type'     => 'color_rgba',
                        'title'    => esc_attr__( 'Semitransparent blocks background', 'trend' ),
                        'default'  => array(
                            'color' => '#00ADEF',
                            'alpha' => '.95'
                        ),
                        'output' => array(
                            'background-color' => '.fixed-sidebar-menu',
                        ),
                        'mode'     => 'background'
                    ),
                    array(
                        'id'   => 'mt_divider_text_selection',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Text Selection Color & Background</h3>', 'trend' )
                    ),
                    array(
                        'id'       => 'mt_text_selection_color',
                        'type'     => 'color',
                        'title'    => esc_attr__('Text selection color', 'trend'), 
                        'subtitle' => esc_attr__('Default: #ffffff', 'trend'),
                        'default'  => '#ffffff',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'mt_text_selection_background_color',
                        'type'     => 'color',
                        'title'    => esc_attr__('Text selection background color', 'trend'), 
                        'subtitle' => esc_attr__('Default: #00ADEF', 'trend'),
                        'default'  => '#00ADEF',
                        'validate' => 'color',
                    ),


                    array(
                        'id'   => 'mt_divider_nav_menu',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Menus Styling</h3>', 'trend' )
                    ),
                    array(
                        'id'       => 'mt_nav_menu_color',
                        'type'     => 'color',
                        'title'    => esc_attr__('Nav Menu Text Color', 'trend'), 
                        'subtitle' => esc_attr__('Default: #393939', 'trend'),
                        'default'  => '#393939',
                        'validate' => 'color',
                        'output' => array(
                            'color' => '#navbar .menu-item > a,
                                        .navbar-nav .search_products a,
                                        .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus,
                                        .navbar-default .navbar-nav > li > a',
                        )
                    ),
                    array(
                        'id'   => 'mt_divider_nav_submenu',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Submenus Styling</h3>', 'trend' )
                    ),
                    array(
                        'id'       => 'mt_nav_submenu_background',
                        'type'     => 'color',
                        'title'    => esc_attr__('Nav Submenu Background Color', 'trend'), 
                        'subtitle' => esc_attr__('Default: #2D3E50', 'trend'),
                        'default'  => '#2D3E50',
                        'validate' => 'color',
                        'output' => array(
                            'background-color' => '#navbar .sub-menu, .navbar ul li ul.sub-menu',
                        )
                    ),
                    array(
                        'id'       => 'mt_nav_submenu_color',
                        'type'     => 'color',
                        'title'    => esc_attr__('Nav Submenu Text Color', 'trend'), 
                        'subtitle' => esc_attr__('Default: #ffffff', 'trend'),
                        'default'  => '#ffffff',
                        'validate' => 'color',
                        'output' => array(
                            'color' => '#navbar ul.sub-menu li a',
                        )
                    ),
                    array(
                        'id'       => 'mt_nav_submenu_hover_background_color',
                        'type'     => 'color',
                        'title'    => esc_attr__('Nav Submenu Hover Background Color', 'trend'), 
                        'subtitle' => esc_attr__('Default: #00ADEF', 'trend'),
                        'default'  => '#00ADEF',
                        'validate' => 'color',
                        'output' => array(
                            'background-color' => '#navbar ul.sub-menu li a:hover',
                        )
                    ),
                    array(
                        'id'       => 'mt_nav_submenu_hover_text_color',
                        'type'     => 'color',
                        'title'    => esc_attr__('Nav Submenu Hover Background Color', 'trend'), 
                        'subtitle' => esc_attr__('Default: #ffffff', 'trend'),
                        'default'  => '#ffffff',
                        'validate' => 'color',
                        'output' => array(
                            'color' => '#navbar ul.sub-menu li a:hover',
                        )
                    ),

                    array(
                        'id'   => 'mt_styling_google_font',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Import Google Fonts</h3>', 'trend' )
                    ),
                    array(
                        'id'       => 'google-fonts-select',
                        'type'     => 'select',
                        'multi'    => true,
                        'title'    => esc_attr__('Import Google Font Globally', 'trend'), 
                        'subtitle' => esc_attr__('Select one or multiple fonts', 'trend'),
                        'desc'     => esc_attr__('Importing fonts made easy', 'trend'),
                        'options'  => $google_fonts_list,
                        'default'  => array('Roboto:100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic,vietnamese,greek,latin-ext,greek-ext,cyrillic-ext,latin,cyrillic'),
                    ),
                    array(
                        'id'   => 'mt_styling_fonts',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Fonts Settings</h3>', 'trend' )
                    ),
                    array(
                        'id'          => 'trend-body-typography',
                        'type'        => 'typography', 
                        'title'       => __('Body Font family', 'trend'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => false,
                        'font-weight'  => false,
                        'font-size'   => false,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('body'),
                        'units'       =>'px',
                        //'subtitle'    => __('Typography option with each property can be called individually.', 'redux-framework-demo'),
                        'default'     => array(
                            'font-family' => 'Roboto', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'   => 'mt_divider_5',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Headings</h3>', 'trend' )
                    ),
                    array(
                        'id'          => 'mt_heading_h1',
                        'type'        => 'typography', 
                        'title'       => esc_attr__('Heading H1 Font family', 'trend'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => true,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('h1', 'h1 span'),
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Roboto', 
                            'font-size' => '36px', 
                            'color' => '#333333', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h2',
                        'type'        => 'typography', 
                        'title'       => esc_attr__('Heading H2 Font family', 'trend'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => true,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('h2'),
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Roboto', 
                            'font-size' => '30px', 
                            'color' => '#333333', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h3',
                        'type'        => 'typography', 
                        'title'       => esc_attr__('Heading H3 Font family', 'trend'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => true,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('h3', '.post-name'),
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Roboto', 
                            'font-size' => '24px', 
                            'color' => '#333333', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h4',
                        'type'        => 'typography', 
                        'title'       => esc_attr__('Heading H4 Font family', 'trend'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => true,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('h4'),
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Roboto', 
                            'font-size' => '18px', 
                            'color' => '#333333', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h5',
                        'type'        => 'typography', 
                        'title'       => esc_attr__('Heading H5 Font family', 'trend'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => true,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('h5'),
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Roboto', 
                            'font-size' => '14px', 
                            'color' => '#333333', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h6',
                        'type'        => 'typography', 
                        'title'       => esc_attr__('Heading H6 Font family', 'trend'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => true,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('h6'),
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Roboto', 
                            'font-size' => '12px', 
                            'color' => '#333333', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'   => 'mt_divider_6',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Inputs & Textareas Font family</h3>', 'trend' )
                    ),
                    array(
                        'id'                => 'mt_inputs_typography',
                        'type'              => 'typography', 
                        'title'             => esc_attr__('Inputs Font family', 'trend'),
                        'google'            => true, 
                        'font-backup'       => true,
                        'color'             => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'line-height'       => false,
                        'font-weight'       => false,
                        'font-size'         => false,
                        'font-style'        => false,
                        'subsets'           => false,
                        'output'            => array('input', 'textarea'),
                        'units'             =>'px',
                        'subtitle'          => esc_attr__('Font family for inputs and textareas', 'trend'),
                        'default'           => array(
                            'font-family'       => 'Roboto', 
                            'google'            => true
                        ),
                    ),
                    array(
                        'id'   => 'mt_divider_7',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Buttons Font family</h3>', 'trend' )
                    ),
                    array(
                        'id'                => 'mt_buttons_typography',
                        'type'              => 'typography', 
                        'title'             => esc_attr__('Buttons Font family', 'trend'),
                        'google'            => true, 
                        'font-backup'       => true,
                        'color'             => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'line-height'       => false,
                        'font-weight'       => false,
                        'font-size'         => false,
                        'font-style'        => false,
                        'subsets'           => false,
                        'output'            => array(
                            'input[type="submit"]'
                        ),
                        'units'             =>'px',
                        'subtitle'          => esc_attr__('Font family for buttons', 'trend'),
                        'default'           => array(
                            'font-family'       => 'Roboto', 
                            'google'            => true
                        ),
                    ),



                )
            );

            # Section #2: Header Settings

            $this->sections[] = array(
                'icon' => 'el-icon-arrow-up',
                'title' => __('Header Settings', 'trend'),
                'fields' => array(
                    array(
                        'id'   => 'mt_header_variant',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Header Variant</h3>', 'trend' )
                    ),
                    array(
                        'id'       => 'header_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Select Header layout', 'trend' ),
                        'options'  => array(
                            'first_header' => array(
                                'alt' => 'Header #1',
                                'img' => get_template_directory_uri().'/redux-framework/assets/headers/header_1.jpg'
                            ),
                            'second_header' => array(
                                'alt' => 'Header #2',
                                'img' => get_template_directory_uri().'/redux-framework/assets/headers/header_2.jpg'
                            ),
                            'third_header' => array(
                                'alt' => 'Header #3',
                                'img' => get_template_directory_uri().'/redux-framework/assets/headers/header_3.jpg'
                            ),
                            'fourth_header' => array(
                                'alt' => 'Header #4',
                                'img' => get_template_directory_uri().'/redux-framework/assets/headers/header_4.jpg'
                            ),
                            'fifth_header' => array(
                                'alt' => 'Header #5',
                                'img' => get_template_directory_uri().'/redux-framework/assets/headers/header_5.jpg'
                            ),
                            'sixth_header' => array(
                                'alt' => 'Header #6',
                                'img' => get_template_directory_uri().'/redux-framework/assets/headers/header_6.jpg'
                            ),
                            'seventh_header' => array(
                                'alt' => 'Header #7',
                                'img' => get_template_directory_uri().'/redux-framework/assets/headers/header_7.jpg'
                            ),
                            'eighth_header' => array(
                                'alt' => 'Header #8',
                                'img' => get_template_directory_uri().'/redux-framework/assets/headers/header_8.jpg'
                            )
                        ),
                        'default'  => 'first_header'
                    ),
                    array(
                        'id'       => 'is_nav_sticky',
                        'type'     => 'switch', 
                        'title'    => __('Fixed Navigation menu?', 'trend'),
                        'subtitle' => __('Enable or disable "fixed positioned navigation menu".', 'trend'),
                        'default'  => true,
                    ),
                    array(
                        'id'   => 'mt_header_search_settings',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Search Settings</h3>', 'trend' )
                    ),
                    array(
                        'id'        => 'search_for',
                        'type'      => 'select',
                        'title'     => __('Search form for:', 'trend'),
                        'subtitle'  => __('Select the scope of the header search form(Search for PRODUCTS or POSTS).', 'trend'),
                        'options'   => array(
                                'products'   => 'Products',
                                'posts'   => 'Posts'
                            ),
                        'default'   => 'products',
                    ),
                    array(
                        'id'   => 'mt_header_logo_settings',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Logo & Favicon Settings</h3>', 'trend' )
                    ),
                    array(
                        'id' => 'trend_logo',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Logo as image', 'trend'),
                        'compiler' => 'true',
                        'default' => array('url' => get_template_directory_uri().'/images/1logo-blue.png'),
                    ),
                    array(
                        'id'        => 'logo_max_width',
                        'type'      => 'slider',
                        'title'     => __('Logo Max Width', 'trend'),
                        'subtitle'  => __('Use the slider to increase/decrease max size of the logo.', 'trend'),
                        'desc'      => __('Min: 1px, max: 500px, step: 1px, default value: 140px', 'trend'),
                        "default"   => 140,
                        "min"       => 1,
                        "step"      => 1,
                        "max"       => 500,
                        'display_value' => 'label'
                    ),
                    array(
                        'id' => 'trend_logo_text',
                        'type' => 'text',
                        'title' => __('Logo as text', 'trend'),
                        'subtitle' => __('To replace the "Logo as image" with "Logo as text", the image field must be empty', 'trend'),
                        'default' => 'TRE<span>ND</span>'
                    ),
                    array(
                        'id' => 'trend_favicon',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Favicon url', 'trend'),
                        'compiler' => 'true',
                        'subtitle' => __('Use the upload button to import media.', 'trend'),
                        'default' => array('url' => get_template_directory_uri().'/images/trend-favicon.png'),
                    ),
                    array(
                        'id'   => 'mt_header_styling_settings',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Header Styling Settings</h3>', 'trend' )
                    ),
                    array(         
                        'id'       => 'header_top_bar_background',
                        'type'     => 'background',
                        'title'    => __('Header (top small bar) - background', 'trend'),
                        'subtitle' => __('Header background with image or color.', 'trend'),
                        'output'      => array('.top-header'),
                        'default'  => array(
                            'background-color' => '#393939',
                        )
                    ),
                    array(         
                        'id'       => 'header_main_background',
                        'type'     => 'background',
                        'title'    => __('Header (main-header) - background', 'trend'),
                        'subtitle' => __('Header background with image or color.', 'trend'),
                        'output'      => array('.navbar-default'),
                        'default'  => array(
                            'background-color' => '#F8F8F8',
                        )
                    )
                )
            );

            # Section #2: Footer Settings

            $this->sections[] = array(
                'icon' => 'el-icon-arrow-down',
                'title' => __('Footer Settings', 'trend'),
                'fields' => array(
                    array(
                        'id'       => 'trend-enable-footer-widgets',
                        'type'     => 'switch', 
                        'title'    => __('Footer Widgets', 'trend'),
                        'subtitle' => __('Enable or disable footer wigets', 'trend'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'trend_number_of_footer_columns',
                        'type'     => 'select',
                        'title'    => __('Number of footer columns', 'trend'), 
                        'subtitle' => __('Footer - number of columns.', 'trend'),
                        // Must provide key => value pairs for select options
                        'options'  => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6'
                        ),
                        'default'  => '3',
                        'required' => array('trend-enable-footer-widgets','equals',true),
                    ),
                    array(
                        'id' => 'trend_footer_text',
                        'type' => 'editor',
                        'title' => __('Footer Text', 'trend'),
                        'default' => 'Copyright by ModelTheme. All Rights Reserved.',
                    ),
                    array(
                        'id' => 'trend_card_icons',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Footer card icons', 'trend'),
                        'compiler' => 'true',
                        'default' => array('url' => get_template_directory_uri().'/images/card-icons.png'),
                    ),
                    array(         
                        'id'       => 'footer_top_background',
                        'type'     => 'background',
                        'title'    => __('Footer (top) - background', 'trend'),
                        'subtitle' => __('Footer background with image or color.', 'trend'),
                        'output'      => array('footer'),
                        'default'  => array(
                            'background-color' => '#2C3E50',
                        )
                    ),
                    array(         
                        'id'       => 'footer_bottom_background',
                        'type'     => 'background',
                        'title'    => __('Footer (bottom) - background', 'trend'),
                        'subtitle' => __('Footer background with image or color.', 'trend'),
                        'output'      => array('footer .footer'),
                        'default'  => array(
                            'background-color' => '#151E27',
                        )
                    ),
                    array(
                        'id'   => 'mt_back_to_top',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Back to Top Settings</h3>', 'trend' )
                    ),
                    array(
                        'id'       => 'mt_backtotop_status',
                        'type'     => 'switch', 
                        'title'    => esc_attr__('Back to Top Button Status', 'trend'),
                        'subtitle' => esc_attr__('Enable or disable "Back to Top Button"', 'trend'),
                        'default'  => true,
                    ),
                    array(         
                        'id'       => 'mt_backtotop_bg_color',
                        'type'     => 'background',
                        'title'    => esc_attr__('Back to Top Button Status Backgrond', 'trend'), 
                        'subtitle' => esc_attr__('Default: #00ADEF', 'trend'),
                        'default'  => array(
                            'background-color' => '#00ADEF',
                            'background-repeat' => 'no-repeat',
                            'background-position' => 'center center',
                            'background-image' => get_template_directory_uri().'/images/mt-to-top-arrow.svg',
                        )
                    ),

                )
            );


            # Section #4: Contact Settings

            $this->sections[] = array(
                'icon' => 'el-icon-map-marker-alt',
                'title' => __('Contact Settings', 'trend'),
                'fields' => array(
                    array(
                        'id' => 'trend_contact_phone',
                        'type' => 'text',
                        'title' => __('Phone Number', 'trend'),
                        'subtitle' => __('Contact phone number displayed on the contact us page.', 'trend'),
                        'validate_callback' => 'redux_validate_callback_function',
                        'default' => ' +1 777 3321 2312'
                    ),
                    array(
                        'id' => 'trend_contact_email',
                        'type' => 'text',
                        'title' => __('Email', 'trend'),
                        'subtitle' => __('Contact email displayed on the contact us page., additional info is good in here.', 'trend'),
                        'validate' => 'email',
                        'msg' => 'custom error message',
                        'default' => 'support@avstudio.com'
                    ),
                    array(
                        'id' => 'trend_contact_address',
                        'type' => 'text',
                        'title' => __('Address', 'trend'),
                        'subtitle' => __('Enter your contact address', 'trend'),
                        'default' => 'No 123, Rode Island, USA'
                    ),
                    array(
                        'id' => 'trend_map_maker',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Pin point maker', 'trend'),
                        'compiler' => 'true',
                        'subtitle' => __('Change the maker of the map.', 'trend'),
                        'default' => array('url' => get_template_directory_uri().'/images/svg/trend-icon-location.png'),
                    ),
                    array(
                        'id'    => 'opt-info-success',
                        'type'  => 'info',
                        'style' => 'success',
                        'icon'  => 'el-icon-info-sign',
                        'title' => __( 'To change the <strong>latitude and longitude</strong> of the map: Via Visual Composer on the contact section.', 'trend' )
                    )
                )
            );

            # Section #6: Blog Settings

            $icons = array(
            'fa fa-angellist'      => 'fa fa-angellist',
            'fa fa-area-chart'     => 'fa fa-area-chart',
            'fa fa-at'             => 'fa fa-at',
            'fa fa-bell-slash'     => 'fa fa-bell-slash',
            'fa fa-bell-slash-o'   => 'fa fa-bell-slash-o',
            'fa fa-bicycle'        => 'fa fa-bicycle',
            'fa fa-binoculars'     => 'fa fa-binoculars',
            'fa fa-birthday-cake'  => 'fa fa-birthday-cake',
            'fa fa-bus'            => 'fa fa-bus',
            'fa fa-calculator'     => 'fa fa-calculator',
            'fa fa-cc'             => 'fa fa-cc',
            'fa fa-cc-amex'        => 'fa fa-cc-amex',
            'fa fa-cc-discover'    => 'fa fa-cc-discover',
            'fa fa-cc-mastercard'  => 'fa fa-cc-mastercard',
            'fa fa-cc-paypal'      => 'fa fa-cc-paypal',
            'fa fa-cc-stripe'      => 'fa fa-cc-stripe',
            'fa fa-cc-visa'        => 'fa fa-cc-visa',
            'fa fa-copyright'      => 'fa fa-copyright',
            'fa fa-eyedropper'     => 'fa fa-eyedropper',
            'fa fa-futbol-o'       => 'fa fa-futbol-o',
            'fa fa-google-wallet'  => 'fa fa-google-wallet',
            'fa fa-ils'            => 'fa fa-ils',
            'fa fa-ioxhost'        => 'fa fa-ioxhost',
            'fa fa-lastfm'         => 'fa fa-lastfm',
            'fa fa-lastfm-square' => 'fa fa-lastfm-square',
            'fa fa-line-chart' => 'fa fa-line-chart',
            'fa fa-meanpath' => 'fa fa-meanpath',
            'fa fa-newspaper-o' => 'fa fa-newspaper-o',
            'fa fa-paint-brush' => 'fa fa-paint-brush',
            'fa fa-paypal' => 'fa fa-paypal',
            'fa fa-pie-chart' => 'fa fa-pie-chart',
            'fa fa-plug' => 'fa fa-plug',
            'fa fa-shekel' => 'fa fa-shekel',
            'fa fa-sheqel' => 'fa fa-sheqel',
            'fa fa-slideshare' => 'fa fa-slideshare',
            'fa fa-soccer-ball-o' => 'fa fa-soccer-ball-o',
            'fa fa-toggle-off' => 'fa fa-toggle-off',
            'fa fa-toggle-on' => 'fa fa-toggle-on',
            'fa fa-trash' => 'fa fa-trash',
            'fa fa-tty' => 'fa fa-tty',
            'fa fa-twitch' => 'fa fa-twitch',
            'fa fa-wifi' => 'fa fa-wifi',
            'fa fa-yelp' => 'fa fa-yelp',
            'fa fa-adjust' => 'fa fa-adjust',
            'fa fa-anchor' => 'fa fa-anchor',
            'fa fa-archive' => 'fa fa-archive',
            'fa fa-arrows' => 'fa fa-arrows',
            'fa fa-arrows-h' => 'fa fa-arrows-h',
            'fa fa-arrows-v' => 'fa fa-arrows-v',
            'fa fa-asterisk' => 'fa fa-asterisk',
            'fa fa-automobile' => 'fa fa-automobile',
            'fa fa-ban' => 'fa fa-ban',
            'fa fa-bank' => 'fa fa-bank',
            'fa fa-bar-chart' => 'fa fa-bar-chart',
            'fa fa-bar-chart-o' => 'fa fa-bar-chart-o',
            'fa fa-barcode' => 'fa fa-barcode',
            'fa fa-bars' => 'fa fa-bars',
            'fa fa-beer' => 'fa fa-beer',
            'fa fa-bell' => 'fa fa-bell',
            'fa fa-bell-o' => 'fa fa-bell-o',
            'fa fa-bolt' => 'fa fa-bolt',
            'fa fa-bomb' => 'fa fa-bomb',
            'fa fa-book' => 'fa fa-book',
            'fa fa-bookmark' => 'fa fa-bookmark',
            'fa fa-bookmark-o' => 'fa fa-bookmark-o',
            'fa fa-briefcase' => 'fa fa-briefcase',
            'fa fa-bug' => 'fa fa-bug',
            'fa fa-building' => 'fa fa-building',
            'fa fa-building-o' => 'fa fa-building-o',
            'fa fa-bullhorn' => 'fa fa-bullhorn',
            'fa fa-bullseye' => 'fa fa-bullseye',
            'fa fa-cab' => 'fa fa-cab',
            'fa fa-calendar' => 'fa fa-calendar',
            'fa fa-calendar-o' => 'fa fa-calendar-o',
            'fa fa-camera' => 'fa fa-camera',
            'fa fa-camera-retro' => 'fa fa-camera-retro',
            'fa fa-car' => 'fa fa-car',
            'fa fa-caret-square-o-down' => 'fa fa-caret-square-o-down',
            'fa fa-caret-square-o-left' => 'fa fa-caret-square-o-left',
            'fa fa-caret-square-o-right' => 'fa fa-caret-square-o-right',
            'fa fa-caret-square-o-up' => 'fa fa-caret-square-o-up',
            'fa fa-certificate' => 'fa fa-certificate',
            'fa fa-check' => 'fa fa-check',
            'fa fa-check-circle' => 'fa fa-check-circle',
            'fa fa-check-circle-o' => 'fa fa-check-circle-o',
            'fa fa-check-square' => 'fa fa-check-square',
            'fa fa-check-square-o' => 'fa fa-check-square-o',
            'fa fa-child' => 'fa fa-child',
            'fa fa-circle' => 'fa fa-circle',
            'fa fa-circle-o' => 'fa fa-circle-o',
            'fa fa-circle-o-notch' => 'fa fa-circle-o-notch',
            'fa fa-circle-thin' => 'fa fa-circle-thin',
            'fa fa-clock-o' => 'fa fa-clock-o',
            'fa fa-close' => 'fa fa-close',
            'fa fa-cloud' => 'fa fa-cloud',
            'fa fa-cloud-download' => 'fa fa-cloud-download',
            'fa fa-cloud-upload' => 'fa fa-cloud-upload',
            'fa fa-code' => 'fa fa-code',
            'fa fa-code-fork' => 'fa fa-code-fork',
            'fa fa-coffee' => 'fa fa-coffee',
            'fa fa-cog' => 'fa fa-cog',
            'fa fa-cogs' => 'fa fa-cogs',
            'fa fa-comment' => 'fa fa-comment',
            'fa fa-comment-o' => 'fa fa-comment-o',
            'fa fa-comments' => 'fa fa-comments',
            'fa fa-comments-o' => 'fa fa-comments-o',
            'fa fa-compass' => 'fa fa-compass',
            'fa fa-credit-card' => 'fa fa-credit-card',
            'fa fa-crop' => 'fa fa-crop',
            'fa fa-crosshairs' => 'fa fa-crosshairs',
            'fa fa-cube' => 'fa fa-cube',
            'fa fa-cubes' => 'fa fa-cubes',
            'fa fa-cutlery' => 'fa fa-cutlery',
            'fa fa-dashboard' => 'fa fa-dashboard',
            'fa fa-database' => 'fa fa-database',
            'fa fa-desktop' => 'fa fa-desktop',
            'fa fa-dot-circle-o' => 'fa fa-dot-circle-o',
            'fa fa-download' => 'fa fa-download',
            'fa fa-edit' => 'fa fa-edit',
            'fa fa-ellipsis-h' => 'fa fa-ellipsis-h',
            'fa fa-ellipsis-v' => 'fa fa-ellipsis-v',
            'fa fa-envelope' => 'fa fa-envelope',
            'fa fa-envelope-o' => 'fa fa-envelope-o',
            'fa fa-envelope-square' => 'fa fa-envelope-square',
            'fa fa-eraser' => 'fa fa-eraser',
            'fa fa-exchange' => 'fa fa-exchange',
            'fa fa-exclamation' => 'fa fa-exclamation',
            'fa fa-exclamation-circle' => 'fa fa-exclamation-circle',
            'fa fa-exclamation-triangle' => 'fa fa-exclamation-triangle',
            'fa fa-external-link' => 'fa fa-external-link',
            'fa fa-external-link-square' => 'fa fa-external-link-square',
            'fa fa-eye' => 'fa fa-eye',
            'fa fa-eye-slash' => 'fa fa-eye-slash',
            'fa fa-fax' => 'fa fa-fax',
            'fa fa-female' => 'fa fa-female',
            'fa fa-fighter-jet' => 'fa fa-fighter-jet',
            'fa fa-file-archive-o' => 'fa fa-file-archive-o',
            'fa fa-file-audio-o' => 'fa fa-file-audio-o',
            'fa fa-file-code-o' => 'fa fa-file-code-o',
            'fa fa-file-excel-o' => 'fa fa-file-excel-o',
            'fa fa-file-image-o' => 'fa fa-file-image-o',
            'fa fa-file-movie-o' => 'fa fa-file-movie-o',
            'fa fa-file-pdf-o' => 'fa fa-file-pdf-o',
            'fa fa-file-photo-o' => 'fa fa-file-photo-o',
            'fa fa-file-picture-o' => 'fa fa-file-picture-o',
            'fa fa-file-powerpoint-o' => 'fa fa-file-powerpoint-o',
            'fa fa-file-sound-o' => 'fa fa-file-sound-o',
            'fa fa-file-video-o' => 'fa fa-file-video-o',
            'fa fa-file-word-o' => 'fa fa-file-word-o',
            'fa fa-file-zip-o' => 'fa fa-file-zip-o',
            'fa fa-film' => 'fa fa-film',
            'fa fa-filter' => 'fa fa-filter',
            'fa fa-fire' => 'fa fa-fire',
            'fa fa-fire-extinguisher' => 'fa fa-fire-extinguisher',
            'fa fa-flag' => 'fa fa-flag',
            'fa fa-flag-checkered' => 'fa fa-flag-checkered',
            'fa fa-flag-o' => 'fa fa-flag-o',
            'fa fa-flash' => 'fa fa-flash',
            'fa fa-flask' => 'fa fa-flask',
            'fa fa-folder' => 'fa fa-folder',
            'fa fa-folder-o' => 'fa fa-folder-o',
            'fa fa-folder-open' => 'fa fa-folder-open',
            'fa fa-folder-open-o' => 'fa fa-folder-open-o',
            'fa fa-frown-o' => 'fa fa-frown-o',
            'fa fa-gamepad' => 'fa fa-gamepad',
            'fa fa-gavel' => 'fa fa-gavel',
            'fa fa-gear' => 'fa fa-gear',
            'fa fa-gears' => 'fa fa-gears',
            'fa fa-gift' => 'fa fa-gift',
            'fa fa-glass' => 'fa fa-glass',
            'fa fa-globe' => 'fa fa-globe',
            'fa fa-graduation-cap' => 'fa fa-graduation-cap',
            'fa fa-group' => 'fa fa-group',
            'fa fa-hdd-o' => 'fa fa-hdd-o',
            'fa fa-headphones' => 'fa fa-headphones',
            'fa fa-heart' => 'fa fa-heart',
            'fa fa-heart-o' => 'fa fa-heart-o',
            'fa fa-history' => 'fa fa-history',
            'fa fa-home' => 'fa fa-home',
            'fa fa-image' => 'fa fa-image',
            'fa fa-inbox' => 'fa fa-inbox',
            'fa fa-info' => 'fa fa-info',
            'fa fa-info-circle' => 'fa fa-info-circle',
            'fa fa-institution' => 'fa fa-institution',
            'fa fa-key' => 'fa fa-key',
            'fa fa-keyboard-o' => 'fa fa-keyboard-o',
            'fa fa-language' => 'fa fa-language',
            'fa fa-laptop' => 'fa fa-laptop',
            'fa fa-leaf' => 'fa fa-leaf',
            'fa fa-legal' => 'fa fa-legal',
            'fa fa-lemon-o' => 'fa fa-lemon-o',
            'fa fa-level-down' => 'fa fa-level-down',
            'fa fa-level-up' => 'fa fa-level-up',
            'fa fa-life-bouy' => 'fa fa-life-bouy',
            'fa fa-life-buoy' => 'fa fa-life-buoy',
            'fa fa-life-ring' => 'fa fa-life-ring',
            'fa fa-life-saver' => 'fa fa-life-saver',
            'fa fa-lightbulb-o' => 'fa fa-lightbulb-o',
            'fa fa-location-arrow' => 'fa fa-location-arrow',
            'fa fa-lock' => 'fa fa-lock',
            'fa fa-magic' => 'fa fa-magic',
            'fa fa-magnet' => 'fa fa-magnet',
            'fa fa-mail-forward' => 'fa fa-mail-forward',
            'fa fa-mail-reply' => 'fa fa-mail-reply',
            'fa fa-mail-reply-all' => 'fa fa-mail-reply-all',
            'fa fa-male' => 'fa fa-male',
            'fa fa-map-marker' => 'fa fa-map-marker',
            'fa fa-meh-o' => 'fa fa-meh-o',
            'fa fa-microphone' => 'fa fa-microphone',
            'fa fa-microphone-slash' => 'fa fa-microphone-slash',
            'fa fa-minus' => 'fa fa-minus',
            'fa fa-minus-circle' => 'fa fa-minus-circle',
            'fa fa-minus-square' => 'fa fa-minus-square',
            'fa fa-minus-square-o' => 'fa fa-minus-square-o',
            'fa fa-mobile' => 'fa fa-mobile',
            'fa fa-mobile-phone' => 'fa fa-mobile-phone',
            'fa fa-money' => 'fa fa-money',
            'fa fa-moon-o' => 'fa fa-moon-o',
            'fa fa-mortar-board' => 'fa fa-mortar-board',
            'fa fa-music' => 'fa fa-music',
            'fa fa-navicon' => 'fa fa-navicon',
            'fa fa-paper-plane' => 'fa fa-paper-plane',
            'fa fa-paper-plane-o' => 'fa fa-paper-plane-o',
            'fa fa-paw' => 'fa fa-paw',
            'fa fa-pencil' => 'fa fa-pencil',
            'fa fa-pencil-square' => 'fa fa-pencil-square',
            'fa fa-pencil-square-o' => 'fa fa-pencil-square-o',
            'fa fa-phone' => 'fa fa-phone',
            'fa fa-phone-square' => 'fa fa-phone-square',
            'fa fa-photo' => 'fa fa-photo',
            'fa fa-picture-o' => 'fa fa-picture-o',
            'fa fa-plane' => 'fa fa-plane',
            'fa fa-plus' => 'fa fa-plus',
            'fa fa-plus-circle' => 'fa fa-plus-circle',
            'fa fa-plus-square' => 'fa fa-plus-square',
            'fa fa-plus-square-o' => 'fa fa-plus-square-o',
            'fa fa-power-off' => 'fa fa-power-off',
            'fa fa-print' => 'fa fa-print',
            'fa fa-puzzle-piece' => 'fa fa-puzzle-piece',
            'fa fa-qrcode' => 'fa fa-qrcode',
            'fa fa-question' => 'fa fa-question',
            'fa fa-question-circle' => 'fa fa-question-circle',
            'fa fa-quote-left' => 'fa fa-quote-left',
            'fa fa-quote-right' => 'fa fa-quote-right',
            'fa fa-random' => 'fa fa-random',
            'fa fa-recycle' => 'fa fa-recycle',
            'fa fa-refresh' => 'fa fa-refresh',
            'fa fa-remove' => 'fa fa-remove',
            'fa fa-reorder' => 'fa fa-reorder',
            'fa fa-reply' => 'fa fa-reply',
            'fa fa-reply-all' => 'fa fa-reply-all',
            'fa fa-retweet' => 'fa fa-retweet',
            'fa fa-road' => 'fa fa-road',
            'fa fa-rocket' => 'fa fa-rocket',
            'fa fa-rss' => 'fa fa-rss',
            'fa fa-rss-square' => 'fa fa-rss-square',
            'fa fa-search' => 'fa fa-search',
            'fa fa-search-minus' => 'fa fa-search-minus',
            'fa fa-search-plus' => 'fa fa-search-plus',
            'fa fa-send' => 'fa fa-send',
            'fa fa-send-o' => 'fa fa-send-o',
            'fa fa-share' => 'fa fa-share',
            'fa fa-share-alt' => 'fa fa-share-alt',
            'fa fa-share-alt-square' => 'fa fa-share-alt-square',
            'fa fa-share-square' => 'fa fa-share-square',
            'fa fa-share-square-o' => 'fa fa-share-square-o',
            'fa fa-shield' => 'fa fa-shield',
            'fa fa-shopping-cart' => 'fa fa-shopping-cart',
            'fa fa-sign-in' => 'fa fa-sign-in',
            'fa fa-sign-out' => 'fa fa-sign-out',
            'fa fa-signal' => 'fa fa-signal',
            'fa fa-sitemap' => 'fa fa-sitemap',
            'fa fa-sliders' => 'fa fa-sliders',
            'fa fa-smile-o' => 'fa fa-smile-o',
            'fa fa-sort' => 'fa fa-sort',
            'fa fa-sort-alpha-asc' => 'fa fa-sort-alpha-asc',
            'fa fa-sort-alpha-desc' => 'fa fa-sort-alpha-desc',
            'fa fa-sort-amount-asc' => 'fa fa-sort-amount-asc',
            'fa fa-sort-amount-desc' => 'fa fa-sort-amount-desc',
            'fa fa-sort-asc' => 'fa fa-sort-asc',
            'fa fa-sort-desc' => 'fa fa-sort-desc',
            'fa fa-sort-down' => 'fa fa-sort-down',
            'fa fa-sort-numeric-asc' => 'fa fa-sort-numeric-asc',
            'fa fa-sort-numeric-desc' => 'fa fa-sort-numeric-desc',
            'fa fa-sort-up' => 'fa fa-sort-up',
            'fa fa-space-shuttle' => 'fa fa-space-shuttle',
            'fa fa-spinner' => 'fa fa-spinner',
            'fa fa-spoon' => 'fa fa-spoon',
            'fa fa-square' => 'fa fa-square',
            'fa fa-square-o' => 'fa fa-square-o',
            'fa fa-star' => 'fa fa-star',
            'fa fa-star-half' => 'fa fa-star-half',
            'fa fa-star-half-empty' => 'fa fa-star-half-empty',
            'fa fa-star-half-full' => 'fa fa-star-half-full',
            'fa fa-star-half-o' => 'fa fa-star-half-o',
            'fa fa-star-o' => 'fa fa-star-o',
            'fa fa-suitcase' => 'fa fa-suitcase',
            'fa fa-sun-o' => 'fa fa-sun-o',
            'fa fa-support' => 'fa fa-support',
            'fa fa-tablet' => 'fa fa-tablet',
            'fa fa-tachometer' => 'fa fa-tachometer',
            'fa fa-tag' => 'fa fa-tag',
            'fa fa-tags' => 'fa fa-tags',
            'fa fa-tasks' => 'fa fa-tasks',
            'fa fa-taxi' => 'fa fa-taxi',
            'fa fa-terminal' => 'fa fa-terminal',
            'fa fa-thumb-tack' => 'fa fa-thumb-tack',
            'fa fa-thumbs-down' => 'fa fa-thumbs-down',
            'fa fa-thumbs-o-down' => 'fa fa-thumbs-o-down',
            'fa fa-thumbs-o-up' => 'fa fa-thumbs-o-up',
            'fa fa-thumbs-up' => 'fa fa-thumbs-up',
            'fa fa-ticket' => 'fa fa-ticket',
            'fa fa-times' => 'fa fa-times',
            'fa fa-times-circle' => 'fa fa-times-circle',
            'fa fa-times-circle-o' => 'fa fa-times-circle-o',
            'fa fa-tint' => 'fa fa-tint',
            'fa fa-toggle-down' => 'fa fa-toggle-down',
            'fa fa-toggle-left' => 'fa fa-toggle-left',
            'fa fa-toggle-right' => 'fa fa-toggle-right',
            'fa fa-toggle-up' => 'fa fa-toggle-up',
            'fa fa-trash-o' => 'fa fa-trash-o',
            'fa fa-tree' => 'fa fa-tree',
            'fa fa-trophy' => 'fa fa-trophy',
            'fa fa-truck' => 'fa fa-truck',
            'fa fa-umbrella' => 'fa fa-umbrella',
            'fa fa-university' => 'fa fa-university',
            'fa fa-unlock' => 'fa fa-unlock',
            'fa fa-unlock-alt' => 'fa fa-unlock-alt',
            'fa fa-unsorted' => 'fa fa-unsorted',
            'fa fa-upload' => 'fa fa-upload',
            'fa fa-user' => 'fa fa-user',
            'fa fa-users' => 'fa fa-users',
            'fa fa-video-camera' => 'fa fa-video-camera',
            'fa fa-volume-down' => 'fa fa-volume-down',
            'fa fa-volume-off' => 'fa fa-volume-off',
            'fa fa-volume-up' => 'fa fa-volume-up',
            'fa fa-warning' => 'fa fa-warning',
            'fa fa-wheelchair' => 'fa fa-wheelchair',
            'fa fa-wrench' => 'fa fa-wrench',
            'fa fa-file' => 'fa fa-file',
            'fa fa-file-o' => 'fa fa-file-o',
            'fa fa-file-text' => 'fa fa-file-text',
            'fa fa-file-text-o' => 'fa fa-file-text-o',
            'fa fa-bitcoin' => 'fa fa-bitcoin',
            'fa fa-btc' => 'fa fa-btc',
            'fa fa-cny' => 'fa fa-cny',
            'fa fa-dollar' => 'fa fa-dollar',
            'fa fa-eur' => 'fa fa-eur',
            'fa fa-euro' => 'fa fa-euro',
            'fa fa-gbp' => 'fa fa-gbp',
            'fa fa-inr' => 'fa fa-inr',
            'fa fa-jpy' => 'fa fa-jpy',
            'fa fa-krw' => 'fa fa-krw',
            'fa fa-rmb' => 'fa fa-rmb',
            'fa fa-rouble' => 'fa fa-rouble',
            'fa fa-rub' => 'fa fa-rub',
            'fa fa-ruble' => 'fa fa-ruble',
            'fa fa-rupee' => 'fa fa-rupee',
            'fa fa-try' => 'fa fa-try',
            'fa fa-turkish-lira' => 'fa fa-turkish-lira',
            'fa fa-usd' => 'fa fa-usd',
            'fa fa-won' => 'fa fa-won',
            'fa fa-yen' => 'fa fa-yen',
            'fa fa-align-center' => ' fa fa-align-center',
            'fa fa-align-justify' => 'fa fa-align-justify',
            'fa fa-align-left' => 'fa fa-align-left',
            'fa fa-align-right' => 'fa fa-align-right',
            'fa fa-bold' => 'fa fa-bold',
            'fa fa-chain' => 'fa fa-chain',
            'fa fa-chain-broken' => 'fa fa-chain-broken',
            'fa fa-clipboard' => 'fa fa-clipboard',
            'fa fa-columns' => 'fa fa-columns',
            'fa fa-copy' => 'fa fa-copy',
            'fa fa-cut' => 'fa fa-cut',
            'fa fa-dedent' => 'fa fa-dedent',
            'fa fa-files-o' => 'fa fa-files-o',
            'fa fa-floppy-o' => 'fa fa-floppy-o',
            'fa fa-font' => 'fa fa-font',
            'fa fa-header' => 'fa fa-header',
            'fa fa-indent' => 'fa fa-indent',
            'fa fa-italic' => 'fa fa-italic',
            'fa fa-link' => 'fa fa-link',
            'fa fa-list' => 'fa fa-list',
            'fa fa-list-alt' => 'fa fa-list-alt',
            'fa fa-list-ol' => 'fa fa-list-ol',
            'fa fa-list-ul' => 'fa fa-list-ul',
            'fa fa-outdent' => 'fa fa-outdent',
            'fa fa-paperclip' => 'fa fa-paperclip',
            'fa fa-paragraph' => 'fa fa-paragraph',
            'fa fa-paste' => 'fa fa-paste',
            'fa fa-repeat' => 'fa fa-repeat',
            'fa fa-rotate-left' => 'fa fa-rotate-left',
            'fa fa-rotate-right' => 'fa fa-rotate-right',
            'fa fa-save' => 'fa fa-save',
            'fa fa-scissors' => 'fa fa-scissors',
            'fa fa-strikethrough' => 'fa fa-strikethrough',
            'fa fa-subscript' => 'fa fa-subscript',
            'fa fa-superscript' => 'fa fa-superscript',
            'fa fa-table' => 'fa fa-table',
            'fa fa-text-height' => 'fa fa-text-height',
            'fa fa-text-width' => 'fa fa-text-width',
            'fa fa-th' => 'fa fa-th',
            'fa fa-th-large' => 'fa fa-th-large',
            'fa fa-th-list' => 'fa fa-th-list',
            'fa fa-underline' => 'fa fa-underline',
            'fa fa-undo' => 'fa fa-undo',
            'fa fa-unlink' => 'fa fa-unlink',
            'fa fa-angle-double-down' => ' fa fa-angle-double-down',
            'fa fa-angle-double-left' => 'fa fa-angle-double-left',
            'fa fa-angle-double-right' => 'fa fa-angle-double-right',
            'fa fa-angle-double-up' => 'fa fa-angle-double-up',
            'fa fa-angle-down' => 'fa fa-angle-down',
            'fa fa-angle-left' => 'fa fa-angle-left',
            'fa fa-angle-right' => 'fa fa-angle-right',
            'fa fa-angle-up' => 'fa fa-angle-up',
            'fa fa-arrow-circle-down' => 'fa fa-arrow-circle-down',
            'fa fa-arrow-circle-left' => 'fa fa-arrow-circle-left',
            'fa fa-arrow-circle-o-down' => 'fa fa-arrow-circle-o-down',
            'fa fa-arrow-circle-o-left' => 'fa fa-arrow-circle-o-left',
            'fa fa-arrow-circle-o-right' => 'fa fa-arrow-circle-o-right',
            'fa fa-arrow-circle-o-up' => 'fa fa-arrow-circle-o-up',
            'fa fa-arrow-circle-right' => 'fa fa-arrow-circle-right',
            'fa fa-arrow-circle-up' => 'fa fa-arrow-circle-up',
            'fa fa-arrow-down' => 'fa fa-arrow-down',
            'fa fa-arrow-left' => 'fa fa-arrow-left',
            'fa fa-arrow-right' => 'fa fa-arrow-right',
            'fa fa-arrow-up' => 'fa fa-arrow-up',
            'fa fa-arrows-alt' => 'fa fa-arrows-alt',
            'fa fa-caret-down' => 'fa fa-caret-down',
            'fa fa-caret-left' => 'fa fa-caret-left',
            'fa fa-caret-right' => 'fa fa-caret-right',
            'fa fa-caret-up' => 'fa fa-caret-up',
            'fa fa-chevron-circle-down' => 'fa fa-chevron-circle-down',
            'fa fa-chevron-circle-left' => 'fa fa-chevron-circle-left',
            'fa fa-chevron-circle-right' => 'fa fa-chevron-circle-right',
            'fa fa-chevron-circle-up' => 'fa fa-chevron-circle-up',
            'fa fa-chevron-down' => 'fa fa-chevron-down',
            'fa fa-chevron-left' => 'fa fa-chevron-left',
            'fa fa-chevron-right' => 'fa fa-chevron-right',
            'fa fa-chevron-up' => 'fa fa-chevron-up',
            'fa fa-hand-o-down' => 'fa fa-hand-o-down',
            'fa fa-hand-o-left' => 'fa fa-hand-o-left',
            'fa fa-hand-o-right' => 'fa fa-hand-o-right',
            'fa fa-hand-o-up' => 'fa fa-hand-o-up',
            'fa fa-long-arrow-down' => 'fa fa-long-arrow-down',
            'fa fa-long-arrow-left' => 'fa fa-long-arrow-left',
            'fa fa-long-arrow-right' => 'fa fa-long-arrow-right',
            'fa fa-long-arrow-up' => 'fa fa-long-arrow-up',
            'fa fa-backward' => 'fa fa-backward',
            'fa fa-compress' => 'fa fa-compress',
            'fa fa-eject' => 'fa fa-eject',
            'fa fa-expand' => 'fa fa-expand',
            'fa fa-fast-backward' => 'fa fa-fast-backward',
            'fa fa-fast-forward' => 'fa fa-fast-forward',
            'fa fa-forward' => 'fa fa-forward',
            'fa fa-pause' => 'fa fa-pause',
            'fa fa-play' => 'fa fa-play',
            'fa fa-play-circle' => 'fa fa-play-circle',
            'fa fa-play-circle-o' => 'fa fa-play-circle-o',
            'fa fa-step-backward' => 'fa fa-step-backward',
            'fa fa-step-forward' => 'fa fa-step-forward',
            'fa fa-stop' => 'fa fa-stop',
            'fa fa-youtube-play' => 'fa fa-youtube-play'
            );

            $this->sections[] = array(
                'icon' => 'el-icon-comment',
                'title' => __('Blog Settings', 'trend'),
                'fields' => array(
                    array(
                        'id'   => 'mt_divider_blog_archive_layout',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Blog Archive Layout</h3>', 'trend' )
                    ),
                    array(
                        'id'       => 'trend_blog_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Blog List Layout', 'trend' ),
                        'subtitle' => __( 'Select Blog List layout.', 'trend' ),
                        'options'  => array(
                            'trend_blog_left_sidebar' => array(
                                'alt' => '2 Columns - Left sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-left.jpg'
                            ),
                            'trend_blog_fullwidth' => array(
                                'alt' => '1 Column - Full width',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                            ),
                            'trend_blog_right_sidebar' => array(
                                'alt' => '2 Columns - Right sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-right.jpg'
                            )
                        ),
                        'default'  => 'trend_blog_fullwidth'
                    ),
                    array(
                        'id'       => 'trend_blog_layout_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => __( 'Blog List Sidebar', 'trend' ),
                        'subtitle' => __( 'Select Blog List Sidebar.', 'trend' ),
                        'default'   => 'sidebar-1',
                        'required' => array('trend_blog_layout', '!=', 'trend_blog_fullwidth'),
                    ),
                    array(
                        'id'        => 'blog-display-type',
                        'type'      => 'select',
                        'title'     => __('How to display posts', 'trend'),
                        'subtitle'  => __('Select how you want to display post on blog list.', 'trend'),
                        'options'   => array(
                                'list'   => 'List',
                                'grid'   => 'Grid'
                            ),
                        'default'   => 'list',
                    ),
                    array(
                        'id'        => 'blog-grid-columns',
                        'type'      => 'select',
                        'title'     => __('Grid columns', 'trend'),
                        'subtitle'  => __('Select how many columns you want.', 'trend'),
                        'options'   => array(
                                '1'   => '1',
                                '2'   => '2',
                                '3'   => '3',
                                '4'   => '4'
                            ),
                        'default'   => '1',
                        'required' => array('blog-display-type', 'equals', 'grid'),
                    ),
                    array(
                        'id'       => 'trend-enable-sticky',
                        'type'     => 'switch', 
                        'title'    => __('Sticky Posts', 'trend'),
                        'subtitle' => __('Enable or disable "sticky posts" section on blog page', 'trend'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'post-text-format-icon',
                        'type'     => 'select',
                        'select2'  => array( 'containerCssClass' => 'fa' ),
                        'title'    => 'Icon for text post format',
                        'subtitle' => 'Select a icon to show for post text format.',
                        // 'class'    => ' font-icons fa',
                        'options'  => $icons,
                        'default'  => 'fa fa-file-text-o'
                    ),
                    array(
                        'id'       => 'post-image-format-icon',
                        'type'     => 'select',
                        'select2'  => array( 'containerCssClass' => 'fa' ),
                        'title'    => 'Icon for image post format',
                        'subtitle' => 'Select a icon to show for post image format.',
                        // 'class'    => ' font-icons fa',
                        'options'  => $icons,
                        'default'  => 'fa fa-file-image-o'
                    ),
                    array(
                        'id'       => 'post-video-format-icon',
                        'type'     => 'select',
                        'select2'  => array( 'containerCssClass' => 'fa' ),
                        'title'    => 'Icon for video post format',
                        'subtitle' => 'Select a icon to show for post video format.',
                        // 'class'    => ' font-icons fa',
                        'options'  => $icons,
                        'default'  => 'fa fa-file-video-o'
                    ),
                    array(
                        'id'       => 'post-quote-format-icon',
                        'type'     => 'select',
                        'select2'  => array( 'containerCssClass' => 'fa' ),
                        'title'    => 'Icon for quote post format',
                        'subtitle' => 'Select a icon to show for post quote format.',
                        // 'class'    => ' font-icons fa',
                        'options'  => $icons,
                        'default'  => 'fa fa-quote-left'
                    ),
                    array(
                        'id'       => 'post-link-format-icon',
                        'type'     => 'select',
                        'select2'  => array( 'containerCssClass' => 'fa' ),
                        'title'    => 'Icon for link post format',
                        'subtitle' => 'Select a icon to show for post link format.',
                        // 'class'    => ' font-icons fa',
                        'options'  => $icons,
                        'default'  => 'fa fa-link'
                    ),

                    array(
                        'id'   => 'mt_divider_blog_single_layout',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Blog Single Article Layout</h3>', 'trend' )
                    ),
                    array(
                        'id'       => 'trend_single_blog_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Single Blog Layout', 'trend' ),
                        'subtitle' => __( 'Select Single Blog Layout.', 'trend' ),
                        'options'  => array(
                            'trend_blog_left_sidebar' => array(
                                'alt' => '2 Columns - Left sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-left.jpg'
                            ),
                            'trend_blog_fullwidth' => array(
                                'alt' => '1 Column - Full width',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                            ),
                            'trend_blog_right_sidebar' => array(
                                'alt' => '2 Columns - Right sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-right.jpg'
                            )
                        ),
                        'default'  => 'trend_blog_fullwidth',
                        ),
                    array(
                        'id'       => 'trend_single_blog_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => __( 'Single Blog Sidebar', 'trend' ),
                        'subtitle' => __( 'Select Single Blog Sidebar.', 'trend' ),
                        'default'   => 'sidebar-1',
                        'required' => array('trend_single_blog_layout', '!=', 'trend_blog_fullwidth'),
                    ),

                    array(
                        'id'   => 'mt_divider_blog_single_tyography',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => __( '<h3>Blog Single Article Typography</h3>', 'trend' )
                    ),
                    array(
                        'id'          => 'trend-blog-post-typography',
                        'type'        => 'typography', 
                        'title'       => __('Blog Post Font family', 'trend'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => false,
                        'font-weight'  => false,
                        'font-size'   => false,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('p'),
                        'units'       =>'px',
                        //'subtitle'    => __('Typography option with each property can be called individually.', 'redux-framework-demo'),
                        'default'     => array(
                            'font-family' => 'Roboto', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'       => 'post_featured_image',
                        'type'     => 'switch', 
                        'title'    => __('Enable/disable featured image for single post.', 'trend'),
                        'subtitle' => __('Show or Hide the featured image from blog post page.".', 'trend'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'trend-enable-related-posts',
                        'type'     => 'switch', 
                        'title'    => __('Related Posts', 'trend'),
                        'subtitle' => __('Enable or disable related posts', 'trend'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'trend-enable-post-navigation',
                        'type'     => 'switch', 
                        'title'    => __('Post Navigation', 'trend'),
                        'subtitle' => __('Enable or disable post navigation', 'trend'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'trend-enable-authorbio',
                        'type'     => 'switch', 
                        'title'    => __('About Author', 'trend'),
                        'subtitle' => __('Enable or disable "About author" section on single post', 'trend'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'trend-enable-posttype-icon',
                        'type'     => 'switch', 
                        'title'    => __('Post type icons', 'trend'),
                        'subtitle' => __('Enable or Disable Post Type icons from the blog', 'trend'),
                        'default'  => false,
                    ),


                )
            );


            # Section: Shop Settings

            $this->sections[] = array(
                'icon' => 'el-icon-shopping-cart-sign',
                'title' => __('Shop Settings', 'trend'),
                'fields' => array(
                     array(
                            'id'       => 'trend_shop_layout',
                            'type'     => 'image_select',
                            'compiler' => true,
                            'title'    => __( 'Shop List Products Layout', 'trend' ),
                            'subtitle' => __( 'Select Shop List Products layout.', 'trend' ),
                            'options'  => array(
                                'trend_shop_left_sidebar' => array(
                                    'alt' => '2 Columns - Left sidebar',
                                    'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-left.jpg'
                                ),
                                'trend_shop_fullwidth' => array(
                                    'alt' => '1 Column - Full width',
                                    'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                                ),
                                'trend_shop_right_sidebar' => array(
                                    'alt' => '2 Columns - Right sidebar',
                                    'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-right.jpg'
                                )
                            ),
                            'default'  => 'trend_shop_right_sidebar'
                        ),
                    array(
                        'id'       => 'trend_shop_layout_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => __( 'Shop List Sidebar', 'trend' ),
                        'subtitle' => __( 'Select Shop List Sidebar.', 'trend' ),
                        'default'   => 'sidebar-1',
                        'required' => array('trend_shop_layout', '!=', 'trend_shop_fullwidth'),
                    ),
                    array(
                        'id'        => 'trend-shop-columns',
                        'type'      => 'select',
                        'title'     => __('Number of shop columns', 'trend'),
                        'subtitle'  => __('Number of products per column to show on shop list template.', 'trend'),
                        'options'   => array(
                            '2'   => '2 columns',
                            '3'   => '3 columns',
                            '4'   => '4 columns'
                        ),
                        'default'   => '3',
                    ),
                     array(
                        'id'       => 'trend_single_product_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Single Product Layout', 'trend' ),
                        'subtitle' => __( 'Select Single Product Layout.', 'trend' ),
                        'options'  => array(
                            'trend_shop_left_sidebar' => array(
                                'alt' => '2 Columns - Left sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-left.jpg'
                            ),
                            'trend_shop_fullwidth' => array(
                                'alt' => '1 Column - Full width',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                            ),
                            'trend_shop_right_sidebar' => array(
                                'alt' => '2 Columns - Right sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-right.jpg'
                            )
                        ),
                        'default'  => 'trend_shop_right_sidebar'
                    ),
                    array(
                        'id'       => 'trend_single_shop_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => __( 'Shop Single Product Sidebar', 'trend' ),
                        'subtitle' => __( 'Select Shop List Sidebar.', 'trend' ),
                        'default'   => 'sidebar-1',
                        'required' => array('trend_single_product_layout', '!=', 'trend_shop_fullwidth'),
                    ),
                    array(
                        'id'       => 'is_add_to_compare_active',
                        'type'     => 'switch', 
                        'title'    => __('Enable/disable compare products feature', 'trend'),
                        'subtitle' => __('Show or Hide "Add to Compare" button for shop".', 'trend'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'is_add_to_wishlist_active',
                        'type'     => 'switch', 
                        'title'    => __('Enable/disable wishlist feature', 'trend'),
                        'subtitle' => __('Show or Hide "Add to Wishlist" button and Header Wishlist link".', 'trend'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'is_quick_view_active',
                        'type'     => 'switch', 
                        'title'    => __('Enable/disable shop Quick View', 'trend'),
                        'subtitle' => __('Show or Hide "Quick View" button from the shop".', 'trend'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'trend-enable-related-products',
                        'type'     => 'switch', 
                        'title'    => __('Related Products', 'trend'),
                        'subtitle' => __('Enable or disable related products on single product', 'trend'),
                        'default'  => true,
                    ),
                    array(
                        'id'        => 'trend-related-products-number',
                        'type'      => 'select',
                        'title'     => __('Number of related products', 'trend'),
                        'subtitle'  => __('Number of related products to show on single product template.', 'trend'),
                        'options'   => array(
                            '2'   => '3',
                            '3'   => '6',
                            '4'   => '9'
                        ),
                        'default'   => '3',
                        'required' => array('trend-enable-related-products', '=', true),
                    ),
                )
            );


            # Section: 404 Page Settings
            $this->sections[] = array(
                'icon' => 'el-icon-error',
                'title' => __('404 Page Settings', 'trend'),
                'fields' => array(
                    array(
                        'id' => 'img_404',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Image for 404 Not found page', 'trend'),
                        'compiler' => 'true',
                        'default' => array('url' => get_template_directory_uri().'/images/404.png'),
                    )
                )
            );


            # Section: Social Media Settings
            $this->sections[] = array(
                'icon' => 'el-icon-myspace',
                'title' => __('Social Media Settings', 'trend'),
                'fields' => array(
                    array(
                        'id' => 'trend_social_fb',
                        'type' => 'text',
                        'title' => __('Facebook URL', 'trend'),
                        'subtitle' => __('Type your Facebook url.', 'trend'),
                        'validate' => 'url',
                        'default' => 'http://facebook.com'
                    ),
                    array(
                        'id' => 'trend_social_tw',
                        'type' => 'text',
                        'title' => __('Twitter username', 'trend'),
                        'subtitle' => __('Type your Twitter username.', 'trend'),
                        'default' => 'google'
                    ),
                    array(
                        'id' => 'trend_social_pinterest',
                        'type' => 'text',
                        'title' => __('Pinterest URL', 'trend'),
                        'subtitle' => __('Type your Pinterest url.', 'trend'),
                        'validate' => 'url',
                        'default' => 'http://pinterest.com'
                    ),
                    array(
                        'id' => 'trend_social_skype',
                        'type' => 'text',
                        'title' => __('Skype Name', 'trend'),
                        'subtitle' => __('Type your Skype username.', 'trend'),
                        //'validate' => 'preg_replace',
                        'default' => 'modeltheme'
                    ),
                    array(
                        'id' => 'trend_social_instagram',
                        'type' => 'text',
                        'title' => __('Instagram URL', 'trend'),
                        'subtitle' => __('Type your Instagram url.', 'trend'),
                        'validate' => 'url',
                        'default' => 'http://instagram.com'
                    ),
                    array(
                        'id' => 'trend_social_youtube',
                        'type' => 'text',
                        'title' => __('YouTube URL', 'trend'),
                        'subtitle' => __('Type your YouTube url.', 'trend'),
                        'validate' => 'url',
                        'default' => 'http://youtube.com'
                    ),
                    array(
                        'id' => 'trend_social_dribbble',
                        'type' => 'text',
                        'title' => __('Dribbble URL', 'trend'),
                        'subtitle' => __('Type your Dribbble url.', 'trend'),
                        'validate' => 'url',
                        'default' => 'http://dribbble.com'
                    ),
                    array(
                        'id' => 'trend_social_gplus',
                        'type' => 'text',
                        'title' => __('Google+ URL', 'trend'),
                        'subtitle' => __('Type your Google+ url.', 'trend'),
                        'validate' => 'url',
                        'default' => 'http://plus.google.com'
                    ),
                    array(
                        'id' => 'trend_social_linkedin',
                        'type' => 'text',
                        'title' => __('LinkedIn URL', 'trend'),
                        'subtitle' => __('Type your LinkedIn url.', 'trend'),
                        'validate' => 'url',
                        'default' => 'http://linkedin.com'
                    ),
                    array(
                        'id' => 'trend_social_deviantart',
                        'type' => 'text',
                        'title' => __('Deviant Art URL', 'trend'),
                        'subtitle' => __('Type your Deviant Art url.', 'trend'),
                        'validate' => 'url',
                        'default' => 'http://deviantart.com'
                    ),
                    array(
                        'id' => 'trend_social_digg',
                        'type' => 'text',
                        'title' => __('Digg URL', 'trend'),
                        'subtitle' => __('Type your Digg url.', 'trend'),
                        'validate' => 'url'
                    ),
                    array(
                        'id' => 'trend_social_flickr',
                        'type' => 'text',
                        'title' => __('Flickr URL', 'trend'),
                        'subtitle' => __('Type your Flickr url.', 'trend'),
                        'validate' => 'url'
                    ),
                    array(
                        'id' => 'trend_social_stumbleupon',
                        'type' => 'text',
                        'title' => __('Stumbleupon URL', 'trend'),
                        'subtitle' => __('Type your Stumbleupon url.', 'trend'),
                        'validate' => 'url'
                    ),
                    array(
                        'id' => 'trend_social_tumblr',
                        'type' => 'text',
                        'title' => __('Tumblr URL', 'trend'),
                        'subtitle' => __('Type your Tumblr url.', 'trend'),
                        'validate' => 'url'
                    ),
                    array(
                        'id' => 'trend_social_vimeo',
                        'type' => 'text',
                        'title' => __('Vimeo URL', 'trend'),
                        'subtitle' => __('Type your Vimeo url.', 'trend'),
                        'validate' => 'url'
                    ),
                    array(
                        'id' => 'trend_tw_consumer_key',
                        'type' => 'text',
                        'title' => __('Twitter Consumer Key', 'trend'),
                        'subtitle' => __('Type your Twitter Consumer key.', 'trend'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'trend_tw_consumer_secret',
                        'type' => 'text',
                        'title' => __('Twitter Consumer Secret key', 'trend'),
                        'subtitle' => __('Type your Twitter Consumer Secret key.', 'trend'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'trend_tw_access_token',
                        'type' => 'text',
                        'title' => __('Twitter Access Token', 'trend'),
                        'subtitle' => __('Type your Access Token.', 'trend'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'trend_tw_access_token_secret',
                        'type' => 'text',
                        'title' => __('Twitter Access Token Secret', 'trend'),
                        'subtitle' => __('Type your Twitter Access Token Secret.', 'trend'),
                        'default' => ''
                    )

                )
            );

            /* Section #8: SEO Settings */


            /* Section: MailChimp Newsletter Settings */
            $this->sections[] = array(
                'icon' => 'el-icon-envelope-alt',
                'title' => __('MailChimp Newsletter', 'trend'),
                'fields' => array(
                    array(
                        'id' => 'trend_mailchimp_apikey',
                        'type' => 'text',
                        'title' => __('Mailchimp apiKey', 'trend'),
                        'subtitle' => __('To enable Mailchimp please type in your apiKey', 'trend'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'trend_mailchimp_listid',
                        'type' => 'text',
                        'title' => __('Mailchimp listId', 'trend'),
                        'subtitle' => __('To enable Mailchimp please type in your listId', 'trend'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'trend_mailchimp_data_center',
                        'type' => 'text',
                        'title' => __('Mailchimp form datacenter', 'trend'),
                        'subtitle' => __('To enable Mailchimp please type in your form datacenter', 'trend'),
                        'default' => ''
                    )
                )
            );
            $theme_info = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'trend') . '<a href="' . esc_url($this->theme->get('ThemeURI')) . '" target="_blank">' . wp_kses_post($this->theme->get('ThemeURI')) . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'trend') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'trend') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . wp_kses_post($this->theme->get('Description')) . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'trend') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-1',
                'title' => __('', 'trend'),
                'content' => __('', 'trend')
            );

            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-2',
                'title' => __('', 'trend'),
                'content' => __('', 'trend')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('', 'trend');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'redux_demo', // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'), // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'), // Version that appears at the top of your panel
                'menu_type' => 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true, // Show the sections below the admin menu item or not
                'menu_title' => __('Theme Panel', 'trend'),
                'page' => __('Theme Panel', 'trend'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                'admin_bar' => false, // Show the panel pages on the admin bar
                'global_variable' => 'trend_redux', // Set a different name for your global variable other than the opt_name
                'dev_mode' => false, // Show the time the page took to load, etc
                'customizer' => true, // Enable basic customizer support
                // OPTIONAL -> Give you extra features
                'page_priority' => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php', // For a full list of options, visit: http://codex.WordPress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
                'menu_icon' => get_template_directory_uri().'/images/trend.jpg', // Specify a custom URL to an icon
                'last_tab' => '', // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options', // Page slug used to denote the panel
                'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
                'default_show' => false, // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                'domain'              => 'trend', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'show_import_export' => true, // REMOVE
                'system_info' => false, // REMOVE
                'help_tabs' => array(),
                'help_sidebar' => '', // __( '', $this->args['domain'] );            
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace("-", "_", $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('', 'trend'), $v);
            } else {
                $this->args['intro_text'] = __('', 'trend');
            }

            // Add content after the form.
            $this->args['footer_text'] = __('', 'trend');
        }

    }

    new Redux_Framework_trend_config();
}


/**

  Custom function for the callback referenced above

 */
if (!function_exists('redux_my_custom_field')):

    function redux_my_custom_field($field, $value) {
        print_r($field);
        print_r($value);
    }

endif;

/**

  Custom function for the callback validation referenced above

 * */
if (!function_exists('redux_validate_callback_function')):

    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }


endif;
