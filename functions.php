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
			'navigation-menu' => esc_html__( 'Primary', 'soltani' ),
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
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
//require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
//require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
//require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
*if ( defined( 'JETPACK__VERSION' ) ) {
	*require get_template_directory() . '/inc/jetpack.php';
*}
*/


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
				if(!is_admin()){
					wp_enqueue_style('soltani-main-css', $vite_dev_server . '/src-assets/css/main.css', [], null);
				}
				if (is_admin()) {
            wp_enqueue_script(
                'soltani-editor',
                'http://localhost:5173/assets/css/editor.css',
                array('vite-client'),
                null,
                true
            );
        }

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
add_action('enqueue_block_editor_assets', 'soltani_vite_assets');

function soltani_register_blocks() {
    // Find all block.json files in our build directory
    $block_json_files = glob(get_template_directory() . '/build-blocks/*/block.json');
    
    foreach ($block_json_files as $filename) {
        register_block_type_from_metadata($filename);
    }
}
add_action('init', 'soltani_register_blocks');
