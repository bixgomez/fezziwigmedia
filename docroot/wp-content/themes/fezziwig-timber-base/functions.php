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
function beauclair_scripts() {
wp_enqueue_style( 'beauclair-google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300,600|Cormorant:400i,700', false );
wp_enqueue_style( 'beauclair-style', get_stylesheet_directory_uri() . '/styles/css/styles.css' );
}
add_action( 'wp_enqueue_scripts', 'beauclair_scripts' );

add_theme_support( 'custom-logo' );

function beauclair_custom_logo_setup() {
  $defaults = array(
	  'height'      => 100,
	  'width'       => 400,
	  'flex-height' => true,
	  'flex-width'  => true,
	  'header-text' => array( 'site-title', 'site-description' ),
  );
  add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'beauclair_custom_logo_setup' );

/**
 * Register our sidebars and widgetized areas.
 */
function beauclair_widgets_init() {

	register_sidebar( array(
		'name'          => 'Header',
		'id'            => 'sidebar__header',
		'before_widget' => '<div class="sidebar--header">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'Hero',
		'id'            => 'sidebar__hero',
		'before_widget' => '<div class="sidebar--hero">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'Home page callouts',
		'id'            => 'sidebar__homepage_callouts',
		'before_widget' => '<div class="sidebar--homepage-callouts">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'Footer (left)',
		'id'            => 'sidebar__footer_left',
		'before_widget' => '<div class="sidebar--footer-left">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'Footer (middle)',
		'id'            => 'sidebar__footer_middle',
		'before_widget' => '<div class="sidebar--footer-middle">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'Footer (right)',
		'id'            => 'sidebar__footer_right',
		'before_widget' => '<div class="sidebar--footer-right">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'beauclair_widgets_init' );
