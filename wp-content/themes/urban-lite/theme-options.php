<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('czs_Redux_Framework_config')) {

    class czs_Redux_Framework_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

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

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo '<h1>The compiler hook has run!';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'czs'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'czs'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

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
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'czs'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','czs'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','czs'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'czs'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'czs'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'czs') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'czs') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'czs'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            $this->sections[] = array(
                'title' => __('General Settings', 'czs'),
                'icon' => 'el-icon-home',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(
                    array(
                        'id'    => 'czs_general_success',
                        'type'  => 'info',
                        'style' => 'success',
                        'icon'  => 'el-icon-bell',
                        'title' => 'Urban Pro General Settings Features',
                        'desc'  => '<strong>Premium Features</strong>: Tracking Code, Header Code, Custom Header Logo, Custom Footer Logo, Custom Copyright Text, Carousel, Pagination (Infinite, Numbered)'
                    ),
                    array(
                        'id' => 'czs_spacing',
                        'type' => 'spacing',
                        'output' => array('.header-logo'), 
                        'mode' => 'padding', // absolute, padding, margin, defaults to padding
                        //'top' => false, // Disable the top
                        //'right' => false, // Disable the right
                        //'bottom' => false, // Disable the bottom
                        //'left' => false, // Disable the left
                        //'all' => true, // Have one field that applies to all
                        'units' => 'px', // You can specify a unit value. Possible: px, em, %
                        'units_extended' => 'true', // Allow users to select any type of unit
                        //'display_units' => 'true', // Set to false to hide the units if the units are specified
                        'title' => __('Logo/Title spacing', 'czs'),
                        'subtitle' => __('Set spacing of Logo or theme Title.', 'czs'),
                        'default' => array('padding-top' => '22px', 'padding-right' => '10px', 'padding-bottom' => '20px', 'padding-left' => '10px')
                    ),
                    array(
                        'id' => 'czs_favicon',
                        'type' => 'media',
                        'title' => __('Favicon', 'czs'), 
                        'subtitle' => __('Upload a <strong>16 x 16 px</strong> image that will represent your website\'s favicon.', 'czs'),
                        'default'  => array(
                            'url'=> ReduxFramework::$_url.'img/favicon.png'
                        ),
                    ),
                    array(
                        'id' => 'czs_breadcrumbs',
                        'type' => 'switch',
                        'title' => __('Breadcrumbs', 'czs'),
                        'subtitle' => __('<strong>Enable or Disable</strong> breadcrumbs.', 'czs'),
                        'default' => 1,
                    ),
                    array(
                        'id' => 'czs_slider',
                        'type' => 'switch',
                        'title' => __('Slider', 'czs'),
                        'subtitle' => __('<strong>Enable or Disable</strong> Slider on Homepage. This feature enable "Editors Choice" too. Select the category for this feature below.', 'czs'),
                        "default" => 1,
                    ),
                    array(
                        'id' => 'czs_slider_categories',
                        'type' => 'select',
                        'data' => 'categories',
                        'required'  => array('czs_slider', "=", 1),
                        'title' => __('Select Categories for Slider', 'czs'),
                        "default" => 1,
                    ),
                    array(
                        'id' => 'czs_editors_categories',
                        'type' => 'select',
                        'data' => 'categories',
                        'required'  => array('czs_slider', "=", 1),
                        'title' => __('Select Categories for Editors Choice', 'czs'),
                        "default" => 1,
                    ),
                    array(
                        'id'       => 'czs_editors_title',
                        'type'     => 'text',
                        'title'    => __('Editors Choice title', 'czs'),
                        'validate' => 'no_html',
                        'default'  => 'Editors Choice',
                        'required'  => array('czs_slider', "=", 1),
                    ),
                    array(
                        'id'       => 'czs_editors_desc',
                        'type'     => 'text',
                        'title'    => __('Editors Choice description', 'czs'),
                        'validate' => 'no_html',
                        'default'  => 'The best from our website',
                        'required'  => array('czs_slider', "=", 1),
                    ),
                    array(
                        'id' => 'czs_home_title',
                        'type' => 'slider',
                        'title' => __('Homepage title length', 'czs'),
                        'desc' => __('How many letters you want to display. Default value: 40', 'czs'),
                        "default" => "40",
                        "min" => "1",
                        "step" => "1",
                        "max" => "200",
                    ),
                    array(
                        'id' => 'czs_home_meta_info',
                        'type' => 'checkbox',
                        'title' => __('HomePage Post Meta Info', 'czs'),
                        'subtitle' => __('Use this button to Show or Hide Post Meta Info on HomePage. (<strong>Author name, Date etc.</strong>).', 'czs'),
                        'options' => array('a' => __('Author Name','czs'), 'b' => __('Categories','czs'), 'c' => __('Comments','czs')),
                        'default' => array('a' => '1', 'b' => '1', 'c' => '1')
                    ),
                    array(
                        'id'       => 'czs_pagenavigation',
                        'type'     => 'radio',
                        'title'    => __('Pagination', 'czs'), 
                        'subtitle' => __('Set paginated navigation links.', 'czs'),
                        'options'  => array(
                            '1' => __('Next / Previous', 'czs'),
                        ),
                        'default' => '1'
                    ),
                ),
            );

            $this->sections[] = array(
                'icon' => 'el-icon-cogs',
                'title' => __('Styling Settings', 'czs'),
                'fields' => array(
                    array(
                        'id'    => 'czs_styling_success',
                        'type'  => 'info',
                        'style' => 'success',
                        'icon'  => 'el-icon-bell',
                        'title' => 'Urban Pro Styling Settings Features',
                        'desc'  => '<strong>Premium Features</strong>: Left or Right Sidebar, Custom CSS'
                    ),
                    array(
                        'id' => 'czs_bg_upload',
                        'type' => 'background',
                        'output' => array('body'),
                        'title' => __('Body Background', 'czs'),
                        'subtitle' => __('Body background with image, color, etc.', 'czs'),
                        'default' => array(
                              'background-color'  => '#b5b5b5', 
                         )
                    ),
                    array(
                        'id' => 'czs_responsive',
                        'type' => 'switch',
                        'title' => __('Responsiveness', 'czs'),
                        'subtitle' => __('<strong>Enable or Disable</strong> template responsiveness.', 'czs'),
                        "default" => 1,
                    )
                )
            );




            $this->sections[] = array(
                'icon' => 'el-icon-website',
                'title' => __('Single Page Options', 'czs'),
                'fields' => array(
                    array(
                        'id'    => 'czs_single_success',
                        'type'  => 'info',
                        'style' => 'success',
                        'icon'  => 'el-icon-bell',
                        'title' => 'Urban Pro Single Page Settings Features',
                        'desc'  => '<strong>Premium Features</strong>: Post Navigation, Social Share Buttons'
                    ),
                    array(
                        'id' => 'czs_tags',
                        'type' => 'switch',
                        'title' => __('Tags', 'czs'),
                        'subtitle' => __('<strong>Enable or Disable</strong> Tags.', 'czs'),
                        "default" => 1,
                    ),
                    array(
                        'id' => 'czs_related_posts',
                        'type' => 'switch',
                        'title' => __('Related posts', 'czs'),
                        'subtitle' => __('<strong>Enable or Disable</strong> Related posts.', 'czs'),
                        "default" => 1,
                    ),
                    array(
                        'id' => 'czs_author_box',
                        'type' => 'switch',
                        'title' => __('Author Box', 'czs'),
                        'subtitle' => __('<strong>Enable or Disable</strong> Author Box.', 'czs'),
                        "default" => 1,
                    ),
                    
                )
            );

            /**
             *  Note here I used a 'heading' in the sections array construct
             *  This allows you to use a different title on your options page
             * instead of reusing the 'title' value.  This can be done on any 
             * section - kp
             */
            $this->sections[] = array(
                'icon' => 'el-icon-bullhorn',
                'title' => __('Ad management', 'czs'),
                'desc' => __('<p class="description">Ad management is easy with our options panel.</p>', 'czs'),
                'fields' => array(
                   array(
                        'id'    => 'czs_ad_code',
                        'type'  => 'info',
                        'style' => 'success',
                        'icon'  => 'el-icon-bell',
                        'title' => 'Urban Pro Ad Features',
                        'desc'  => '<strong>Premium Features</strong>: Ad before and after content'
                    ),    
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-adjust',
                'title' => __('Colors', 'czs'),
                'fields' => array(
                    array(
                        'id'    => 'czs_color_success',
                        'type'  => 'info',
                        'style' => 'success',
                        'icon'  => 'el-icon-bell',
                        'title' => 'Urban Pro Color Features',
                        'desc'  => '<strong>Premium Features</strong>: Custom Links Color, Custom Navigation Color, Custom Post Background Color, Custom Widget Color'
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-font',
                'title' => __('Typography', 'czs'),
                'fields' => array(
                     array(
                        'id'    => 'czs_typo_success',
                        'type'  => 'info',
                        'style' => 'success',
                        'icon'  => 'el-icon-bell',
                        'title' => 'Urban Pro Color Features',
                        'desc'  => '<strong>Premium Features</strong>: 600+ Google Fonts, Live Preview, Custom Colors'
                     ),
                     array(
                        'id' => 'czs_body_typography',
                        'type' => 'typography',
                        'title' => __('General font', 'czs'),
                        //'compiler'=>true, // Use if you want to hook in your own CSS compiler
                        'google' => false, // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup' => false, // Select a backup non-google font in addition to a google font
                        //'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'=>false, // Only appears if google is true and subsets not set to false
                        //'font-size'=>false,
                        //'line-height'=>false,
                        //'word-spacing'=>true, // Defaults to false
                        'text-align'=>false, 
                        'letter-spacing'=>true, 
                        'color'=>false,
                        'preview'=>false, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('body, .meta-desc, .widget li .meta, .recent-comments .info, .read-more a, .footer-navigation a'), // An array of CSS selectors to apply this font style to dynamically
                        'units' => 'px', // Defaults to px
                        'subtitle' => __('Select the general font used in the theme.', 'czs'),
                        'default' => array(
                            'color' => "#dddddd",
                            'font-style' => '400',
                            'font-family' => 'Arial, Helvetica, sans-serif',
                            'google' => false,
                            'font-size' => '14px',
                            'line-height' => '23px',
                            'letter-spacing'=> '0'),
                    ),
                    array(
                        'id' => 'czs_header_title',
                        'type' => 'typography',
                        'title' => __('Header Logo', 'czs'),
                        //'compiler'=>true, // Use if you want to hook in your own CSS compiler
                        'google' => false, // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup' => false, // Select a backup non-google font in addition to a google font
                        //'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'=>false, // Only appears if google is true and subsets not set to false
                        //'font-size'=>false,
                        //'line-height'=>false,
                        //'word-spacing'=>true, // Defaults to false
                        'text-align'=>false, 
                        'letter-spacing'=>true, 
                        'color'=>false,
                        'preview'=>false, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('#header h1, #logo a'), // An array of CSS selectors to apply this font style to dynamically
                        'units' => 'px', // Defaults to px
                        'subtitle' => __('Select the type to use for the logo font.', 'czs'),
                        'default' => array(
                            'color' => "#ffffff",
                            'font-style' => '700',
                            'font-family' => 'Arial, Helvetica, sans-serif',
                            'google' => false,
                            'font-size' => '33px',
                            'line-height' => '35px',
                            'letter-spacing'=> '0'),
                    ),
                    array(
                        'id' => 'czs_desc_title',
                        'type' => 'typography',
                        'title' => __('Site description', 'czs'),
                        //'compiler'=>true, // Use if you want to hook in your own CSS compiler
                        'google' => false, // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup' => false, // Select a backup non-google font in addition to a google font
                        //'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'=>false, // Only appears if google is true and subsets not set to false
                        //'font-size'=>false,
                        //'line-height'=>false,
                        //'word-spacing'=>true, // Defaults to false
                        'text-align'=>false, 
                        'letter-spacing'=>true, 
                        'color'=>false,
                        'preview'=>false, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('.description'), // An array of CSS selectors to apply this font style to dynamically
                        'units' => 'px', // Defaults to px
                        'subtitle' => __('Select the type to use for the description font.', 'czs'),
                        'default' => array(
                            'color' => "#ffffff",
                            'font-style' => '400',
                            'font-family' => 'Arial, Helvetica, sans-serif',
                            'google' => false,
                            'font-size' => '23px',
                            'line-height' => '25px',
                            'letter-spacing'=> '0'),
                    ),
                    array(
                        'id' => 'czs_primary_menu',
                        'type' => 'typography',
                        'title' => __('Primary Menu', 'czs'),
                        //'compiler'=>true, // Use if you want to hook in your own CSS compiler
                        'google' => false, // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup' => false, // Select a backup non-google font in addition to a google font
                        //'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'=>false, // Only appears if google is true and subsets not set to false
                        //'font-size'=>false,
                        'line-height'=>false,
                        //'word-spacing'=>true, // Defaults to false
                        'text-align'=>false, 
                        'letter-spacing'=>true, 
                        'color'=>false,
                        'preview'=>false, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('.secondary-navigation a'), // An array of CSS selectors to apply this font style to dynamically
                        'units' => 'px', // Defaults to px
                        'subtitle' => __('Select the type to use for the menu font.', 'czs'),
                        'default' => array(
                            'color' => "#2b2b2b",
                            'font-style' => '400',
                            'font-family' => 'Arial, Helvetica, sans-serif',
                            'google' => false,
                            'font-size' => '16px',
                            'line-height' => '20px',
                            'letter-spacing'=> '0'),
                    ),
                    array(
                        'id' => 'czs_title_typography',
                        'type' => 'typography',
                        'title' => __('Single/Page Title', 'czs'),
                        //'compiler'=>true, // Use if you want to hook in your own CSS compiler
                        'google' => false, // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup' => false, // Select a backup non-google font in addition to a google font
                        //'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'=>false, // Only appears if google is true and subsets not set to false
                        //'font-size'=>false,
                        //'line-height'=>false,
                        //'word-spacing'=>true, // Defaults to false
                        'text-align'=>false, 
                        'letter-spacing'=>true, 
                        'color'=>false,
                        'preview'=>false, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('.title, .title a, .postauthor-top span'), // An array of CSS selectors to apply this font style to dynamically
                        'units' => 'px', // Defaults to px
                        'subtitle' => __('Select the type to use for single or page title.', 'czs'),
                        'default' => array(
                            'color' => "#ffffff",
                            'font-style' => '400',
                            'font-family' => 'Arial, Helvetica, sans-serif',
                            'google' => false,
                            'font-size' => '20px',
                            'line-height' => '27px',
                            'letter-spacing'=> '0'),
                    ),
                    array(
                        'id' => 'czs_sidebar_typography',
                        'type' => 'typography',
                        'title' => __('Sidebar Title', 'czs'),
                        //'compiler'=>true, // Use if you want to hook in your own CSS compiler
                        'google' => false, // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup' => false, // Select a backup non-google font in addition to a google font
                        //'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'=>false, // Only appears if google is true and subsets not set to false
                        //'font-size'=>false,
                        //'line-height'=>false,
                        //'word-spacing'=>true, // Defaults to false
                        'text-align'=>false, 
                        'letter-spacing'=>true, 
                        'color'=>false,
                        'preview'=>false, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('.widget h3, .related-posts h3, #respond h3, .postauthor h5, .postsby'), // An array of CSS selectors to apply this font style to dynamically
                        'units' => 'px', // Defaults to px
                        'subtitle' => __('Select the type to use for Sidebar title.', 'czs'),
                        'default' => array(
                            'color' => "#ffffff",
                            'font-style' => '700',
                            'font-family' => 'Arial, Helvetica, sans-serif',
                            'google' => false,
                            'font-size' => '18px',
                            'line-height' => '26px',
                            'letter-spacing'=> '0'),
                    ),
                    array(
                        'id' => 'czs_h1_typography',
                        'type' => 'typography',
                        'title' => __('Headings 1 font ', 'czs'),
                        //'compiler'=>true, // Use if you want to hook in your own CSS compiler
                        'google' => false, // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup' => false, // Select a backup non-google font in addition to a google font
                        //'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'=>false, // Only appears if google is true and subsets not set to false
                        //'font-size'=>false,
                        //'line-height'=>false,
                        //'word-spacing'=>true, // Defaults to false
                        'text-align'=>false, 
                        'letter-spacing'=>true, 
                        'color'=>false,
                        'preview'=>false, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('h1'), // An array of CSS selectors to apply this font style to dynamically
                        'units' => 'px', // Defaults to px
                        'subtitle' => __('Select the type to use for the h1.', 'czs'),
                        'default' => array(
                            'color' => "#ffffff",
                            'font-style' => '700',
                            'font-family' => 'Arial, Helvetica, sans-serif',
                            'google' => false,
                            'font-size' => '28px',
                            'line-height' => '38px',
                            'letter-spacing'=> '0'),
                    ),
                    array(
                        'id' => 'czs_h2_typography',
                        'type' => 'typography',
                        'title' => __('Headings 2 font ', 'czs'),
                        //'compiler'=>true, // Use if you want to hook in your own CSS compiler
                        'google' => false, // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup' => false, // Select a backup non-google font in addition to a google font
                        //'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'=>false, // Only appears if google is true and subsets not set to false
                        //'font-size'=>false,
                        //'line-height'=>false,
                        //'word-spacing'=>true, // Defaults to false
                        'text-align'=>false, 
                        'letter-spacing'=>true, 
                        'color'=>false,
                        'preview'=>false, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('h2'), // An array of CSS selectors to apply this font style to dynamically
                        'units' => 'px', // Defaults to px
                        'subtitle' => __('Select the type to use for the h2.', 'czs'),
                        'default' => array(
                            'color' => "#ffffff",
                            'font-style' => '700',
                            'font-family' => 'Arial, Helvetica, sans-serif',
                            'google' => false,
                            'font-size' => '24px',
                            'line-height' => '34px',
                            'letter-spacing'=> '0'),
                    ),
                    array(
                        'id' => 'czs_h3_typography',
                        'type' => 'typography',
                        'title' => __('Headings 3 font ', 'czs'),
                        //'compiler'=>true, // Use if you want to hook in your own CSS compiler
                        'google' => false, // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup' => false, // Select a backup non-google font in addition to a google font
                        //'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'=>false, // Only appears if google is true and subsets not set to false
                        //'font-size'=>false,
                        //'line-height'=>false,
                        //'word-spacing'=>true, // Defaults to false
                        'text-align'=>false, 
                        'letter-spacing'=>true, 
                        'color'=>false,
                        'preview'=>false, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('h3'), // An array of CSS selectors to apply this font style to dynamically
                        'units' => 'px', // Defaults to px
                        'subtitle' => __('Select the type to use for the h3.', 'czs'),
                        'default' => array(
                            'color' => "#ffffff",
                            'font-style' => '700',
                            'font-family' => 'Arial, Helvetica, sans-serif',
                            'google' => false,
                            'font-size' => '22px',
                            'line-height' => '32px',
                            'letter-spacing'=> '0'),
                    ),
                    array(
                        'id' => 'czs_h4_typography',
                        'type' => 'typography',
                        'title' => __('Headings 4 font ', 'czs'),
                        //'compiler'=>true, // Use if you want to hook in your own CSS compiler
                        'google' => false, // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup' => false, // Select a backup non-google font in addition to a google font
                        //'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'=>false, // Only appears if google is true and subsets not set to false
                        //'font-size'=>false,
                        //'line-height'=>false,
                        //'word-spacing'=>true, // Defaults to false
                        'text-align'=>false, 
                        'letter-spacing'=>true, 
                        'color'=>false,
                        'preview'=>false, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('h4'), // An array of CSS selectors to apply this font style to dynamically
                        'units' => 'px', // Defaults to px
                        'subtitle' => __('Select the type to use for the h4.', 'czs'),
                        'default' => array(
                            'color' => "#ffffff",
                            'font-style' => '400',
                            'font-family' => 'Arial, Helvetica, sans-serif',
                            'google' => false,
                            'font-size' => '20px',
                            'line-height' => '30px',
                            'letter-spacing'=> '0'),
                    ),
                    array(
                        'id' => 'czs_h5_typography',
                        'type' => 'typography',
                        'title' => __('Headings 5 font ', 'czs'),
                        //'compiler'=>true, // Use if you want to hook in your own CSS compiler
                        'google' => false, // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup' => false, // Select a backup non-google font in addition to a google font
                        //'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'=>false, // Only appears if google is true and subsets not set to false
                        //'font-size'=>false,
                        //'line-height'=>false,
                        //'word-spacing'=>true, // Defaults to false
                        'text-align'=>false, 
                        'letter-spacing'=>true, 
                        'color'=>false,
                        'preview'=>false, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('h5'), // An array of CSS selectors to apply this font style to dynamically
                        'units' => 'px', // Defaults to px
                        'subtitle' => __('Select the type to use for the h5.', 'czs'),
                        'default' => array(
                            'color' => "#ffffff",
                            'font-style' => '400',
                            'font-family' => 'Arial, Helvetica, sans-serif',
                            'google' => false,
                            'font-size' => '18px',
                            'line-height' => '28px',
                            'letter-spacing'=> '0'),
                    ),
                    array(
                        'id' => 'czs_h6_typography',
                        'type' => 'typography',
                        'title' => __('Headings 6 font ', 'czs'),
                        //'compiler'=>true, // Use if you want to hook in your own CSS compiler
                        'google' => false, // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup' => false, // Select a backup non-google font in addition to a google font
                        //'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'=>false, // Only appears if google is true and subsets not set to false
                        //'font-size'=>false,
                        //'line-height'=>false,
                        //'word-spacing'=>true, // Defaults to false
                        'text-align'=>false, 
                        'letter-spacing'=>true, 
                        'color'=>false,
                        'preview'=>false, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('h6'), // An array of CSS selectors to apply this font style to dynamically
                        'units' => 'px', // Defaults to px
                        'subtitle' => __('Select the type to use for the h6.', 'czs'),
                        'default' => array(
                            'color' => "#ffffff",
                            'font-style' => '400',
                            'font-family' => 'Arial, Helvetica, sans-serif',
                            'google' => false,
                            'font-size' => '16px',
                            'line-height' => '26px',
                            'letter-spacing'=> '0'),
                    ),
                )
            );
            
            
            $this->sections[] = array(
                'icon' => 'el-icon-twitter',
                'title' => __('Social Buttons', 'czs'),
                'desc' => __('Enable or disable social sharing buttons on homepage using these buttons.', 'czs'),
                'fields' => array(
                    array(
                        'id' => 'czs_facebook_url',
                        'type' => 'text',
                        'title' => __('Facebook', 'czs'),
                        'subtitle' => __('Your Facebook URL', 'czs'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'czs_twitter_url',
                        'type' => 'text',
                        'title' => __('Twitter', 'czs'),
                        'subtitle' => __('Your Twitter URL', 'czs'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'czs_pinterest_url',
                        'type' => 'text',
                        'title' => __('Pinterest', 'czs'),
                        'subtitle' => __('Your Pinterest URL', 'czs'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'czs_gplus_url',
                        'type' => 'text',
                        'title' => __('Google+', 'czs'),
                        'subtitle' => __('Your Google+ URL', 'czs'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'czs_linkedin_url',
                        'type' => 'text',
                        'title' => __('Linked In', 'czs'),
                        'subtitle' => __('Your Linked In URL', 'czs'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'czs_rss_url',
                        'type' => 'text',
                        'title' => __('RSS', 'czs'),
                        'subtitle' => __('Your RSS URL', 'czs'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'czs_flickr_url',
                        'type' => 'text',
                        'title' => __('Flickr', 'czs'),
                        'subtitle' => __('Your Flickr URL', 'czs'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                )
            );
            
            $this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => __('Theme Information', 'czs'),
                'desc'      => __('<p class="description">Urban / Blog WordPress Theme</p>', 'czs'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );
            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => __('Urban Pro', 'czs'),
                'desc'      => __('Urban Pro Features', 'czs'),
                'fields'    => array(
                   array(
                        'id'   => 'opt-info-field',
                        'type' => 'info',
                        'desc' => '<li>Full Color Customizations</li><li>600+ Google Fonts with live preview and colors</li><li>Custom copyright text</li><li>Cutom logo</li><li>Custom CSS</li><li>Cutom background</li><li>Pagination</li><li>Carousel</li><li>Easily customise all colors using color picker</li><li>Left or right sidebar</li><li>Video support</li><li>Social share buttons</li><li>Post navigation</li><li>Custom Widgets</li><li>Ad boxes</li><li>Content post slider</li><a href="http://mythemes4wp.com/demo?theme=Urban" target="_blank">Urban Pro Live Demo</a> | <a href="http://mythemes4wp.com/theme/urban-ultimate-blog-wordpress-theme/" target="_blank">Buy Urban Pro</a>',
                    ),
                ),
            );
            
            
            $theme_info = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'czs') . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'czs') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'czs') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'czs') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => 'Urban Help',
                'content'   => '<p>If you have any issue, you can contact me via contact form on our site: <a href="http://mythemes4wp.com/contact/" target="_blank">Contact</a></p>',
            );

           

            // Set the help sidebar
            $this->args['help_sidebar'] = '<p>Theme by <a href="http://mythemes4wp.com/" target="_blank">MyThemes4WP</a></p>';
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array (
                'opt_name' => 'czs_options',
                'global_variable' => 'czs_options',
                'admin_bar' => '1',
                'allow_sub_menu' => '1',
                'footer_text' => 'Theme by MyThemes4WP',
                'hints' => 
                array (
                  'icon' => 'el-icon-question-sign',
                  'icon_position' => 'right',
                  'icon_color' => '#848484',
                  'icon_size' => 'normal',
                  'tip_style' => 
                  array (
                    'color' => 'dark',
                    'style' => 'youtube',
                  ),
                  'tip_position' => 
                  array (
                    'my' => 'top left',
                    'at' => 'bottom right',
                  ),
                  'tip_effect' => 
                  array (
                    'show' => 
                    array (
                      'effect' => 'slide',
                      'duration' => '100',
                      'event' => 'mouseover',
                    ),
                    'hide' => 
                    array (
                      'effect' => 'slide',
                      'duration' => '100',
                      'event' => 'mouseleave unfocus',
                    ),
                  ),
                ),
                'intro_text' => 'Theme by MyThemes4WP',
                'last_tab' => '1',
                'menu_title' => 'Blog Options',
                'menu_type' => 'submenu',
                'output' => '1',
                'output_tag' => '1',
                'page_icon' => 'icon-themes',
                'page_parent_post_type' => 'your_post_type',
                'page_priority' => '61',
                'page_permissions' => 'manage_options',
                'page_slug' => '_options',
                'page_title' => 'Blog Options',
                'save_defaults' => '1',
                'disable_tracking' => true,
              );

            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args["display_name"] = $theme->get("Name");
            $this->args["display_version"] = $theme->get("Version");

// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.

            $this->args['share_icons'][] = array(
                'url'   => 'http://mythemes4wp.com/',
                'title' => 'My Personal Page',
                'icon'  => 'el-icon-website-alt'
            );            
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/mythemes4wp',
                'title' => 'Follow me on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://plus.google.com/+Mythemes4wp',
                'title' => 'Follow me on Google+',
                'icon'  => 'el-icon-googleplus'
            );
            

            }

    }
    
    global $reduxConfig;
    $reduxConfig = new czs_Redux_Framework_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('czs_my_custom_field')):
    function czs_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('czs_validate_callback_function')):
    function czs_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;