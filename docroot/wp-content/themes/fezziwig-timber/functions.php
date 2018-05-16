<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});
	
	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});
	
	return;
}

Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );

        add_image_size( 'square-extrasmall', 120, 120, true ); // Hard Crop Mode
        add_image_size( 'square-small', 240, 240, true ); // Soft Crop Mode
        add_image_size( 'square-medium', 480, 480, true ); // Soft Crop Mode
        add_image_size( 'square-large', 960, 960, true ); // Soft Crop Mode
        add_image_size( 'square-extralarge', 1200, 1200, true ); // Soft Crop Mode
        add_image_size( 'unlimitedheight', 590, 9999 ); // Unlimited Height Mode

		parent::__construct();
	}

	function register_post_types() {
		//this is where you can register custom post types
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

	function add_to_context( $context ) {
		$context['foo'] = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::get_context();';
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		return $context;
	}

	function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}

}

new StarterSite();

/**
 * Enqueue scripts and styles.
 */
function fezziwig_timber_scripts() {
	wp_register_script( 'bigtext', get_template_directory_uri() . '/js/bigtext.js', array ( 'jquery' ), 1.1, true );
	wp_enqueue_script( 'bigtext' );
	wp_enqueue_style( 'fezziwig-timber-google-fonts--1', '//fonts.googleapis.com/css?family=Open+Sans:300,400,700|Arvo:400,700|Montserrat:400,500,600,700', false );
    wp_enqueue_style( 'fezziwig-timber-google-fonts--2', '//fonts.googleapis.com/css?family=EB+Garamond:400,400i,600', false );
    wp_enqueue_style( 'fezziwig-timber-google-fonts--3', '//fonts.googleapis.com/css?family=Josefin+Sans:100,300,400', false );
    wp_enqueue_style( 'fezziwig-timber-google-fonts--4', '//fonts.googleapis.com/css?family=Ovo', false );
    wp_enqueue_style( 'fezziwig-timber-google-fonts--5', '//fonts.googleapis.com/css?family=Playfair+Display+SC:400,700', false );
    wp_enqueue_style( 'fezziwig-timber-google-fonts--6', '//fonts.googleapis.com/css?family=Vast+Shadow', false );

	wp_enqueue_style( 'fezziwig-timber-style', get_stylesheet_directory_uri() . '/styles/css/styles.css' );
}
add_action( 'wp_enqueue_scripts', 'fezziwig_timber_scripts' );

add_theme_support( 'custom-logo' );

function fezziwig_timber_custom_logo_setup() {
  $defaults = array(
	  'height'      => 100,
	  'width'       => 400,
	  'flex-height' => true,
	  'flex-width'  => true,
	  'header-text' => array( 'site-title', 'site-description' ),
  );
  add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'fezziwig_timber_custom_logo_setup' );

add_filter('body_class','my_body_classes');
function my_body_classes($c) {
  is_front_page() ? $c[] = 'front' : null;
  wp_is_mobile() ? $c[] = 'mobile' : null;
  !wp_is_mobile() ? $c[] = 'desktop' : null;
  return $c;
}
