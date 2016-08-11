<?php

// Init Timber
$timber = new \Timber\Timber();

// Check that everythign went right
if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		} );
	return;
}

Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );

		// Adding scripts and css
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ) );

		parent::__construct();
	}

	function register_post_types() {
		//this is where you can register custom post types
		//self::register_post_type_cpt() and function outside for better code;
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
		//self::register_taxonomy_tax() and function outside for better code;
	}


	function add_to_context( $data ) {
		$data['menu'] = new TimberMenu();
		$data['site'] = $this;
		return $data;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own fuctions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		return $twig;
	}

	// Add scripts
	// ==================================================================
	// Adding scripts with random version for development  -> cache buster
	// ==================================================================
	function add_scripts() {
		if (getenv('WP_ENV') === 'development') {
			function random_js() {
				$randomizr = '?' . rand(100,999);
				return $randomizr;
			}
		} else {
			function random_js() {
				return '1.0.0';
			}
		}
		wp_enqueue_script( 'script', get_template_directory_uri().'/js/main.js', array(), random_js(), true );
			$wpo = array(
				'theme' => get_template_directory_uri(),
				'ajax' => array(
					'url' => admin_url( 'admin-ajax.php' )
				),
			);
		wp_localize_script('script', 'WPO', $wpo);
	}


	// Add styles
	// ==================================================================
	// Adding styles with random version for development -> cache buster
	function add_styles() {
		if (getenv('WP_ENV') === 'development') {
			function random_css() {
				$randomizr = '?' . rand(100,999);
				return $randomizr;
			}
		} else {
			function random_css() {
				return '1.0.0';
			}
		}
		wp_enqueue_style ( 'main',  get_template_directory_uri().'/style.css', array(), random_css() );
	}


}

new StarterSite();

/**
 * Load the Translations
 */
function altana_setup(){
    load_theme_textdomain('text_domain', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'altana_setup');
