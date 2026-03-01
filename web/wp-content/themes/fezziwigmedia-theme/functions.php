<?php

/**
 * Fezziwig Media Arts functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fezziwig_Media_Arts
 */

if (! defined('_S_VERSION')) {
  // Replace the version number of the theme on each release.
  define('_S_VERSION', '1.0.0');
}

/**
 * Register Technologies custom taxonomy for portfolio posts.
 */
function fezziwig_register_technologies_taxonomy()
{
  $labels = array(
    'name'              => 'Technologies',
    'singular_name'     => 'Technology',
    'search_items'      => 'Search Technologies',
    'all_items'         => 'All Technologies',
    'edit_item'         => 'Edit Technology',
    'update_item'       => 'Update Technology',
    'add_new_item'      => 'Add New Technology',
    'new_item_name'     => 'New Technology Name',
    'menu_name'         => 'Technologies',
  );

  $args = array(
    'hierarchical'      => false,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'show_in_rest'      => true,
    'query_var'         => true,
    'rewrite'           => array('slug' => 'technology'),
  );

  register_taxonomy('technology', array('post'), $args);
}
add_action('init', 'fezziwig_register_technologies_taxonomy');

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function fezziwig_media_arts_setup()
{
  /*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Fezziwig Media Arts, use a find and replace
		* to change 'fezziwigmedia-theme' to the name of your theme in all the template files.
		*/
  load_theme_textdomain('fezziwigmedia-theme', get_template_directory() . '/languages');

  // Add default posts and comments RSS feed links to head.
  add_theme_support('automatic-feed-links');

  /*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
  add_theme_support('title-tag');

  /*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
  add_theme_support('post-thumbnails');

  register_nav_menus(
    array(
      'primary' => esc_html__('Primary Menu', 'fezziwigmedia-theme'),
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
      'fezziwig_media_arts_custom_background_args',
      array(
        'default-color' => 'ffffff',
        'default-image' => '',
      )
    )
  );

  // Add theme support for selective refresh for widgets.
  add_theme_support('customize-selective-refresh-widgets');

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
add_action('after_setup_theme', 'fezziwig_media_arts_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fezziwig_media_arts_content_width()
{
  $GLOBALS['content_width'] = apply_filters('fezziwig_media_arts_content_width', 640);
}
add_action('after_setup_theme', 'fezziwig_media_arts_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fezziwig_media_arts_widgets_init()
{
  register_sidebar(
    array(
      'name'          => esc_html__('Sidebar', 'fezziwigmedia-theme'),
      'id'            => 'sidebar-1',
      'description'   => esc_html__('Add widgets here.', 'fezziwigmedia-theme'),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );
}
add_action('widgets_init', 'fezziwig_media_arts_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function fezziwig_media_arts_scripts()
{
  wp_enqueue_style('fezziwigmedia-theme-style', get_template_directory_uri() . '/css/style.min.css', array(), _S_VERSION);
  wp_enqueue_style('fezziwig-timber-google-fonts--1', '//fonts.googleapis.com/css?family=Open+Sans:300,400,700|Arvo:400,700|Montserrat:400,500,600,700', false);
  wp_enqueue_style('fezziwig-timber-google-fonts--2', '//fonts.googleapis.com/css?family=EB+Garamond:400,400i,600', false);
  wp_enqueue_style('fezziwig-timber-google-fonts--3', '//fonts.googleapis.com/css?family=Josefin+Sans:100,300,400', false);
  wp_enqueue_style('fezziwig-timber-google-fonts--4', '//fonts.googleapis.com/css?family=Ovo', false);
  wp_enqueue_style('fezziwig-timber-google-fonts--5', '//fonts.googleapis.com/css?family=Playfair+Display+SC:400,700', false);
  wp_enqueue_style('fezziwig-timber-google-fonts--6', '//fonts.googleapis.com/css?family=Vast+Shadow', false);

  wp_style_add_data('fezziwigmedia-theme-style', 'rtl', 'replace');

  wp_enqueue_script('fezziwigmedia-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'fezziwig_media_arts_scripts');

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
 */
if (defined('JETPACK__VERSION')) {
  require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Simplify the title of category pages (removes "Category:").
 */
add_filter('get_the_archive_title', function ($title) {
  if (is_category()) {
    $title = single_cat_title('', false);
  }
  return $title;
});

/**
 * Function to populate custom field with NGG galleries.
 */
function fezziwig_media_arts_gallery_choices($field)
{
  // Reset choices
  $field['choices'] = array();

  // Add 'Select a gallery' option
  $field['choices'][''] = 'Select a Gallery...';

  // Get all NextGen galleries
  global $wpdb;
  $galleries = $wpdb->get_results("SELECT gid, title FROM {$wpdb->prefix}ngg_gallery");

  // Loop through galleries and add to choices
  if (! empty($galleries)) {
    foreach ($galleries as $gallery) {
      // Use the gallery ID as the value and the gallery title as the display text
      $field['choices'][$gallery->gid] = $gallery->title;
    }
  }

  // Return the field
  return $field;
}
add_filter('acf/load_field/name=gallery_id', 'fezziwig_media_arts_gallery_choices');

/**
 * Function to deregister the NGG "Add Gallery" button on post edit forms.
 */
function remove_ngg_add_gallery_button()
{
  remove_action('media_buttons', array('C_NextGen_Attach_to_Post', 'add_media_button'), 20);
}
add_action('admin_init', 'remove_ngg_add_gallery_button');

/**
 * Add custom image sizes.
 */
add_image_size('small', 300, 300, false);
add_image_size('medium', 600, 600, false);
add_image_size('large', 1000, 1000, false);
add_image_size('small-square', 300, 300, true);
add_image_size('medium-square', 600, 600, true);
add_image_size('large-square', 1000, 1000, true);

/**
 * Function to register ACF blocks.
 */
function fezziwig_media_arts_acf_blocks_init()
{
  if (function_exists('acf_register_block_type')) {
    acf_register_block_type(array(
      'name'              => 'post_teasers',
      'title'             => __('Post Teasers'),
      'description'       => __('Displays a list of post teasers from a selected category.'),
      'category'          => 'formatting',
      'icon'              => 'list-view',
      'keywords'          => array('post', 'teaser', 'category'),
      'render_template'   => 'template-parts/blocks/post-teasers.php',
    ));
  }
}
add_action('acf/init', 'fezziwig_media_arts_acf_blocks_init');

// Make menu endpoints public
add_filter('rest_endpoints', function ($endpoints) {
  if (isset($endpoints['/wp/v2/menus'])) {
    $endpoints['/wp/v2/menus'][0]['permission_callback'] = '__return_true';
  }
  if (isset($endpoints['/wp/v2/menu-items'])) {
    $endpoints['/wp/v2/menu-items'][0]['permission_callback'] = '__return_true';
  }
  return $endpoints;
});

/**
 * Endpoint callback: GET /wp-json/fezziwig/v1/blocks/{slug}
 *
 * Fetches the raw Gutenberg block content for a given post or page,
 * identified by its URL slug. Only published posts/pages are returned.
 * This bypasses the default REST post endpoint to deliver unrendered
 * block markup (or you could swap in parse_blocks() for a parsed array),
 * enabling the front-end to handle block rendering client-side.
 *
 * @param WP_REST_Request $request
 *   The incoming request, expecting a 'slug' parameter matching the
 *   post_name of the desired page or post.
 * @return WP_REST_Response
 *   - 200: JSON object with a 'blocks' key containing the raw content
 *   - 404: JSON error if the slug doesn’t match any published post/page
 */
add_action('rest_api_init', function () {
  register_rest_route('fezziwig/v1', '/blocks/(?P<slug>[^/]+)', [
    'methods'  => 'GET',
    'callback' => function ($request) {
      $slug = sanitize_title($request['slug']);
      $post = get_page_by_path($slug, OBJECT, ['page', 'post']);

      if (! $post || $post->post_status !== 'publish') {
        return new WP_REST_Response(['error' => 'Not found'], 404);
      }

      return new WP_REST_Response([
        'blocks' => $post->post_content,
        'title' => apply_filters('the_title', $post->post_title),
      ]);
    },
    'permission_callback' => '__return_true', // tighten this up as needed
  ]);
});
