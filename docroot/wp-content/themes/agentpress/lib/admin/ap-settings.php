<?php
/**
 * This function registers the default values for AgentPress Settings
 */
define('AP_SETTINGS_FIELD', 'agentpress-settings');

function ap_settings_defaults() {
	$defaults = array( // define our defaults
		'features_1_col1_1' => 'Listing Price:',
		'features_1_col1_2' => 'Address:',
		'features_1_col1_3' => 'City:',
		'features_1_col1_4' => 'State:',
		'features_1_col1_5' => 'ZIP:',
		//**********************//
		'features_1_col2_1' => 'MLS # (if any):',
		'features_1_col2_2' => 'Square Feet:',
		'features_1_col2_3' => 'Bedrooms:',
		'features_1_col2_4' => 'Bathrooms:',
		'features_1_col2_5' => 'Basement (full, 1/2, finished, unfinished):'
	);
	
	return apply_filters('ap_settings_defaults', $defaults);
}

/**
 * This registers the settings field and adds defaults to the options table
 */
add_action('admin_init', 'register_ap_settings');
function register_ap_settings() {
	register_setting(AP_SETTINGS_FIELD, AP_SETTINGS_FIELD);
	add_option(AP_SETTINGS_FIELD, ap_settings_defaults(), '', 'yes');
}

/**
 * This is a necessary go-between to get our scripts and boxes loaded
 * on the theme settings page only, and not the rest of the admin
 */
add_action('admin_menu', 'ap_settings_init');
function ap_settings_init() {
	global $_ap_settings_pagehook;
	
	// Add "AgentPress Settings" submenu
	$_ap_settings_pagehook = add_submenu_page('genesis', __('AgentPress Settings','genesis'), __('AgentPress Settings','genesis'), 'manage_options', 'ap-settings', 'ap_settings_admin');
	
	add_action('load-'.$_ap_settings_pagehook, 'ap_settings_scripts');
	add_action('load-'.$_ap_settings_pagehook, 'ap_settings_boxes');
}

function ap_settings_scripts() {	
	wp_enqueue_script('common');
	wp_enqueue_script('wp-lists');
	wp_enqueue_script('postbox');
}

function ap_settings_boxes() {
	global $_ap_settings_pagehook;
	
	add_meta_box('ap-settings-features_1', __('Property Details - Section #1', 'agentpress'), 'ap_settings_features_1', $_ap_settings_pagehook, 'column1');
	add_meta_box('ap-settings-features_2', __('Property Details - Section #2', 'agentpress'), 'ap_settings_features_2', $_ap_settings_pagehook, 'column1');
}

/**
 * Tell WordPress that we want only 2 columns available for our meta-boxes
 */
add_filter('screen_layout_columns', 'ap_settings_layout_columns', 10, 2);
function ap_settings_layout_columns($columns, $screen) {
	global $_ap_settings_pagehook;
	if ($screen == $_ap_settings_pagehook) {
		// This page should only have 2 column options
		$columns[$_ap_settings_pagehook] = 1;
	}
	return $columns;
}

/**
 * This function is what actually gets output to the page. It handles the markup,
 * builds the form, outputs necessary JS stuff, and fires <code>do_meta_boxes()</code>
 */
