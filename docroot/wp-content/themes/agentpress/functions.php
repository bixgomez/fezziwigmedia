<?php
// Start the engine
require_once(TEMPLATEPATH.'/lib/init.php');
require_once(STYLESHEETPATH.'/lib/init.php');

// Add new image sizes
add_image_size('Slider', 920, 300, TRUE);
add_image_size('Featured Properties', 290, 200, TRUE);
add_image_size('Featured Posts', 115, 115, TRUE);
add_image_size('Small Thumbnail', 110, 80, TRUE);

// Load script for jFlow slider
add_action('get_header', 'agentpress_load_scripts');
function agentpress_load_scripts() {
    wp_enqueue_script('jflow', CHILD_URL.'/lib/js/jquery.flow.1.1.js', array('jquery'), '1.1', TRUE);
}

// Load parameters for jFlow slider
add_action('wp_footer', 'agentpress_jflow_params');
function agentpress_jflow_params() {
	$timer = intval(genesis_get_option('slider_timer'));
	$duration = intval(genesis_get_option('slider_duration'));
	 $output = '
		jQuery(document).ready(function($) { 
			$("div#controller").jFlow({
				slides: "#slides", 
				width: "920px", 
				height: "300px", 
				timer: '.$timer.', 
				duration: '.$duration.' 
			});
		});
	';
	$output = str_replace(array("\n","\t","\r"), '', $output);
	echo '<script type=\'text/javascript\'>'.$output.'</script>';
}

// Add the slider on the homepage above the content area
add_action('genesis_after_header', 'agentpress_include_slider'); 
function agentpress_include_slider() {
    if(is_front_page() && genesis_get_option('slider_enable'))
    require(CHILD_DIR . '/slider.php');
}

// Force layout on homepage
add_filter('genesis_pre_get_option_site_layout', 'agentpress_home_layout');
function agentpress_home_layout($opt) {
	if ( is_home() )
    $opt = 'content-sidebar';
	return $opt;
}  

// Add a read more link to the excerpt
add_filter('excerpt_more', 'agentpress_excerpt_more');
function agentpress_excerpt_more($more) {
    return '... <a href="'.get_permalink().'" rel="nofollow">Read More</a>';
}

// Remove post-info, post-meta, and author box from property posts
add_action( 'get_header', 'agentpress_remove_property_extras' );
function agentpress_remove_property_extras() {
	if( is_single() && genesis_get_custom_field('_features_1_col1_1') ) {
		remove_action('genesis_before_post_content', 'genesis_post_info');
		remove_action('genesis_after_post_content', 'genesis_post_meta');
		remove_action('genesis_after_post', 'genesis_do_author_box');
		add_filter( 'genesis_options', 'agentpress_remove_property_comments', 10, 2 );
	}
}

// Remove comments from property posts
function agentpress_remove_property_comments($options, $setting) {
	if($setting == GENESIS_SETTINGS_FIELD) {
		$options['comments_posts'] = 0;
	}
	return $options;
}

// Add new box to the Genesis -> Theme Settings page
add_action('admin_menu', 'agentpress_add_settings_boxes', 11);
function agentpress_add_settings_boxes() {
	global $_genesis_theme_settings_pagehook;
	add_meta_box('genesis-theme-settings-slider', __('Slider Settings', 'agentpress'), 'agentpress_theme_settings_slider_box', $_genesis_theme_settings_pagehook, 'column2');
}
function agentpress_theme_settings_slider_box() { ?>
	<p><input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[slider_enable]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[slider_enable]" value="1" <?php checked(1, genesis_get_option('slider_enable')); ?> /> <label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[slider_enable]"><?php _e('Enable the Slider?', 'agentpress'); ?></label></p>
	<p><label><?php _e('Category', 'agentpress'); ?>: <?php wp_dropdown_categories(array('name' => GENESIS_SETTINGS_FIELD.'[slider_cat]', 'selected' => genesis_get_option('slider_cat'), 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __("All Categories", 'agentpress'), 'hide_empty' => '0')); ?></label></p>
	<p><label><?php _e('Number of Posts', 'agentpress'); ?>: <input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[slider_num]" value="<?php genesis_option('slider_num'); ?>" size="5" /></label></p>
	<p><label><?php _e('Time Between Slides (in milliseconds)', 'agentpress'); ?>: <input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[slider_timer]" value="<?php genesis_option('slider_timer'); ?>" size="5" /></label></p>
	<p><label><?php _e('Slide Transition Speed (in milliseconds)', 'agentpress'); ?>: <input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[slider_duration]" value="<?php genesis_option('slider_duration'); ?>" size="5" /></label></p>
<?php
}

// Add new default values for the slider
add_filter('genesis_theme_settings_defaults', 'agentpress_slider_defaults');
function agentpress_slider_defaults($defaults) {
	$defaults['slider_enable'] = 1;
	$defaults['slider_num'] = 1;
	$defaults['slider_timer'] = 6000;
	$defaults['slider_duration'] = 400;
	return $defaults;
}

// Register Sidebars
genesis_register_sidebar(array(
	'name'=>'Featured Properties',
	'description' => 'This is the featured properties section of the homepage.',
	'before_title'=>'<h4 class="widgettitle">','after_title'=>'</h4>'
));
genesis_register_sidebar(array(
	'name'=>'Featured Posts',
	'description' => 'This is the featured posts section of the homepage.',
	'before_title'=>'<h4 class="widgettitle">','after_title'=>'</h4>'
));
genesis_register_sidebar(array(
	'name'=>'Multi-Agent Page',
	'description' => 'This is the main content area of the mult-agent page template.',
	'before_title'=>'<h4 class="widgettitle">','after_title'=>'</h4>'
));
?>