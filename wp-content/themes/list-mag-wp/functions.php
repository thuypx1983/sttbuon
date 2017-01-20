<?php
// ------------------------------------------------ 
// ---------- Options Framework Theme -------------
// ------------------------------------------------
 include( get_template_directory() . '/admin/index.php');

// ---------------------------------------------- 
// - Updates for Themes (Envato Market plugin.) -
// ---------------------------------------------- 
 include( get_template_directory() . '/functions/custom/github.php');

// ---------------------------------------------- 
// --------------- Load Custom Widgets ----------
// ----------------------------------------------
 include( get_template_directory() . '/functions/widgets.php');
 include( get_template_directory() . '/functions/widgets/widget-banner-300.php');         //1 
 include( get_template_directory() . '/functions/widgets/widget-banner-250.php');         //2
 include( get_template_directory() . '/functions/widgets/widget-latest-posts-tags.php');  //3
 include( get_template_directory() . '/functions/widgets/widget-latest-posts.php');       //4
 include( get_template_directory() . '/functions/widgets/widget-posts-categories.php');   //5
 include( get_template_directory() . '/functions/widgets/widget-top-posts.php');          //6
 include( get_template_directory() . '/functions/widgets/widget-top-liked-posts.php');    //7

// ----------------------------------------------
// --------------- Load Custom ------------------
// ---------------------------------------------- 
 include( get_template_directory() . '/functions/custom/comments.php');
  
// ----------------------------------------------
// ------ Content width -------------------------
// ----------------------------------------------
if ( ! isset( $content_width ) ) $content_width = 860;

// ----------------------------------------------
// ------ Theme set up --------------------------
// ----------------------------------------------
add_action( 'after_setup_theme', 'list_mag_wp_theme_setup' );
if ( !function_exists('list_mag_wp_theme_setup') ) {

    function list_mag_wp_theme_setup() {
    
        // Register navigation menu
        register_nav_menus(
            array(
                'list-mag-wp-primary-menu' => esc_html__( 'Header Navigation', 'list-mag-wp' ),
                'list-mag-wp-secondary-menu' => esc_html__( 'Categories Navigation', 'list-mag-wp' ),
            )
        );
        
        // Localization support
        load_theme_textdomain( 'list-mag-wp', get_template_directory() . '/languages' );
        
        // Feed Links
        add_theme_support( 'automatic-feed-links' );
        
        // Title Tag
        add_theme_support( 'title-tag' );

        // Post thumbnails
        add_theme_support( 'post-thumbnails' );
        add_image_size( 'list_mag_wp_thumbnail_blog_list', 250, 250, true ); // Home Blog List.
        add_image_size( 'list_mag_wp_thumbnail_blog_grid', 300, 300, true ); // Home Blog Grid.
        add_image_size( 'list_mag_wp_thumbnail_widget_small', 90, 90, true ); // Sidebar Widget.
        add_image_size( 'list_mag_wp_thumbnail_single_image', 860, '', true ); // Single thumbnails.
    
    }
}

