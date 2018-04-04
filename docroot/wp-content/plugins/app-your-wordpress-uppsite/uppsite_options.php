<?php


function mysiteapp_admin_menu() {
	add_options_page('UppSite - Apping Your Wordpress', 'UppSite - Apping WP', 'manage_options', 'uppsite-settings', 'mysiteapp_option_page');
}

function mysiteapp_settings_uppsite_key() {
	$options = get_option('uppsite_options');
	
	/*if( defined('UPPSITE_API_KEY')){
		$options['uppsite_key'] = UPPSITE_API_KEY;
	}*/
	
	echo "<input id='uppsite_options_key' name='uppsite_options[uppsite_key]' size='40' type='text' value=\"{$options['uppsite_key']}\" />";
}

function mysiteapp_settings_uppsite_secret() {
	$options = get_option('uppsite_options');
	
	/*if(defined('UPPSITE_API_SECRET')){
		$options['uppsite_secret'] = UPPSITE_API_SECRET;
	}*/
	
	echo "<input id='uppsite_options_secret' name='uppsite_options[uppsite_secret]' size='40' type='text' value=\"{$options['uppsite_secret']}\" />";
}

function mysiteapp_settings_uppsite_sticky() {
	$options = get_option('uppsite_options');
	$items = array("No", "Yes");
	
	if(!isset($options['option_sticky'])){
		$options['option_sticky'] = "No";
	}
	
	foreach($items as $item) {
		$checked = ($options['option_sticky']==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='uppsite_options[option_sticky]' type='radio' /> $item</label><br />";
	}
}

function mysiteapp_settings_uppsite_homepagelist() {
	$options = get_option('uppsite_options');
	$items = array("No"=>"No, show homepage according to my blog's settings.", "Yes"=>"Yes, I want my apps to show the posts list on homepage.");
	
	if(!isset($options['option_homepagelist'])){
		$options['option_homepagelist'] = "Yes";
	}
	
	foreach($items as $_key => $item) {
		$checked = ($options['option_homepagelist']==$_key) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$_key' name='uppsite_options[option_homepagelist]' type='radio' /> $item</label><br />";
	}
}

function mysiteapp_settings_uppsite_extranl_comments(){

	$options = get_option('uppsite_options');
	$items = array('fbcomment' =>'Enable Facebook comments support (you will need to enter the Facebook-API information in <a href="http://www.uppsite.com/dashboard/" target="_blank">UppSite Dashboard</a> to enable writing permissions)',
	'disqus'=>'Enable Disqus comments support');
	
	$checked = '';
	
		
	foreach($items as $_key => $item) {
	
		if(isset($options[$_key])){ 
		$checked = ' checked="checked" '; }
		else { $checked = '';}
		
		echo "<fieldset name='$_key'>";
		echo "<label><input ".$checked." value='1' name='uppsite_options[$_key]' type='checkbox' /> ".$item."</label>";
		echo "</fieldset>";
	}
}

function mysiteapp_setting_display_alert() {
	$options = get_option('uppsite_options');
	$items = array("No", "Yes");
	
	if(!isset($options['option_popup'])){
		$options['option_popup'] = "Yes";
	}
	
	foreach($items as $item) {
		$checked = ($options['option_popup']==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='uppsite_options[option_popup]' type='radio' /> $item</label><br />";
	}
}

function mysiteapp_setting_display_timing() {
	$options = get_option('uppsite_options');
	$items = array("Everytime", "Every Hour","Every Day","Every Week","Every Month");
	
	if(!isset($options['option_popup_time'])){
		$options['option_popup_time'] = "Everytime";
	}
	
	foreach($items as $item) {
		$checked = ($options['option_popup_time']==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='uppsite_options[option_popup_time]' type='radio' /> $item</label><br />";
	}
}

function mysiteapp_settings_uppsite_hidden() {
	echo "<input type='hidden' name='uppsite_options[uppsite_plugin_version]' value='".MYSITEAPP_PLUGIN_VERSION."' />";
}


function mysiteapp_option_page() {


	global $sent;
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
?>

<div>
	<?php if(!is_keys_set()): ?>
<h2>Almost done...</h2>
<p>All you need to do now is register FREE to <a href="http://www.uppsite.com" target='_blank'>UppSite.com</a> with this website's URL and get your own API key and secret, which will allow your users to get Push notifications.</p>
<p>Register now FREE:
<a href="http://www.uppsite.com" target='_blank'>http://www.uppsite.com</a></p>

<h2>I have registered...</h2>
<p>Good! Now enter the API key and secret from your account's Dashboard here:</p>
	<?php else: ?>
<h2>UppSite Plugin</h2>
<p>Have questions? Need help? Use <a href="http://www.uppsite.com/support-home/" target="_blank">UppSite Support</a>.</p>
	<?php endif;?>
<form action="options.php" method="post">
<?php settings_fields('uppsite_options'); ?>
<?php do_settings_sections(__FILE__); ?>
<p class="submit"><input type="submit" name="Submit" value="Save Changes" class="button-primary" /></p>
</form>
<p>&nbsp;</p><hr />
<table style="width:100%; border:0;" cellspacing="5">
<tr>
	<td style="vertical-align:top;"><form method="post"><input type="submit" name="Submit" value="Download report" class="button-secondary"/>
		<input type="hidden" name="report" value="yes"><input type="hidden" name="withoptions" value="yes"><input type="hidden" name="get_options" value="get_options">
		</form></td>
	<td style="vertical-align:top;"> Clicking on this button will automatically download a "txt" file <br>which you can attach to a message which describes your problem to our <a href="mailto:support@uppsite.com">Support team</a>
	</td>
</tr>
</table>
<p></p>

</div>



<?php 
}  // func mysiteapp_option_page

function mysiteapp_options_validate($input){
	return $input;
}

function mysiteapp_options_section_api_text(){
	echo "<p>The API Key &amp; Secret are used by your applications for Push Notifications, which usually increases the user engagement with your website.</p>
		<p>You can get the API Key &amp; Secret from <a href=\"http://www.uppsite.com/dashboard/\" target='_blank'>UppSite Dashboard</a> (be sure you input the API key+secret assigned to this website).</p>";
}

function mysiteapp_options_section_notify_text(){
	echo "<p>Visitors using mobile browsers (such as Safari for iPhone, Chrome for Android, etc), can be notified and redirected to download your native apps once they are in the stores (handled by UppSite). Choose if and when to inform them of your native apps.</p>";
}

function mysiteapp_options_section_no_text(){
}

function mysiteapp_admin_init_options(){

	register_setting('uppsite_options', 'uppsite_options', 'mysiteapp_options_validate' );
	add_settings_section('main_section', 'UppSite APIs', 'mysiteapp_options_section_api_text', __FILE__);
	add_settings_field('uppsite_options_key', 'API Key', 'mysiteapp_settings_uppsite_key', __FILE__, 'main_section');
	add_settings_field('uppsite_options_secret', 'API Secret', 'mysiteapp_settings_uppsite_secret', __FILE__, 'main_section');
	
	add_settings_section('plugin_alert', 'Notify Users', 'mysiteapp_options_section_notify_text', __FILE__);
	add_settings_field('uppsite_options_popup', 'Display', 'mysiteapp_setting_display_alert', __FILE__, 'plugin_alert');
	
	add_settings_section('other_section', 'Other Options', 'mysiteapp_options_section_no_text', __FILE__);
	add_settings_field('uppsite_options_sticky', 'Disable sticky in apps', 'mysiteapp_settings_uppsite_sticky', __FILE__, 'other_section');
	add_settings_field('uppsite_options_homepagelist', 'Ignore blog homepage settings', 'mysiteapp_settings_uppsite_homepagelist', __FILE__, 'other_section');


	add_settings_field('uppsite_options_hidden', NULL, 'mysiteapp_settings_uppsite_hidden', __FILE__, 'other_section');
	add_settings_field('uppsite_options_comments', 'Comments', 'mysiteapp_settings_uppsite_extranl_comments', __FILE__, 'other_section');
	
	
	$options = get_option('uppsite_options');

	if($options['option_popup'] == "Yes"){
		add_settings_field('uppsite_options_pop_time', 'Display Alert Every...', 'mysiteapp_setting_display_timing', __FILE__, 'plugin_alert');
	}
	
}

function is_keys_set(){
	$options = get_option('uppsite_options');
	
	if (!defined('UPPSITE_API_KEY') || !defined('UPPSITE_API_SECRET') ){
		if (strlen($options['uppsite_key']) == 0  || strlen($options['uppsite_secret']) == 0) 		  	   
			return false;
	} elseif (empty($options['uppsite_key'])  || empty($options['uppsite_secret'])) {
		$options['uppsite_key'] = UPPSITE_API_KEY;
		$options['uppsite_secret'] = UPPSITE_API_SECRET;
		update_option('uppsite_options', $options);
	}
	
	return true;

}

function is_problem_sent(){

	 $options = get_option('uppsite_options');
	 
	 if($options['sent_error']){
	 
		 $options['sent_error'] = false;
    	 update_option('uppsite_options', $options);

		return true;	 
	 
	 }
	 
	return false; 
}

function mysiteapp_activation_notice(){
	if (function_exists('admin_url')){
		echo '<div class="error fade"><p><strong>NOTICE</strong>: You need to configure the UppSite plugin first, in order to use it. Please go to the <a href="' . admin_url( 'options-general.php?page=uppsite-settings' ) . '">settings page</a></p></div>';
	}
}
function mysiteapp_sentprobelm_notice(){

	 echo '<div id="message" class="updated"><p><strong>Successfully sent report to UppSite.</strong></p></div>';	
	
}


function parse_plugins(){

	$plugins = get_plugins();
	
	
	$result = array();
	
	foreach($plugins as $plug_uri=>$plug){
		if(is_plugin_active($plug_uri)){
		 	 array_push($result, array('name'=>$plug['Name'],'version'=>$plug['Version'],'uri'=>$plug['PluginURI'],'auther'=>$plug['Author']));
		 }
	
	}
	
	return $result;

}

function get_options_data(){

	if(function_exists('wp_load_alloptions')){
		return wp_load_alloptions();
	}
	else if(function_exists('get_alloptions')){
		return get_alloptions();
	}
	
	return array();

}

function sign_report($message,$secret){

	$str = $secret.$message;
		
	return md5($str);

}

function send_report($with_options = false){
	
	include_once('../wp-admin/includes/plugin.php');
	if(function_exists('get_plugins')){

		   $options = get_option('uppsite_options');
		   
		   $data['plugins'] =  parse_plugins();
		   
		   if($with_options){
		   
		   	 $data['options'] =  get_options_data();
		   }
		  
		   $data['site_url'] = get_bloginfo('url');
		   $data['uppsite_options'] = $options;
		   
		   $options['sent_error'] = true;
		   
		   $json = json_encode($data);
		   
		   $json_str = urlencode($json);
		   
		   $hashed_code = sign_report($json_str,$options['uppsite_secret']);

		   $post_data = array('body' =>'data='.$json_str.'&api_key='.$options['uppsite_key'].'&hash='.$hashed_code);
   		   $post_data['timeout'] = '10';
   		   
		   $result = wp_remote_post(MYSITEAPP_APP_REPORT_URL,$post_data);
		   //print_r($result); die(1);

		   update_option('uppsite_options', $options);
		   unset($_POST['report']);
	}
}

function get_report(){
	$options = get_alloptions();
	$response = wp_remote_post(MYSITEAPP_APP_DOWNLOAD_SETTINGS,array(
	'method' => 'POST',
	'timeout' => 45,
	'redirection' => 5,
	'httpversion' => '1.0',
	'blocking' => true,
	'headers' => array(),
	'body' => array( 'options' => $options),
	'cookies' => array()
    ));
    
    if(is_wp_error($response )){
    	wp_die("Can not complete.");
    }
    $url = $response['body'];
		?> 
		
		<iframe src="<?php echo $url?>"   id="frame1" style="display:none"></iframe>
		<?php
}

//Admin Panel Actions
if(isset($_POST['report'])){
	if(isset($_POST['get_options'])){
		get_report();
	}
	else {
		if($_POST['withoptions'] == 'yes')
			send_report(true);
		else
			send_report(false);	
	}

}

if(!is_keys_set()){
	add_action( 'admin_notices', 'mysiteapp_activation_notice');
}

 
 if(is_problem_sent()){
 
 	add_action( 'admin_notices', 'mysiteapp_sentprobelm_notice');
  
 }


add_action('admin_init', 'mysiteapp_admin_init_options');
add_action('admin_menu', 'mysiteapp_admin_menu');



