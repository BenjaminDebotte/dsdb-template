<?php

defined( 'ABSPATH' ) || exit;


//Theme support
add_theme_support( 'post_thumbnails' );
add_theme_support( 'responsive-embeds' );
add_theme_support( 'title-tag' );

//Déclaration des scripts et css

function dsbd_enqueue_scripts() {
    // Déclarer le CSS de Bootstrap
    wp_enqueue_style( 
        'bootstrap-style', 
        get_template_directory_uri() . '/vendor/bootstrap/css/bootstrap.min.css'
    );

    // Déclarer le JS de BootStrap
    wp_enqueue_script( 
        'bootstrap-script', 
        get_template_directory_uri() . '/vendor/bootstrap/js/bootstrap.min.js', 
        array('jquery'), 
        '1.0', 
        true
    );

    // Déclarer le JS de Isotope
    wp_enqueue_script( 
        'isotope-script', 
        get_template_directory_uri() . '/vendor/isotope/isotope.pkgd.min.js', 
        true
    );

    // Déclarer le JS de Swiper
    wp_enqueue_script( 
        'swiper-script', 
        get_template_directory_uri() . '/vendor/swiper/swiper-bundle.min.js', 
        true
    );

    // Déclarer le CSS de Swiper
    wp_enqueue_style( 
        'swiper-style', 
        get_template_directory_uri() . '/vendor/swiper/swiper-bundle.min.css'
    );

    // Déclarer le JS de AOS
    wp_enqueue_script( 
        'aos-script', 
        get_template_directory_uri() . '/vendor/aos/dist/aos.js',
        true
    );

    // Déclarer le CSS de AOS
    wp_enqueue_style( 
        'aos-style', 
        get_template_directory_uri() . '/vendor/aos/dist/aos.css'
    );

    // Déclarer le JS de FancyBox
    wp_enqueue_script( 
        'fancybox-script', 
        get_template_directory_uri() . '/vendor/fancybox/ui/dist/fancybox/fancybox.umd.js', 
        true
    );

    // Déclarer le CSS de FancyBox
    wp_enqueue_style( 
        'fancybox-style', 
        get_template_directory_uri() . '/vendor/fancybox/ui/dist/fancybox/fancybox.css'
    );

    // Déclarer le JS de Masonry
    wp_enqueue_script( 
        'masonry-script', 
        get_template_directory_uri() . '/vendor/masonry/masonry.pkgd.min.js',
        array('jquery'),
        '1.0',
        true
    );

    // Déclarer le JS de ImagesLoaded
    wp_enqueue_script( 
        'imagesloaded-script', 
        get_template_directory_uri() . '/vendor/imagesloaded/imagesloaded.pkgd.min.js', 
        array('jquery'), 
        '1.0', 
        true
    );

    //Déclarer le CSS du thème
    wp_enqueue_style(
        'theme-style',
        get_template_directory_uri() . '/style.css'
    );

    // Déclarer le JS du thème
    wp_enqueue_script(
        'theme-script',
        get_template_directory_uri() . '/js/script.js', 
        array( 'jquery' ),
        '1.0',
        false
    );
}
add_action( 'wp_enqueue_scripts', 'dsbd_enqueue_scripts' );



//Ajout d'emplacements de menu

function register_my_menus() {
    register_nav_menus(
      array(
        'header-menu' => __( 'Menu header' ),
        'footer-menu' => __( 'Menu footer' )
      )
    );
  }
  add_action( 'init', 'register_my_menus' );

/**
 * Remove Gutenberg Block Library CSS from loading on the frontend
 */

function smartwp_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
} 
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

/**
 * Disable the emoji's
 */

function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	
	// Remove from TinyMCE
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter out the tinymce emoji plugin.
 */

function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Desactivate Gutenberg
 */

add_filter('use_block_editor_for_post', '__return_false', 10);

add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
    
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});


/**
 * Wordpress Disable Comments
 */

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

// Remove version in public html
remove_action("wp_head", "wp_generator");

// remove version in rss feed
function wpt_remove_version() {
    return ''; }
    add_filter('the_generator', 'wpt_remove_version');

//Disable files editor
    define('DISALLOW_FILE_EDIT',true);


/**
 * Custom dashboard widget
 */

add_action('wp_dashboard_setup', 'custom_dashboard_widget');
  
function custom_dashboard_widget() {
global $wp_meta_boxes;
 
wp_add_dashboard_widget('custom_help_widget', 'Contact développeur', 'custom_dashboard_help');
}
 
function custom_dashboard_help() {
echo '  <p>David Di San Bonifacio</p>
        <a href="mailto:disanbonifacio.d@gmail.com">disanbonifacio.d@gmail.com</a><br/>
        <a href="tel:0699681429">+33699681429</a>';
}

/**
 * Hide some plugins from the menu
 */

function hide_menu() {
    // remove_menu_page( '' ); 
}
add_action('admin_head', 'hide_menu');

//Security

//----- Stop WP version being generated in the head tags
function fhoke_remove_version() {
    return '';
    }
     
    add_filter('the_generator', 'fhoke_remove_version');
     
    //----- Remove WP version from CSS and JS
    function fhoke_remove_wp_ver($src) {
    if(strpos($src, 'ver='))
    $src = remove_query_arg('ver', $src);
    return $src;
    }
     
    add_filter('style_loader_src', 'fhoke_remove_wp_ver', 9999);
    add_filter('script_loader_src', 'fhoke_remove_wp_ver', 9999);