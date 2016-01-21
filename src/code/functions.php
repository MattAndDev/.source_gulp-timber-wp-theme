<?php

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
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );
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

	function add_scripts() {
		$google_maps_api = 'https://maps.googleapis.com/maps/api/js';
		wp_enqueue_script('google-maps', $google_maps_api);
		wp_enqueue_script( 'script', get_template_directory_uri().'/js/main.js' );
		$wpo = array(
			'theme' => get_template_directory_uri(),
			'ajax' => array(
				'url' => admin_url( 'admin-ajax.php' ),
				'loader' => '<span class="ajax-loader">loading...</span>',
				'action' => array(
					'TYPE' => 'TYPE_load_more',
				)
			),
			'map' => array(
				'marker' => array(
					'url' => get_template_directory_uri() . '/img/pin.png',
					'size' => array('width@2x', 'height@2x'),
					'origin' => array('0', '0'),
					'anchor' => array('width/2', 'height'),
					'scaled' => array('width', 'height')
				),
				'styles' => ''
			)
		);
		//Wordpress object to pass custom values to the script
		wp_localize_script('script', 'WPO', $wpo);
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

}

// new StarterSite();

/**
 * Load the Translations
 */
function altana_setup(){
    load_theme_textdomain('text_domain', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'altana_setup');

/**
 * Load more TYPE on AJAX call
 * @param int $offset
 * @param int $pad posts_per_page
 * @param string $filter if there's a filter
 */
function TYPE_load_more() {

	$offset = $_POST['offset'];
	$pad = $_POST['pad'];
	if (isset($_POST['filter'])) {
		$filter = $_POST['filter'];
	}

	$post_type = 'post';
	$taxonomy_name = 'filter';

	if (isset($filter) && $filter !== '*') {

		//Array for the filtered query
		$args = array(
			'post_type'=> $post_type,
			'offset' => $offset,
			'posts_per_page' => $pad,
			$taxonomy_name => $filter
		);

	} else {

		//Array for general query
		$args = array(
			'post_type'=> $post_type,
			'offset' => $offset,
			'posts_per_page' => $pad
		);

	}

	//Retrieve the posts
	$ajax_posts = Timber::get_posts($args);

	//Render them in data
	foreach ($ajax_posts as $key => $post) {

		//Retrieve the terms
		$terms = $post->terms;

		//Create a var to create the classes
	  $post_terms = '';

	  foreach ($terms as $term) {

			//Create a class for each term with a prefix
	    $post_terms .= ' CLASS_PREFIX-'.$term->slug;

	  }

		//Pass the context
	  $post->post_term = $post_terms;
		$context['post'] = $post;

		//Load the template and compile it
		$post_template = Timber::compile( 'teaser-'. $post_type .'.twig', $context );

		//Remove all the newlines to send clean JSON
		$data[$key] = trim(preg_replace('/\s+/', ' ', $post_template));

	}

	if (isset($data)) {

		//Encode the data (posts array) and send it
		die(json_encode($data));

	} else {

		//Nothing found
		die(false);

	}

}
add_action( 'wp_ajax_TYPE', 'TYPE' );
add_action( 'wp_ajax_nopriv_TYPE', 'TYPE' );
