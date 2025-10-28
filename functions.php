<?php
/**
 * soltani functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package soltani
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function soltani_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on soltani, use a find and replace
		* to change 'soltani' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'soltani', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'navigation-menu' => esc_html__( 'Primary Navigation', 'soltani' ),
			'footer-menu-contacts' => esc_html__( 'Customer Care', 'soltani' ),
			'footer-menu-about' => esc_html__( 'About', 'soltani' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'soltani_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
    add_theme_support( 'woocommerce' );

}
add_action( 'after_setup_theme', 'soltani_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function soltani_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'soltani_content_width', 640 );
}
add_action( 'after_setup_theme', 'soltani_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function soltani_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'soltani' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'soltani' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'soltani_widgets_init' );

/*
  Enqueue scripts and styles.
function soltani_scripts() {
	wp_enqueue_style( 'soltani-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'soltani-style', 'rtl', 'replace' );
	
	wp_enqueue_script( 'soltani-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'soltani_scripts' );
*/

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
*if ( defined( 'JETPACK__VERSION' ) ) {
	*require get_template_directory() . '/inc/jetpack.php';
*}
*/

function soltani_register_blocks() {
    // Find all block.json files in our build directory
    $block_json_files = glob(get_template_directory() . '/build-blocks/*/block.json');
    
    foreach ($block_json_files as $filename) {
        register_block_type_from_metadata($filename);
    }
}
add_action('init', 'soltani_register_blocks');

function soltani_register_product_carousel_block_assets() {
    // Get the asset file generated by wp-scripts
    $asset_file = get_template_directory() . '/build-blocks/product-carousel/view.asset.php';
    
    if (file_exists($asset_file)) {
        $asset = include $asset_file;
    } else {
        $asset = array(
            'dependencies' => array(),
            'version' => filemtime(get_template_directory() . '/build-blocks/product-carousel/view.js')
        );
    }
    
    // Register Embla Carousel library first
    wp_register_script(
        'embla-carousel',
        'https://cdn.jsdelivr.net/npm/embla-carousel@8/embla-carousel.umd.js',
        array(),
        '8.0.0',
        true
    );
    
    // Register our view script with Embla as dependency
    wp_register_script(
        'soltani-product-carousel-view',
        get_template_directory_uri() . '/build-blocks/product-carousel/view.js',
        array_merge($asset['dependencies'], array('embla-carousel')),
        $asset['version'],
        true
    );
}
add_action('init', 'soltani_register_product_carousel_block_assets');

function soltani_enqueue_product_carousel_scripts() {
    if (has_block('soltani/product-carousel')) {
        wp_enqueue_script('embla-carousel');
        wp_enqueue_script('soltani-product-carousel-view');
    }
}
add_action('wp_enqueue_scripts', 'soltani_enqueue_product_carousel_scripts');

/**
 * Disable WooCommerce block editor assets
 */
function soltani_disable_woocommerce_block_editor_assets() {
    // Dequeue WooCommerce block editor styles
    wp_dequeue_style('woocommerce-classictheme-editor-fonts');
    wp_dequeue_style('woocommerce-blocktheme-editor-styles');
    
    // Dequeue WooCommerce block editor scripts if not needed
    wp_dequeue_script('wc-blocks-editor-scripts');
}
add_action('enqueue_block_editor_assets', 'soltani_disable_woocommerce_block_editor_assets', 100);

// assets 


function soltani_vite_assets() {
    // Define development server URL
    $vite_dev_server = 'http://localhost:5173';
    
    // Check if we're in development mode (Vite server is running)
    // We check for the '@vite/client' file which is only served in dev mode.
    $is_dev = false;
    $dev_server_headers = @get_headers($vite_dev_server . '/@vite/client');
    if ($dev_server_headers && strpos($dev_server_headers[0], '200') !== false) {
        $is_dev = true;
    }

    if ($is_dev) {
        // Development: Load assets from Vite dev server
        // 1. Enqueue Vite client
        wp_enqueue_script('vite-client', $vite_dev_server . '/@vite/client', [], null, ['type' => 'module']);
        // 2. Enqueue main JS file
        wp_enqueue_script('soltani-main-js', $vite_dev_server . '/src-assets/js/main.js', [], null, ['type' => 'module']);
        // 3. Enqueue main CSS file
				wp_enqueue_style('soltani-main-css', $vite_dev_server . '/src-assets/css/main.css', [], null);
    } 
		else {
        // Production: Load assets from manifest.json
        
        $manifest_path = get_template_directory() . '/dist/manifest.json';
        if (file_exists($manifest_path)) {
            $manifest = json_decode(file_get_contents($manifest_path), true);
            
            // Enqueue main JS
            if (isset($manifest['src-assets/js/main.js']['file'])) {
                $js_file = $manifest['src-assets/js/main.js']['file'];
                wp_enqueue_script('soltani-main-js', get_template_directory_uri() . '/dist/' . $js_file, [], null, ['type' => 'module']);
            }
            
            // Enqueue main CSS
            if (isset($manifest['src-assets/css/main.css']['file'])) {
                $css_file = $manifest['src-assets/css/main.css']['file'];
                wp_enqueue_style('soltani-main-css', get_template_directory_uri() . '/dist/' . $css_file, [], null);
            }
        }
    }
}
// Loads assets on the frontend
add_action('wp_enqueue_scripts', 'soltani_vite_assets');

// Loads assets in the block editor
add_action('enqueue_block_assets', 'soltani_vite_assets'); // Add this line
add_action('enqueue_block_editor_assets', 'soltani_vite_assets');

function soltani_disable_wpforms_css() {
    wp_dequeue_style( 'wpforms-full' );
}
add_action( 'wp_print_styles', 'soltani_disable_wpforms_css', 100 );

//remove woocommerce styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');
// forms validation
add_action( 'wp_ajax_submit_custom_cod_order', 'soltani_handle_custom_cod_order' );
add_action( 'wp_ajax_nopriv_submit_custom_cod_order', 'soltani_handle_custom_cod_order' );
function soltani_handle_custom_cod_order() {
    // Collect $_POST data, validate, sanitize, check nonce

    $product_id = absint($_POST['product_id']);
    $variation_id = absint($_POST['variation_id']);
    $customer_name = sanitize_text_field( $_POST['customer_name'] );
    $customer_phone = sanitize_text_field( $_POST['customer_phone'] );
    $province = sanitize_text_field( $_POST['province'] );
    $city = sanitize_text_field( $_POST['city'] );

    // Create order
    $order = wc_create_order();
    $order->add_product( wc_get_product($variation_id ?: $product_id), 1 );
    $order->set_billing_first_name( $customer_name );
    $order->set_billing_phone( $customer_phone );
    $order->set_billing_state( $province );
    $order->set_billing_city( $city );
    $order->set_payment_method( 'cod' );
    $order->calculate_totals();
    $order->set_status( 'pending' );
    $order->save();
    wp_send_json_success([ 'message' => 'Order placed successfully! Order ID: ' . $order->get_id() ]);
     if ( empty($_POST['customer_name']) || empty($_POST['customer_phone']) ) {
        wp_send_json_error([ 'message' => 'Please fill in all details.' ]);
    }
    // WooCommerce order creation code goes here...
    wp_send_json_success([ 'message' => 'Order placed!' ]);
}

// submitting 