function ap_settings_admin() { 
global $_ap_settings_pagehook, $screen_layout_columns;
if( $screen_layout_columns == 3 ) {
	$width = "width: 32.67%";
}
elseif( $screen_layout_columns == 2 ) {
	$width = "width: 99%;";
	$hide3 = " display: none;";
}
else {
	$width = "width: 99%;";
	$hide2 = $hide3 = " display: none;";
}
?>	
	<div id="ap-settings" class="wrap genesis-metaboxes">
	<form method="post" action="options.php">
		
		<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>
		<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>
		<?php settings_fields(AP_SETTINGS_FIELD); // important! ?>
		
		<?php screen_icon('options-general'); ?>
		<h2><?php _e('AgentPress Settings', 'agentpress'); ?></h2>
		
		<div class="top-buttons">
			<input type="submit" class="button-primary" value="<?php _e('Save Settings', 'agentpress') ?>" />
			<input type="submit" class="button-highlighted" name="<?php echo AP_SETTINGS_FIELD; ?>[reset]" value="<?php _e('Reset Settings', 'agentpress'); ?>" />
		</div>
		
		<?php
		if(genesis_get_option('reset', AP_SETTINGS_FIELD)) {
			update_option(AP_SETTINGS_FIELD, ap_settings_defaults());
			echo '<div id="message" class="updated" id="message"><p><strong>'.__('AgentPress Settings Reset', 'agentpress').'</strong></p></div>';
		}
		elseif( isset($_REQUEST['updated']) && $_REQUEST['updated'] == 'true') {  
			echo '<div id="message" class="updated" id="message"><p><strong>'.__('AgentPress Settings Saved', 'agentpress').'</strong></p></div>';
		}
		?>
		
		<div class="metabox-holder">
			<div class="postbox-container" style="<?php echo $width; ?>">
				<?php do_meta_boxes($_ap_settings_pagehook, 'column1', null); ?>
			</div>
		</div>
		
		<div class="bottom-buttons">
			<input type="submit" class="button-primary" value="<?php _e('Save Settings', 'agentpress') ?>" />
			<input type="submit" class="button-highlighted" name="<?php echo AP_SETTINGS_FIELD; ?>[reset]" value="<?php _e('Reset Settings', 'agentpress'); ?>" />
		</div>
	</form>
	</div>
	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			// close postboxes that should be closed
			$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			// postboxes setup
			postboxes.add_postbox_toggles('<?php echo $_ap_settings_pagehook; ?>');
		});
		//]]>
	</script>

<?php
}

/**
 * This next section defines functions that contain the content of the "boxes" that will be
 * output by default on the "AgentPress Settings" page. There's a bunch of them.
 *
 */