// ----------------------------------------------
// ------------ JavaScrips Files ----------------
// ----------------------------------------------
if( !function_exists( 'list_mag_wp_enqueue_scripts' ) ) {
    function list_mag_wp_enqueue_scripts() {

        // Register css files
        wp_enqueue_style( 'list_mag_wp_style', get_stylesheet_uri(), '', '1.0.1');
        wp_enqueue_style( 'list_mag_wp_default', get_template_directory_uri() . '/css/colors/default.css', array( 'list_mag_wp_style' ), '1.0' );
        wp_enqueue_style( 'list_mag_wp_responsive', get_template_directory_uri() . '/css/responsive.css', array( 'list_mag_wp_style' ), '1.0.1' );
        wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome-4.6.1/css/font-awesome.min.css', array(), '4.6.3' );

        // Register scripts
        wp_enqueue_script( 'list_mag_wp_customjs', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '1.0', true );
        wp_enqueue_script( 'list_mag_wp_mainfiles',  get_template_directory_uri() . '/js/jquery.main.js', array( 'jquery' ), '1.0.1', true );

        $list_mag_wp_js_custom = array( 'template_url' => get_template_directory_uri('template_url') );
        wp_localize_script( 'list_mag_wp_customjs', 'list_mag_wp_js_custom', $list_mag_wp_js_custom );

        // Load Comments & .js files.
        if( is_single() ) {
            wp_enqueue_style( 'jquery-fancybox', get_template_directory_uri() . '/fancybox/jquery.fancybox-1.3.4.css', array(), '1.34' );    
            wp_enqueue_script( 'jquery-fancybox', get_template_directory_uri() . '/fancybox/jquery.fancybox-1.3.4.pack.js', array( 'jquery' ), '1.34', true );
            wp_enqueue_script( 'comment-reply' );
         }

// ----------------------------------------------
// Register Fonts: https://gist.github.com/kailoon/e2dc2a04a8bd5034682c
// ----------------------------------------------
        function list_mag_wp_fonts_url() {
            $list_mag_wp_font_url_google = '';
            
            /*
            Translators: If there are characters in your language that are not supported
            by chosen font(s), translate this to 'off'. Do not translate into your own language.
             */
            if ( 'off' !== _x( 'on', 'Google font: on or off', 'list-mag-wp' ) ) {
                $list_mag_wp_font_url_google = add_query_arg( 'family', urlencode( 'Droid+Sans:400,700|Oswald:400,700' ), "//fonts.googleapis.com/css" );
            }
            return $list_mag_wp_font_url_google;
        }
        /* -- Enqueue styles -- */
        wp_enqueue_style( 'list_mag_wp_fonts', list_mag_wp_fonts_url(), array(), '1.0.0' );
  

    }
    add_action('wp_enqueue_scripts', 'list_mag_wp_enqueue_scripts');
}


// ----------------------------------------------
// ---------- excerpt length adjust -------------
// ----------------------------------------------
function list_mag_wp_excerpt($str, $length, $minword = 3) {
    $sub = '';
    $len = 0;
    foreach (explode(' ', $str) as $word) {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        if (strlen($word) > $minword && strlen($sub) >= $length) { break; }
    }
    return $sub . (($len < strlen($str)) ? ' ..' : '');
}


// ------------------------------------------------ 
// ---------- TGM_Plugin_Activation -------------
// ------------------------------------------------ 
 include( get_template_directory() . '/functions/custom/class-tgm-plugin-activation.php');
 add_action( 'tgmpa_register', 'list_mag_wp_register_required_plugins' );

function list_mag_wp_register_required_plugins() {

    $plugins = array(

        array(
            'name'                  =>  esc_html__( 'Shortcodes', 'list-mag-wp' ), // The plugin name
            'slug'                  => 'anthemes-shortcodes', // The plugin slug (typically the folder name)
            'source'                => get_template_directory() . '/plugins/anthemes-shortcodes.zip', // The plugin source
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
            'version'               => '1.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
            'is_callable'           => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
       ),

        array(
            'name'                  => esc_html__( 'Thumbs Likes System', 'list-mag-wp' ), // The plugin name
            'slug'                  => 'thumbs-rating', // The plugin slug (typically the folder name)
            'source'                => get_template_directory() . '/plugins/thumbs-rating.zip', // The plugin source
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
            'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),

        array(
            'name'                  => esc_html__( 'List Mag Options', 'list-mag-wp' ), // The plugin name
            'slug'                  => 'listmag-options', // The plugin slug (typically the folder name)
            'source'                => get_template_directory() . '/plugins/listmag-options.zip', // The plugin source
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
            'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),

        array(
            'name'                  => esc_html__( 'WP Facebook Open Graph protocol', 'list-mag-wp' ),
            'slug'                  => 'wp-facebook-open-graph-protocol',
            'required'              => false,
            'version'               => '',
        ),

        array(
            'name'                  => esc_html__( 'AccessPress Anonymous Post', 'list-mag-wp' ),
            'slug'                  => 'accesspress-anonymous-post',
            'required'              => false,
            'version'               => '',
        ),

        array(
            'name'                  => esc_html__( 'Responsive Menu', 'list-mag-wp' ),
            'slug'                  => 'responsive-menu',
            'required'              => false,
            'version'               => '',
        ),

    );

    $config = array(
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.

    );

    tgmpa( $plugins, $config );

}

?>