function ap_settings_features_1() { ?>
	<p><span class="description"><?php _e('Fill out or modify the labels below. The text you enter will be used as the label for input textboxes on the in-post Property Details box. If you leave a field blank, neither the label nor the textbox will be used.', 'agentpress'); ?></span></p>
	
	<div style="width: 45%; float: left;">
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col1_1]" value="<?php echo esc_attr( genesis_get_option('features_1_col1_1', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #1', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col1_2]" value="<?php echo esc_attr( genesis_get_option('features_1_col1_2', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #2', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col1_3]" value="<?php echo esc_attr( genesis_get_option('features_1_col1_3', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #3', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col1_4]" value="<?php echo esc_attr( genesis_get_option('features_1_col1_4', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #4', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col1_5]" value="<?php echo esc_attr( genesis_get_option('features_1_col1_5', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #5', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col1_6]" value="<?php echo esc_attr( genesis_get_option('features_1_col1_6', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #6', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col1_7]" value="<?php echo esc_attr( genesis_get_option('features_1_col1_7', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #7', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col1_8]" value="<?php echo esc_attr( genesis_get_option('features_1_col1_8', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #8', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col1_9]" value="<?php echo esc_attr( genesis_get_option('features_1_col1_9', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #9', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col1_10]" value="<?php echo esc_attr( genesis_get_option('features_1_col1_10', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #10', 'agentpress'); ?></span></label></p>
	</div>
	
	<div style="width: 45%; float: right;">
		<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col2_1]" value="<?php echo esc_attr( genesis_get_option('features_1_col2_1', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #1', 'agentpress'); ?></span></label></p>
		<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col2_2]" value="<?php echo esc_attr( genesis_get_option('features_1_col2_2', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #2', 'agentpress'); ?></span></label></p>
		<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col2_3]" value="<?php echo esc_attr( genesis_get_option('features_1_col2_3', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #3', 'agentpress'); ?></span></label></p>
		<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col2_4]" value="<?php echo esc_attr( genesis_get_option('features_1_col2_4', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #4', 'agentpress'); ?></span></label></p>
		<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col2_5]" value="<?php echo esc_attr( genesis_get_option('features_1_col2_5', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #5', 'agentpress'); ?></span></label></p>
		<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col2_6]" value="<?php echo esc_attr( genesis_get_option('features_1_col2_6', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #6', 'agentpress'); ?></span></label></p>
		<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col2_7]" value="<?php echo esc_attr( genesis_get_option('features_1_col2_7', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #7', 'agentpress'); ?></span></label></p>
		<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col2_8]" value="<?php echo esc_attr( genesis_get_option('features_1_col2_8', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #8', 'agentpress'); ?></span></label></p>
		<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col2_9]" value="<?php echo esc_attr( genesis_get_option('features_1_col2_9', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #9', 'agentpress'); ?></span></label></p>
		<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_1_col2_10]" value="<?php echo esc_attr( genesis_get_option('features_1_col2_10', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #10', 'agentpress'); ?></span></label></p>
	</div>
<?php
}

function ap_settings_features_2() { ?>
	<p><span class="description"><?php _e('Fill out or modify the labels below. The text you enter will be used as the label for input textboxes on the in-post Property Details box. If you leave a field blank, neither the label nor the textbox will be used.', 'agentpress'); ?></span></p>
	
	<div style="width: 45%; float: left;">
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col1_1]" value="<?php echo esc_attr( genesis_get_option('features_2_col1_1', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #1', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col1_2]" value="<?php echo esc_attr( genesis_get_option('features_2_col1_2', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #2', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col1_3]" value="<?php echo esc_attr( genesis_get_option('features_2_col1_3', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #3', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col1_4]" value="<?php echo esc_attr( genesis_get_option('features_2_col1_4', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #4', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col1_5]" value="<?php echo esc_attr( genesis_get_option('features_2_col1_5', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #5', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col1_6]" value="<?php echo esc_attr( genesis_get_option('features_2_col1_6', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #6', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col1_7]" value="<?php echo esc_attr( genesis_get_option('features_2_col1_7', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #7', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col1_8]" value="<?php echo esc_attr( genesis_get_option('features_2_col1_8', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #8', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col1_9]" value="<?php echo esc_attr( genesis_get_option('features_2_col1_9', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #9', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col1_10]" value="<?php echo esc_attr( genesis_get_option('features_2_col1_10', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #10', 'agentpress'); ?></span></label></p>
	</div>
	
	<div style="width: 45%; float: right;">
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col2_1]" value="<?php echo esc_attr( genesis_get_option('features_2_col2_1', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #1', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col2_2]" value="<?php echo esc_attr( genesis_get_option('features_2_col2_2', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #2', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col2_3]" value="<?php echo esc_attr( genesis_get_option('features_2_col2_3', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #3', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col2_4]" value="<?php echo esc_attr( genesis_get_option('features_2_col2_4', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #4', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col2_5]" value="<?php echo esc_attr( genesis_get_option('features_2_col2_5', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #5', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col2_6]" value="<?php echo esc_attr( genesis_get_option('features_2_col2_6', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #6', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col2_7]" value="<?php echo esc_attr( genesis_get_option('features_2_col2_7', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #7', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col2_8]" value="<?php echo esc_attr( genesis_get_option('features_2_col2_8', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #8', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col2_9]" value="<?php echo esc_attr( genesis_get_option('features_2_col2_9', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #9', 'agentpress'); ?></span></label></p>
	<p><label><input type="text" name="<?php echo AP_SETTINGS_FIELD; ?>[features_2_col2_10]" value="<?php echo esc_attr( genesis_get_option('features_2_col2_10', AP_SETTINGS_FIELD) ); ?>" size="30" /> <span class="description"><?php _e('Option #10', 'agentpress'); ?></span></label></p>
	</div>
<?php
}