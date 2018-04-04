<?php
/*
 Plugin Name: UppSite - App Your Site
 Plugin URI: http://www.uppsite.com/learnmore/
 Description: Uppsite is a fully automated plugin to transform your blog into native smartphone apps. **** DISABLING THIS PLUGIN WILL PREVENT YOUR APP USERS FROM USING THE APPS! ****
 Author: UppSite
 Version: 3.3.6
 Author URI: http://www.uppsite.com
  
 */

include_once 'fbcommens_page.inc.php';

if (!defined('MYSITEAPP_AGENT')):

define('MYSITEAPP_PLUGIN_VERSION', '3.3.6');

define('MYSITEAPP_AGENT','MySiteApp');
define('MYSTIEAPP_TEMPLATE','mysiteapp');
define('MYSITEAPP_TEMPLATE_WEBAPP', 'webapp');

define('MYSITEAPP_STYLEID_MSAAGENT', 80);
define('MYSITEAPP_STYLEID_MSAWEBAPP', 81);

define('MYSITEAPP_SITE_ID', 10);
define('MYSITEAPP_WEBSERVICES_URL', 'http://api.uppsite.com');
define('MYSITEAPP_PUSHSERVICE', MYSITEAPP_WEBSERVICES_URL.'/push/notification.php');
define('MYSITEAPP_APP_DOWNLOAD_URL', MYSITEAPP_WEBSERVICES_URL.'/click/get_app_download_link.php');
define('MYSITEAPP_APP_CLICK_URL', MYSITEAPP_WEBSERVICES_URL.'/click/click.php');
define('MYSITEAPP_APP_REPORT_URL', MYSITEAPP_WEBSERVICES_URL.'/report.php');
define('MYSITEAPP_APP_DOWNLOAD_SETTINGS', MYSITEAPP_WEBSERVICES_URL.'/settings/options_response.php');
define('MYSITEAPP_FACEBOOK_COMMENTS_URL','http://graph.facebook.com/comments/?ids=');
define('MYSITEAPP_FBCOMMENTS', 'fbcomments_page.php' );
define('MYSITEAPP_VIDEO_WIDTH', 270);

if ( ! defined( 'MYSITEAPP_PLUGIN_BASENAME' ) )
	define( 'MYSITEAPP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

 if ( ! defined( 'WP_CONTENT_URL' ) )
       define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
       define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
       define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
       define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );


include_once 'uppsite_options.php';
$download_link = false;


class MySiteAppPlugin {
	
	var $is_mobile = false; // is mobile device
	var $is_agent = false; // is msa-user-agent
	var $pref_list = null;
	var $is_removed_plugin = false;
		
	
	function MySiteAppPlugin() {
		$this->detect_user_agent();


		// Don't change the template directory when in the admin panel
		if ($this->is_mobile && strpos( $_SERVER['REQUEST_URI'], '/wp-admin' ) === false ) {
            add_filter( 'stylesheet', array(&$this, 'get_stylesheet') );
			add_filter( 'theme_root', array(&$this, 'theme_root') );
			add_filter( 'theme_root_uri', array(&$this, 'theme_root_uri') );
			add_filter( 'template', array(&$this, 'get_template') );
		}
		
		if ($this->is_mobile && !$this->is_agent)
			$this->update_preferences();
	}
	
	function remove_all_plugins($exception_list= array()){
	
		global $wp_filter;
		
		if($this->is_removed_plugin) return;
		
		foreach($wp_filter as $key=>$value){
		
		  if(!in_array($key,$exception_list)){
		  
				unset($wp_filter[$key]);
			}
		}
		
		$this->is_removed_plugin = true;
	}

	
	function cleanup_growl( $msg ) {
		$msg = str_replace("\r\n","\n", $msg);
		$msg = str_replace("\r","\n", $msg);
		return $msg;	
	}
	
	function update_preferences() {
		$this->fetch_preferences_external('mysiteapp_update_pref');
	}
	
	function create_preferences() {
		$this->fetch_preferences_external('mysiteapp_add_pref');
	}
	
	function get_preferences($force_refresh=false) {
		global $wpdb;
		
		if (!$this->pref_list || $force_refresh) {
			$table_name = mysiteapp_get_table_name_parsed('pref');
			$this->pref_list = mysiteapp_arr_keys_from_col($wpdb->get_results("SELECT * FROM ".$table_name." ", ARRAY_A), 'pref_name', 'pref_value');
		}
		return $this->pref_list;
	}
	
	function is_webapp() {
		if ($this->is_mobile && !$this->is_agent)
			return true;
		return false;
	}
	
	function is_device() {
		if ($this->is_mobile && $this->is_agent)
			return true;
		return false;
	}
	
	function is_agent() {
		return $this->is_device();
	}
	
	/**
	 * 
	 * fetch external preferences
	 * @param string $callback_func  callback function
	 */
	function fetch_preferences_external($callback_func) {
		global $wpdb;
		$site_id = 3;//get_option('mysiteapp_site_id');
		if ($site_id && ini_get('allow_url_fopen') == "1") {
			try {
				$url = sprintf(MYSITEAPP_WEBSERVICES_URL.'/preferences.php?sid=%d', $site_id);
				$xml = simplexml_load_file($url);
				$this->pref_list = array();
				
				if ($xml) {
					foreach ($xml->preferences->children() as $key => $value) {
						$result = $callback_func($key, $value);
						$this->pref_list[$key] = $value;
					}
				}
			} catch (Exception $e) {
				
			}
		}
	}
	
	function detect_user_agent() {
		$styleid = ( isset($_GET['styleid']) && is_numeric($_GET['styleid']) ? intval($_GET['styleid']) : 0 );
		$mobilebrowsers = array( 
	        "WebTV", 
	        "AvantGo", 
	        "Blazer", 
	        "PalmOS", 
	        "lynx", 
	        "Go.Web", 
	        "Elaine", 
	        "ProxiNet", 
	        "ChaiFarer", 
	        "Digital Paths", 
	        "UP.Browser", 
	        "Mazingo", 
	        "iPhone", 
	        "iPod", 
	        "Mobile", 
	        "T68", 
	        "Syncalot", 
	        "Danger", 
	        "Symbian", 
	        "Symbian OS", 
	        "SymbianOS", 
	        "Maemo", 
	        "Nokia", 
	        "Xiino", 
	        "AU-MIC", 
	        "EPOC", 
	        "Wireless", 
	        "Handheld", 
	        "Smartphone", 
	        "SAMSUNG", 
	        "J2ME", 
	        "MIDP", 
	        "MIDP-2.0", 
	        "320x240", 
	        "240x320", 
	        "Blackberry8700", 
	        "Opera Mini", 
	        "NetFront", 
	        "BlackBerry", 
	        "PSP" 
	        ); 
	  
	
		if(strpos($_SERVER['HTTP_USER_AGENT'],MYSITEAPP_AGENT) !== FALSE || $styleid==MYSITEAPP_STYLEID_MSAAGENT) {
			$this->is_mobile = true;
			$this->is_agent = true;
	
		}
		elseif (preg_match('/('.implode('|', $mobilebrowsers).')/i', $_SERVER['HTTP_USER_AGENT'], $match) || $styleid==MYSITEAPP_STYLEID_MSAWEBAPP) {
			// is webapp
			$this->is_mobile = false;
			$this->is_agent = false;
		} else {
			$this->is_mobile = false;
			$this->is_agent = false;
		}
		
	}

	function get_stylesheet( $stylesheet ) {
	if ($this->is_agent) {
			return MYSTIEAPP_TEMPLATE;
		}
		elseif ($this->is_mobile) {
			return MYSITEAPP_TEMPLATE_WEBAPP;
		} else {
			return $stylesheet;
		}
	}
		  
	function get_template( $template ) {
		if ($this->is_agent) {
			define("MYSITEAPP_RUNNING","1");
			if ( function_exists( 'add_theme_support' ) )
				add_theme_support( 'post-thumbnails');

			return MYSTIEAPP_TEMPLATE;
		}
		elseif ($this->is_mobile) {
			return MYSITEAPP_TEMPLATE_WEBAPP;
		}
		else
		{
			return $template;
		}
	}
	
	function get_template_name() {
		if ($this->is_mobile) {
			if ($this->is_agent) { 
				return MYSITEAPP_TEMPLATE;
			} else { 
				return MYSITEAPP_TEMPLATE_WEBAPP; }
		}
		return null;
	}
		  
	function get_template_dir( $value ) {
		$name = $this->get_template_name();
		if ($name)
			return mysiteapp_get_plugin_dir().'/themes/'.$name;
		else
			return $value;

	}
		  
	function theme_root( $path ) {
		if ($this->is_mobile) {
			return mysiteapp_get_plugin_dir() . '/themes';
		} else {
			return $path;
		}
	}
		  
	function theme_root_uri( $url ) {
		if ($this->is_mobile) {
			return mysiteapp_get_plugin_url() . '/themes';
		} else {
			return $url;
		}
	}
	
	function get_plugin_name() {
		return mysiteapp_get_plugin_name();
	}
	
	function get_plugin_dir() {
		return mysiteapp_get_plugin_dir();
	}
	
	function get_plugin_url() {
		return mysiteapp_get_plugin_url();
	}
}
  
global $msap;
$msap = new MySiteAppPlugin();


function mysiteapp_get_plugin_name() {
	return trim( dirname( MYSITEAPP_PLUGIN_BASENAME ), '/' );
}

function mysiteapp_get_plugin_dir() {
	if (defined('WP_PLUGIN_DIR'))
		return WP_PLUGIN_DIR . '/' . mysiteapp_get_plugin_name();//$this->get_plugin_name();
	else
		return dirname(__FILE__);
}

function mysiteapp_get_plugin_url() {
	return WP_PLUGIN_URL . '/' . mysiteapp_get_plugin_name();//$this->get_plugin_name();
}
	

function mysiteapp_get_theme()
{
	$styleid = ( isset($_GET['styleid']) && is_numeric($_GET['styleid']) ? intval($_GET['styleid']) : 0 );
	$mobilebrowsers = array( 
        "WebTV", 
        "AvantGo", 
        "Blazer", 
        "PalmOS", 
        "lynx", 
        "Go.Web", 
        "Elaine", 
        "ProxiNet", 
        "ChaiFarer", 
        "Digital Paths", 
        "UP.Browser", 
        "Mazingo", 
        "iPhone", 
        "iPod", 
        "Mobile", 
        "T68", 
        "Syncalot", 
        "Danger", 
        "Symbian", 
        "Symbian OS", 
        "SymbianOS", 
        "Maemo", 
        "Nokia", 
        "Xiino", 
        "AU-MIC", 
        "EPOC", 
        "Wireless", 
        "Handheld", 
        "Smartphone", 
        "SAMSUNG", 
        "J2ME", 
        "MIDP", 
        "MIDP-2.0", 
        "320x240", 
        "240x320", 
        "Blackberry8700", 
        "Opera Mini", 
        "NetFront", 
        "BlackBerry", 
        "PSP" 
        ); 
  

	if(strpos($_SERVER['HTTP_USER_AGENT'],MYSITEAPP_AGENT) != FALSE
	|| $styleid==MYSITEAPP_STYLEID_MSAAGENT) {

		define("MYSITEAPP_RUNNING","1");

		return MYSTIEAPP_TEMPLATE;
	}
	elseif (preg_match('/('.implode('|', $mobilebrowsers).')/i', $_SERVER['HTTP_USER_AGENT'], $match) || $styleid==MYSITEAPP_STYLEID_MSAWEBAPP) {
		return MYSITEAPP_TEMPLATE_WEBAPP;
	}
	else
	{
		return '';
	}
	// $gettheme = get_option('td_themes');
	 
}

class MysiteappXmlParser {
	/**
	 * The main function for converting to an XML document.
	 * Pass in a multi dimensional array and this recrusively loops through and builds up an XML document.
	 *
	 * @param array $data
	 * @param string $rootNodeName - what you want the root node to be - defaultsto data.
	 * @param SimpleXMLElement $xml - should only be used recursively
	 * @return string XML
	 */
	public static function array_to_xml($data, $rootNodeName = 'data', $xml=null)
	{
		// turn off compatibility mode as simple xml throws a wobbly if you don't.
		if (ini_get('zend.ze1_compatibility_mode') == 1)
		{
			ini_set ('zend.ze1_compatibility_mode', 0);
		}
		
		if ($xml == null)
		{
			$xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
		}
		
		$childNodeName = substr($rootNodeName, 0, strlen($rootNodeName)-1);
		
		// loop through the data passed in.
		foreach($data as $key => $value)
		{
			// no numeric keys in our xml please!
			if (is_numeric($key))
			{
				// make string key...
				$key = $childNodeName; //"unknownNode_". (string) $key;
			}
			
			// replace anything not alpha numeric
			//$key = preg_replace('/[^a-z]/i', '', $key);
			
			// if there is another array found recrusively call this function
			if (is_array($value))
			{
				$node = $xml->addChild($key);
				// recrusive call.
				self::array_to_xml($value, $key, $node);
			}
			else 
			{
				// add single node.
				if (is_string($value)) {
	                $value = htmlspecialchars($value);// htmlentities($value);
					$xml->addChild($key,$value);
				} else
					$xml->addAttribute($key,$value);
			}
			
		}
		// pass back as string. or simple xml object if you want!
		return $xml->asXML();
	}
	
	public static function print_headers() {
		header("Content-type: text/xml");
	}
	
	public static function print_xml($parsed_xml) {
		self::print_headers();
		print $parsed_xml;
	}
}


function mysiteapp_determine_theme()
{


	$theme = mysiteapp_get_theme();
	if(defined("MYSITEAPP_RUNNING")){

		$theme_data = get_theme($theme);

		if (!empty($theme_data)) {
			// Don't let people peek at unpublished themes
			if (isset($theme_data['Status']) && $theme_data['Status'] != 'publish') {
				return false;
			}
			return $theme_data;
		}

		// perhaps they are using the theme directory instead of title
		$themes = get_themes();

		foreach ($themes as $theme_data) {
			// use Stylesheet as it's unique to the theme - Template could point to another theme's templates
			if ($theme_data['Stylesheet'] == $theme) {
				// Don't let people peek at unpublished themes
				if (isset($theme_data['Status']) && $theme_data['Status'] != 'publish') {
					return false;
				}
				return $theme_data;
			}
		}
	}

	return false;
}

function mysiteapp_fix_youtube_helper(&$matches) {
	$new_width = MYSITEAPP_VIDEO_WIDTH;

	$toreturn = $matches['part1']."%d".$matches['part2']."%d".$matches['part3'];//."%d".$matches['part4']."%d".$matches['part5'];
	$height = is_numeric($matches['objectHeight']) ? $matches['objectHeight'] : $matches['embedHeight'];
	$width = is_numeric($matches['objectWidth']) ? $matches['objectWidth'] : $matches['embedWidth'];
	$new_height = ceil(($new_width / $width) * $height);
	return sprintf($toreturn, $new_width, $new_height);//, $new_width, $new_height);
}

function mysiteapp_fix_helper(&$matches) {
	//if ($matches[18]=='youtube.com/v/') {
	if (strpos($matches['url1'], "youtube.com") !== false) {
		return mysiteapp_fix_youtube_helper($matches);
	}
	return $matches['part1'].$matches['objectWidth'].$matches['part2'].$matches['objectHeight'].$matches['part3'];
}

/*
this function acts as a wrapper function to wordpress's wp_logout_url function 
in earlier versions(2.6 down) there is no wp_logout_url() so we created our own little go to function
-returns : logout url
*/
function mysiteapp_logout_url_wrapper()
{
	$logout_url = "";
		
	if(!function_exists('wp_logout_url'))
	{
		$logout_url = site_url('wp-login.php').'?action=logout&amp;_wpnonce=' . wp_create_nonce('log-out');
	}
	else
	{
		$logout_url =site_url('wp-login.php') .'?action=logout&amp;_wpnonce=';
		if(function_exists('wp_create_nonce'))
		{
			$logout_url = $logout_url . wp_create_nonce('log-out');
		} 
	}

	return $logout_url; 	
}

function mysiteapp_fix_videos(&$subject) {
	$matches = preg_replace_callback("/(?P<part1><object[^>]*width=['\"])(?P<objectWidth>\d+)(?P<part2>['\"].*?height=['\"])(?P<objectHeight>\d+)(?P<part3>['\"].*?value=['\"](?P<url1>[^\"]+)['|\"].*?<\/object>)/ms", "mysiteapp_fix_helper", $subject);
	return $matches;
}

function mysiteapp_print_post($isShort=true, $iterator=0, $posts_list_view='full'){

	$options = get_option('uppsite_options');

	if (function_exists('get_the_author_meta')) {
		$avatar = get_avatar(get_the_author_meta('user_email'));
	} elseif (function_exists('get_the_author_id')) {
		$avatar = get_avatar(get_the_author_id());
	} else {
		$avatar = null;
	}
	
	$avatar_url = mysiteapp_extract_url($avatar);
	if (function_exists('has_post_thumbnail') && has_post_thumbnail())
		$thumb_url = mysiteapp_extract_url(get_the_post_thumbnail());
	else
		$thumb_url = null;
	
	if(defined("MYSITEAPP_RUNNING")):
	
		if (mysiteapp_is_show_post_content($iterator, $posts_list_view)) {
		    ob_start(); // Catch any filter that uses "print()";
			$content = apply_filters('the_content',get_the_content());
			ob_end_clean(); // Cleans any output made.
			$content_replacements = array('// <![CDATA[', '//<![CDATA[', '<![CDATA[', '// ]]>', '// ]]&gt;', '//]]>', ']]&gt;','/*<![CDATA[*/','/*]]>*/',']]>');
			$content = str_replace($content_replacements, NULL, $content);
		}
?>
<post ID="<?php the_ID(); ?>" comments_num="<?php echo get_comments_number(); ?>" comments_open="<?php if (comments_open()): ?>true<?php else: ?>false<?php endif; ?>" 
facebook_comments="<?php if (isset($options['fbcomment'])): ?>true<?php else: ?>false<?php endif; ?>">
	<permalink><![CDATA[<?php the_permalink(); ?>]]></permalink>
	<thumb_url><![CDATA[<?php echo $thumb_url; ?>]]></thumb_url>
		<title><![CDATA[<?php echo html_entity_decode(get_the_title(), ENT_QUOTES, 'UTF-8'); ?>]]></title>
	<time><![CDATA[<?php the_time('m/d/y G:i'); ?>]]></time>
	<unix_time><![CDATA[<?php the_time('U'); ?>]]></unix_time>
	<member>
		<name><![CDATA[<?php the_author();?>]]></name>
		<member_link><![CDATA[<?php the_author_link(); ?>]]></member_link>
		<avatar><![CDATA[<?php echo $avatar_url; ?> ]]></avatar>
	</member>
	<excerpt><![CDATA[<?php echo html_entity_decode(get_the_excerpt(), ENT_QUOTES, 'UTF-8'); ?>]]></excerpt>
	<?php if (mysiteapp_is_show_post_content($iterator, $posts_list_view)): ?><content><![CDATA[<?php echo html_entity_decode(mysiteapp_fix_videos($content), ENT_QUOTES, 'UTF-8'); ?>]]></content><?php endif;?>
	<comments_link>
		<![CDATA[<?php comments_link(); ?>]]>
	</comments_link>
	<?php if (mysiteapp_is_show_post_content($iterator, $posts_list_view)): ?>
	<tags>
		<?php if(function_exists('the_tags')) the_tags(); ?>
	</tags>
	<?php endif; ?>
	<categorys>
		<?php if(function_exists('the_category')) the_category(); ?>
	</categorys>
</post>
<?php
	endif;
}

function mysiteapp_list_cat($thelist){

	if(defined("MYSITEAPP_RUNNING")){
		 
		preg_match_all('/href="(.*?)"(.*?)>(.*?)<\/a>/',$thelist,$result);
		$arr_size = count($result[1]);
		$row='';
		$thelist = '';
		for($i=0;$i<$arr_size;$i++){
			$row = sprintf('<category>
      <title><![CDATA[%s]]></title>
      <permalink><![CDATA[%s]]></permalink>
      </category>'
      ,$result[3][$i],$result[1][$i]);
      $thelist .=$row."\n";
		}


	}
	return $thelist;

}

function mysiteapp_list_tags($thelist){

	if(defined("MYSITEAPP_RUNNING")){
		 
		preg_match_all('/href="(.*?)"(.*?)>(.*?)<\/a>/',$thelist,$result);
		$arr_size = count($result[1]);
		$row='';
		$thelist = '';
		for($i=0;$i<$arr_size;$i++){
			$row = sprintf('<tag>
      <title><![CDATA[%s]]></title>
      <permalink><![CDATA[%s]]></permalink>
      </tag>'
      ,$result[3][$i],$result[1][$i]);
      $thelist .=$row."\n";
		}


	}
	return $thelist;

}
function mysiteapp_list_archive($output){
	
	if(defined("MYSITEAPP_RUNNING")){
		$output = mysiteapp_html_data_to_xml($output, 'archive');
	}
	return $output;

}

function mysiteapp_extract_html_data($str, &$total) {
	preg_match_all('/href=["\'](.*?)["\'](.*?)>(.*?)<\/a>/',$str,$result);
	$total = count($result[1]);
	
	return $result;
}

function mysiteapp_html_data_to_xml($str, $parent_node) {
	$result = mysiteapp_extract_html_data($str, $total);
	$toreturn = null;
	
	for ($i=0; $i<$total; $i++) {
		$toreturn .= sprintf(
				"\t<%s>\n\t\t<title><![CDATA[%s]]></title>\n\t\t<permalink><![CDATA[%s]]></permalink>\n\t</%s>\n",
				$parent_node,
				$result[3][$i],
				$result[1][$i],
				$parent_node
			);
	}
	
	return $toreturn;
}

function mysiteapp_tag_cloud($output) {
	if(defined("MYSITEAPP_RUNNING")){
		$output = mysiteapp_html_data_to_xml($output, 'tag');
	}
	return $output;
}

function mysiteapp_list_pages($output){


	if(defined("MYSITEAPP_RUNNING")){
		$output = mysiteapp_html_data_to_xml($output, 'page');
	}
	return $output;

}
function mysiteapp_list_links($output){



	if(defined("MYSITEAPP_RUNNING")){
		$output = mysiteapp_html_data_to_xml($output, 'link');

	}
	return $output;

}
function mysiteapp_navigation($thelist){
	if(defined("MYSITEAPP_RUNNING")){
		 
		print_r($thelist);
		preg_match_all('/href="(.*?)">(.*?)<\/a>/',$thelist,$result);
		$arr_size = count($result[1]);
		$row='';
		$thelist = '';
		for($i=0;$i<$arr_size;$i++){
			$row = sprintf('<navigation><url><![CDATA[%s]]></url><desc><![CDATA[%s]]></desc></navigation>',$result[1][$i],$result[2][$i]);
			$thelist .=$row."\n";
		}


	}
	return $thelist;

}


function mysiteapp_get_template($template)
{
	$theme = mysiteapp_determine_theme();
	if ($theme === false) {
		return $template;
	}

	return $theme['Template'];
}

function mysiteapp_get_stylesheet($stylesheet)
{
	$theme = mysiteapp_determine_theme();
	if ($theme === false) {
		return $stylesheet;
	}

	return $theme['Stylesheet'];
}


function mysiteapp_get_next_posts_link( $label = 'Next Page &raquo;', $max_page = 0 ) {
	global $paged, $wp_query;

	if ( !$max_page )
	$max_page = $wp_query->max_num_pages;

	if ( !$paged )
	$paged = 1;

	$nextpage = intval($paged) + 1;

	if ( !is_single() && ( empty($paged) || $nextpage <= $max_page) ) {
		$attr = apply_filters( 'next_posts_link_attributes', '' );
		return sprintf('<navigation type="next" show="true"><url><![CDATA[%s]]></url></navigation>',next_posts( $max_page, false));
	}
	else{
		return sprintf('<navigation type="next" show="false"><url><![CDATA[]]></url></navigation>');
	}

}


function mysiteapp_get_previous_posts_link( $label = '&laquo; Previous Page' ) {
	global $paged;

	if ( !is_single() && $paged > 1 ) {
		$attr = apply_filters( 'previous_posts_link_attributes', '' );
		return sprintf('<navigation type="prev" show="true"><url><![CDATA[%s]]></url></navigation>',previous_posts( false ));
	}
	else{
		return sprintf('<navigation type="prev" show="false"><url><![CDATA[]]></url></navigation>');
	}
}

function mysiteapp_print_userdata($user){

	if(defined("MYSITEAPP_RUNNING")){

		//	$user = wp_get_current_user();
		wp_set_auth_cookie($user->ID, $credentials['remember'], $secure_cookie);
		//get_header();
		
		// handle avatar
		if (function_exists('get_the_author_meta')) {
			$avatar = get_avatar($user->user_email);
		} elseif (function_exists('get_the_author_id')) {
			$avatar = get_avatar($user->ID);
		} else {
			$avatar = null;
		}
		$avatar_url = mysiteapp_extract_url($avatar);
	
		echo '<mysiteapp>';
		
		print sprintf('<user ID="%d" user_level="%d">
	<login><![CDATA[%s]]></login>
	<name><![CDATA[%s]]></name>
    <nickname><![CDATA[%s]]></nickname>
	<first_name><![CDATA[%s]]></first_name>
	<last_name><![CDATA[%s]]></last_name>
	<email><![CDATA[%s]]></email>
	<avatar><![CDATA[%s]]></avatar>
	<url><![CDATA[%s]]></url>
	<yim><![CDATA[%s]]></yim>
	<aim><![CDATA[%s]]></aim>
	<jabber><![CDATA[%s]]></jabber>
	<logout_hash><![CDATA[%s]]></logout_hash>
	<logout_url><![CDATA[%s]]></logout_url>
	<login_url><![CDATA[%s]]></login_url>
	<capabilities>
		<is_contributor>%s</is_contributor>
		<is_author>%s</is_author>
		<is_editor>%s</is_editor>
		<is_administrator>%s</is_administrator>
	</capabilities>
	</user>',$user->ID,$user->wp_user_level,$user->user_login,$user->display_name,$user->user_nicename
		,$user->first_name,$user->last_name,$user->user_email,$avatar_url,$user->user_url,$user->yim,
		$user->aim,$user->jabber,wp_create_nonce('log-out'), mysiteapp_logout_url_wrapper(), site_url('wp-login.php'),
		( isset($user->wp_capabilities['contributor']) && $user->wp_capabilities['contributor'] ? "true" : "false"),
		( isset($user->wp_capabilities['author']) && $user->wp_capabilities['author'] ? "true" : "false"),
		( isset($user->wp_capabilities['editor']) && $user->wp_capabilities['editor'] ? "true" : "false"),
		( isset($user->wp_capabilities['administrator']) && $user->wp_capabilities['administrator'] ? "true": "false")
		);

		
		echo '</mysiteapp>';
		
		exit();

	}

}

function mysiteapp_print_error($wp_error){

	/*
	 print_r($error);
	 print ('<error><![CDATA[%s]]></error>');
	 exit();*/

	printf('<mysiteapp result="false">');
	foreach ( $wp_error->get_error_codes() as $code ) {
			
		printf('<error><![CDATA[%s]]></error>',$code);
	}
	printf('</mysiteapp>');
	exit();

}

function mysiteapp_login($user, $username, $password){

	if(defined("MYSITEAPP_RUNNING")){


		$user= wp_authenticate_username_password($user, $username, $password);
		 
		if(is_wp_error($user)){

			mysiteapp_print_error($user);
			 
		}
		else{
			mysiteapp_print_userdata($user);

		}
	}

}

function mysiteapp_createpost($location,$post_id){

	if(defined("MYSITEAPP_RUNNING")){

		printf('<mysiteapp result="true">');
		printf('<post id="%d"></post>',$post_id);
		printf('</mysiteapp>');
	}

}

function mysiteapp_error_handler( $message, $title = '', $args = array() ) {

	if(defined("MYSITEAPP_RUNNING")){
		 
		printf('<mysiteapp result="false">');
		printf('<error><![CDATA[%s]]></error>',$message);
		printf('</mysiteapp>');
		 
	}
	die();
	 
}
function call_error( $message) {

	if(defined("MYSITEAPP_RUNNING")){


		return 'mysiteapp_error_handler';

	}
}

function mysiteapp_arr_keys_from_col(&$arr, $new_key_key, $value_key=null) {
	if ($arr) {
		$toreturn = array();
		foreach ($arr as $_key => $_val) {
			$toreturn[$_val[$new_key_key]] = ( $value_key ? $_val[$value_key] : $_val );
		}
	} else 
		$toreturn = null;
	return $toreturn;
}

function mysiteapp_extract_url($str) {
	if ($str) {
		$regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
    $regex .= "([a-zA-Z0-9+!*(),;?&=\$_.-]+(\:[a-zA-Z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
    $regex .= "([a-zA-Z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
    $regex .= "(\:[0-9]{2,5})?"; // Port 
    $regex .= "(\/([a-zA-Z0-9+\$_-]\.?)+)*\/?"; // Path 
    $regex .= "(\?[a-zA-Z+&\$_.-][a-zA-Z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
    $regex .= "(#[a-zA-Z_.-][a-zA-Z0-9+\$_.-]*)?"; // Anchor
    
    //$regex = "(?i)\b((?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\"";
		preg_match('/'.$regex.'/', $str, $matches);
		if ($matches[0])
			return $matches[0];
		else 
			return null;
	} else 
		return null;
}

function mysiteapp_get_table_name_parsed($table) {
	global $wpdb;
	return $wpdb->prefix . 'mysiteapp_' . $table;
}

function mysiteapp_table_exists( $table) {
	global $wpdb, $msap;

	return strtolower( $wpdb->get_var( "SHOW TABLES LIKE '$table'" ) ) == strtolower( $table );
}

function mysiteapp_update_pref($name, $value) {
	global $wpdb;
	static $table_name = null;
	if (!$table_name)
		$table_name = mysiteapp_get_table_name_parsed('pref');
	if (method_exists($wpdb, 'update'))
		$result = $wpdb->update( $table_name, array('pref_value'=>$value),
				array( 'pref_name' => $name ) );

	return $result;
}

function mysiteapp_add_pref($name, $value) {
	global $wpdb;
	static $table_name = null;
	if (!$table_name)
		$table_name = mysiteapp_get_table_name_parsed('pref');
	
	if (method_exists($wpdb, 'insert'))
		$result = $wpdb->insert($table_name, array('pref_name'=>$name, 'pref_value'=>$value), array('%s','%s'));
	
	return $result;
}


function mysiteapp_install() {
	global $wpdb, $msap;
	
	$table_name = mysiteapp_get_table_name_parsed('pref');

	if ( mysiteapp_table_exists($table_name) )
		return; // Exists already

	$charset_collate = '';
	if ( $wpdb->has_cap( 'collation' ) ) {
		if ( ! empty( $wpdb->charset ) )
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$charset_collate .= " COLLATE $wpdb->collate";
	}
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$table_name."` (
`pref_name` VARCHAR( 50 ) NOT NULL ,
`pref_value` VARCHAR( 250 ) NULL DEFAULT NULL ,
PRIMARY KEY ( `pref_name` )
) ENGINE = MYISAM $charset_collate;");

	if ( ! mysiteapp_table_exists($table_name) )
		return false; // Failed to create
	else {
		
		add_option('mysiteapp_site_id', MYSITEAPP_SITE_ID);
		
		return true;
	}
}

function mysiteapp_admin_management_page() {
	global $msap;
	
	$msap->update_preferences();
}

function mysitapp_admin_add_pages() {
	global $msap;
	
	$msap->update_preferences();//$msap->create_preferences();
}

function mysiteapp_head() {
	global $msap;
	
	$pref_list = $msap->get_preferences();
	
	$head = "<style type='text/css'>\n<!--";
	$output = '';
	if ( $pref_list['background_url'] ) {
		$url =  $pref_list['background_url'];
		$output .= "body { background: url('$url') fixed top center; background-attachment:fixed; }\n";
	}
	if ($pref_list['navbar_background_url']) {
		$url =  $pref_list['navbar_background_url'];
		$output .= "#topbar { background: url('$url') repeat-x top; }\n";
	}
	$foot = "--></style>\n";
	if ( '' != $output )
		echo $head . $output . $foot;
}

function mysiteapp_print_xml($arr) {
	$result = MysiteappXmlParser::array_to_xml($arr, "mysiteapp");

	MysiteappXmlParser::print_xml($result);
}

function mysiteapp_post_new() {
	global $msap;
	global $post_ID, $form_action, $post, $user_ID;
	
	
	
	if ($msap->is_device() ) {
		//require_once (ABSPATH.'wp-includes/functions.php');
		
		$arr = array(
				'user'=>array('ID'=>$user_ID),
				'postedit'=>array()
			);
			
		if ( 0 == $post_ID ) {
			$form_action = 'post';
		} else 
			$form_action = 'editpost';
		
		$arr['postedit'] = array('wpnonce'=>wp_create_nonce( 0 == $post_ID ? 'add-post' : 'update-post_' .  $post_ID ),
				'user_ID'=>(int) $user_ID,
				'original_post_status'=>esc_attr($post->post_status),
				'action'=>esc_attr($form_action),
				'originalaction'=>esc_attr($form_action),
				'post_type'=>esc_attr($post->post_type),
				'post_author'=>esc_attr( $post->post_author ),
				'referredby'=>esc_url(stripslashes(wp_get_referer())),
				'hidden_post_status'=>'',
				'hidden_post_password'=>'',
				'hidden_post_sticky'=>'',
				'autosavenonce'=>wp_create_nonce( 'autosave'),
				'closedpostboxesnonce'=>wp_create_nonce( 'closedpostboxes'),
				'getpermalinknonce'=>wp_create_nonce( 'getpermalink'),
				'samplepermalinknonce'=>wp_create_nonce( 'samplepermalink'),
				'meta_box_order_nonce'=>wp_create_nonce( 'meta-box-order'),
				'categories'=>array(),
			);
		if ( 0 == $post_ID ) {
			$arr['postedit']['temp_ID'] = esc_attr($temp_ID);
			$autosave = false;
		} else {
			$arr['postedit']['post_ID'] = esc_attr($post_ID);
		}
		
		mysiteapp_print_xml($arr);
		
		exit();
	}
	
}

function mysiteapp_post_new_process($post_id) {
	global $msap;
	//global $post_id, $post_ID, $post;
	
	if ($msap->is_device() ) {
		//require_once (ABSPATH.'wp-includes/functions.php');
		
		$the_post = wp_is_post_revision($post_id);
		
		//echo "post_id= ".var_export($post_id, true)." , postID= ".var_export($post_ID, true). " , the_post = ".var_export($the_post, true). " , post= ".var_export($post, true);
		
		$arr = array(
				'user'=>array('ID'=>$user_ID),
				'postedit'=>array('success'=>true, 'post_ID'=>$post_id, 'is_revision'=>var_export(wp_is_post_revision($post_id), true),
					'permalink'=>get_permalink($post_id))
			);
		mysiteapp_print_xml($arr);
		
		exit();
	}
}

function mysiteapp_logout() {
	global $msap;
	global $user_ID, $user;
	
	if ($msap->is_device() ) {
		
		$arr = array(
				'user'=>array('ID'=>$user_ID),
				'logout'=>array('success'=>(bool) $user_ID)
			);
		mysiteapp_print_xml($arr);
		
		exit();
	}
}

function mysiteapp_comment_author($comment_ID = 0) 
{
	$author = html_entity_decode($comment_ID) ;
	$stripped = strip_tags($author);
	echo $stripped;
}

function mysiteapp_comment_form() {
	ob_start();
	do_action('comment_form');
	$dump = ob_get_clean();
	if (preg_match_all('/name="([a-zA-Z0-9\_]+)" value="([a-zA-Z0-9\_\'&@#]+)"/', $dump, $matches)) {
		$total = count($matches[1]);
		for ($i=0; $i<$total; $i++) {
			echo "<".$matches[1][$i]."><![CDATA[".$matches[2][$i]."]]></".$matches[1][$i].">\n";
		}
	}
}
/*
convert wordpress date from to unixtime
@param string wordpress date format
@return string  unix time
*/
function mysiteapp_convert_datetime($datetime) {
  //example: 2008-02-07 12:19:32
  $values = split(" ", $datetime);

  $dates = split("-", $values[0]);
  $times = split(":", $values[1]);

  $newdate = mktime($times[0], $times[1], $times[2], $dates[1], $dates[2], $dates[0]);

  return $newdate;
  
}
/* 
sign json with the secret key 
@param string $message  json message
@return string  md5
*/
function mysiteapp_sign_message($message){

	$str = UPPSITE_API_SECRET.$message;
		
	return md5($str);

}

function mysiteapp_init_keys($options = NULL){

	if (!$options)
		$options = get_option('uppsite_options');
	$require_update_options = false;

	if(!defined('UPPSITE_API_KEY')){
		define('UPPSITE_API_KEY',$options['uppsite_key']);
	} elseif (isset($options['uppsite_key']) && !empty($options['uppsite_key'])) {
		$require_update_options = true;
		$options['uppsite_key'] = UPPSITE_API_KEY;
	}
	
	if(!defined('UPPSITE_API_SECRET')){
		define('UPPSITE_API_SECRET',$options['uppsite_secret']);
	} elseif (isset($options['uppsite_secret']) && !empty($options['uppsite_secret'])) {
		$require_update_options = true;
		$options['uppsite_secret'] = UPPSITE_API_SECRET;
	}
	
	if ($require_update_options) {
		update_option('uppsite_options', $options);
	}
}

/* send notifaction to Uppsite server 
@param int $post_id new post id
*/
function mysiteapp_send_push($post_id, $post_details = NULL) {
	mysiteapp_init_keys();

	if (!$post_details)
		$post_details = get_post($post_id, ARRAY_A);
	$title = $post_details['post_title'];
 	
   $url = MYSITEAPP_PUSHSERVICE;
   $data = array();
   $data['title'] = $post_details['post_title'];
   $data['post_id'] = $post_details['ID'];
   $data['utime'] = mysiteapp_convert_datetime($post_details['post_date']);
   $data['api_key'] = UPPSITE_API_KEY;
   
   $json_str = json_encode($data);
   $hash = mysiteapp_sign_message($json_str);
   
   $post_data = array('body' =>'data='.$json_str.'&hash='.$hash);
   $post_data['timeout'] = '5';
   
   wp_remote_post($url,$post_data);
}

function mysiteapp_new_post_push($post_id){
	//if( ( $_POST['post_status'] == 'publish' ) && ( $_POST['original_post_status'] != 'publish' && $_POST['sticky']!='sticky' ) ) {
	if( ( $_POST['post_status'] == 'publish' ) && ( 
		(isset($_POST['original_post_status']) && $_POST['original_post_status'] != $_POST['post_status']) || (isset($_POST['_status']) && $_POST['_status'] != $_POST['post_status']) 
		) ) {
		mysiteapp_send_push($post_id);
	}
}

function mysiteapp_future_post_push($post_id){
	$post_details = get_post($post_id, ARRAY_A);
	
	if ($post_details['post_status'] == 'publish' && !$_POST && false==(isset($post_details['sticky']) && $post_details['sticky']=='sticky')) {
		mysiteapp_send_push($post_id, $post_details);
	}
}
  

function mysiteapp_is_need_new_link(){


	$last_check = get_option('uppsite_lastupdate_link');
	
	if(!$last_check) return true;
	
	
	
	$week = 60*60*24*7;
	
	if(mktime()>$week+$last_check) return true;

	return false;

}

function mysiteapp_admin_init() {
	$require_options_update = false;
	$options = get_option('uppsite_options');
	
	if (!isset($options['uppsite_plugin_version'])) {
		$options['uppsite_plugin_version'] = MYSITEAPP_PLUGIN_VERSION;
		$require_options_update = true;
		
		// legacy fix
		$options['option_popup'] = 'Yes';
		$options['option_popup_time'] = 'Everytime';
	} elseif ($options['uppsite_plugin_version']!=MYSITEAPP_PLUGIN_VERSION) {
		$options['uppsite_plugin_version'] = MYSITEAPP_PLUGIN_VERSION;
		$require_options_update = true;
	}
	
	if ($require_options_update)
		update_option('uppsite_options', $options);
	
	mysiteapp_init_keys($options);
	
	mysiteapp_get_app_links();
}

function mysiteapp_get_app_links(){

	if(!mysiteapp_is_need_new_link()) return;

	$hash = mysiteapp_sign_message(UPPSITE_API_KEY);
	
	$get = '?api_key='.UPPSITE_API_KEY.'&hash='.$hash;
	
	$response = wp_remote_get(MYSITEAPP_APP_DOWNLOAD_URL.$get);
	if (!is_wp_error($response)) {
		$data = json_decode($response['body'],true);
		if($data) {
			foreach($data as $key=>$value) {
				update_option('uppsite_link_'.$key,$data[$key]['id']);
			}
			update_option('uppsite_lastupdate_link',mktime());
		}
	}
}

function mysiteapp_get_plugin_version() {
	return MYSITEAPP_PLUGIN_VERSION;
}

function mysiteapp_is_user_need_link($last_time){


	$options = get_option('uppsite_options');
	$date_arr = array("Everytime"=>1, "Every Hour"=>60*60,"Every Day"=>60*60*24,"Every Week"=>60*60*24*7,"Every Month"=>60*60*24*30);
	
	$time_to_wait = $date_arr[$options['option_popup_time']];
	
	if(mktime()>$time_to_wait+$last_time) return true;
	
	
	return false;
}


function mysiteapp_set_javascript_link(){
	global $download_link;
	
	$options = get_option('uppsite_options');
	$url_id = NULL;
	
	if ($options['option_popup'] == 'No') return;

	if (isset($_COOKIE['uppsite_last_link']) && is_numeric($_COOKIE['uppsite_last_link'])){
		if (!mysiteapp_is_user_need_link($_COOKIE['uppsite_last_link'])) 
			return;
	}
	
	if (stristr($_SERVER['HTTP_USER_AGENT'],'iphone') || strstr($_SERVER['HTTP_USER_AGENT'],'iphone') ) {
		$url_id = get_option('uppsite_link_iphone');
	} elseif( stristr($_SERVER['HTTP_USER_AGENT'],'android') ) {
		$url_id = get_option('uppsite_link_android');
	}
	
	if ($url_id){		
		$download_link = MYSITEAPP_APP_CLICK_URL.'?id='.$url_id;
		setcookie('uppsite_last_link', ''.time(),time()+60*60*24*30,"/");//, "/", str_replace('http://www','',get_bloginfo('url')) );
	}
	
}



function mysiteapp_show_link(){
	global $download_link;
	
	if(is_home() && $download_link){
	
		echo"<script type='text/javascript'>
				if (confirm('This website has a native app for your phone! Would you like to download it now?')) 
				 window.location.href='{$download_link}';
				 </script>
				";
		}

}

function mysiteapp_get_pic_from_fb_id($fb_id){

		return 'http://graph.facebook.com/'.$fb_id.'/picture?type=small';
}

function mysiteapp_get_pic_from_fb_profile($fb_profile){

	if(stripos($fb_profile,'facebook') === FALSE) return false;
	$user_id  = basename($fb_profile);
	
	return mysiteapp_get_pic_from_fb_id($user_id);

}

function mysiteapp_get_member_for_comment(){
	
	
	$disq = true;
	$need_g_avatar = true;
	$res = '';
	$user = array();
   
    $user['auther'] = get_comment_author();
	$user['link'] = get_comment_author_url();
	
	$options = get_option('uppsite_options');
	
	// add facebook pic to user
	if(isset($options['disqus'])){
		
		$user['avatar'] = mysiteapp_get_pic_from_fb_profile($user['link']);
		if($user['avatar'])  $need_g_avatar = false;
	
	}
	if($need_g_avatar){
	
		if(function_exists('get_avatar') && function_exists('htmlspecialchars_decode')){
			$user['avatar']  = htmlspecialchars_decode(mysiteapp_extract_url(get_avatar(get_comment_author_email())));
			
		}
	}
		
	$res = sprintf('<member>
			<name><![CDATA[%s]]></name>
			<member_link><![CDATA[%s]]></member_link>
			<avatar><![CDATA[%s]]></avatar>
		</member>', $user['auther'],$user['link'],$user['avatar']);
			
			
	 return $res; 
}


function mysiteapp_print_single_facebook_comment($fb_comment){

	$avatar_url = mysiteapp_get_pic_from_fb_id($fb_comment['from']['id']);

	return sprintf('<comment ID="%s" post_id="%d" isApproved="true">
				<permalink><![CDATA[%s]]></permalink>
				<time><![CDATA[%s]]></time>
				<unix_time><![CDATA[%d]]></unix_time>
				<member>
					<name><![CDATA[%s]]></name>
					<member_link><![CDATA[]]></member_link>
					<avatar><![CDATA[%s]]></avatar>
				</member>
				<text><![CDATA[%s]]> </text>
	            </comment>
	            ',$fb_comment['id'],get_the_ID(),get_permalink(),
	           $fb_comment['created_time'],strtotime($fb_comment['created_time']),$fb_comment['from']['name'],$avatar_url,$fb_comment['message']);		
}


function mysiteapp_print_facebook_comments(&$comment_counter){
	$permalink = get_permalink();
	$comments_url = MYSITEAPP_FACEBOOK_COMMENTS_URL.$permalink;
	$res = '';
	$comment_counter = 0;
	
	
	//fetch comments from facebook.com
	$comment_json = wp_remote_get($comments_url);
	if (is_wp_error($comment_json)) { return $res; }
	$avatar_url = htmlspecialchars_decode(mysiteapp_extract_url(get_avatar(0)));

	//check if comments exist
	if($comment_json){
		$comments_arr = json_decode($comment_json['body'],true);
		
		//check if comments exist
		if ($comments_arr == NULL||
			!array_key_exists($permalink,$comments_arr) ||
			!array_key_exists('data',$comments_arr[$permalink])) {
			return;
		}
		
		$comments_list = $comments_arr[$permalink]['data'];
		
		foreach($comments_list as $comment){
		
			$res .= mysiteapp_print_single_facebook_comment($comment,$avatar_url);
			//inner comment
			if(key_exists('comments',$comment)){
				foreach($comment['comments']['data'] as $inner_comment){					
				
					$res .= mysiteapp_print_single_facebook_comment($inner_comment);
		$comment_counter++;
				}
		
			}
		
			$comment_counter++;
		}
		//print formated comment
		
	}
	return $res;
}


function mysiteapp_comment_other_system($location,$comment){
	global $msap;
	
	if(!$msap->is_device()){
		return $location;
	}

	$options = get_option('uppsite_options');
	
	if(isset($options['disqus']) && $options['disqus']){
		mysiteapp_comment_to_disq($location, $comment);
	} else{
		return $location;
	}
}

function mysiteapp_comment_to_facebook(){
	$options = get_option('uppsite_options');
	$val = (get_query_var('msa_facebook_comment_page') ? get_query_var('msa_facebook_comment_page') : NULL );
	if($val){
	 if(isset($options['fbcomment']) && !isset($_POST['comment'])){

		print mysiteapp_facebook_comments_page();
		exit;
	}
   }
}

function mysiteapp_comment_to_disq($location, $comment=NULL){
	global $msap;
	if ($msap->is_device()){
	$shortname  = strtolower(get_option('disqus_forum_url'));
	$disq_thread_url = '.disqus.com/thread/';
	$options = get_option('uppsite_options');
		if ($comment==NULL)
			$comment = $location;
	
	if(isset($options['disqus']) && strlen($shortname)>1){
		$post_details = get_post($comment->comment_post_ID, ARRAY_A);
		$fixed_title = str_replace(' ', '_', $post_details['post_title']);
		$fixed_title = strtolower($fixed_title);
		$str = 'author_name='.$comment->comment_author.'&author_email='.$comment->comment_author_email.'&subscribe=0&message='.$comment->comment_content;
		$post_data = array('body' =>$str);
		$url = 'http://'.$shortname.$disq_thread_url.$fixed_title.'/post_create/';
		$result = wp_remote_post($url,$post_data);
	}
}
	return $location;
}

function mysiteapp_fix_content_more($more){
	global $msap;
	if($msap->is_device()){
		return '(...)';
	}
	return $more;
}

function mysiteapp_get_sidebar_hide() {
	$val = (get_query_var('sidebar_hide') ? get_query_var('sidebar_hide') : NULL );
	return $val;
}

function mysiteapp_get_posts_hide() {
	$val = (get_query_var('posts_hide') ? get_query_var('posts_hide') : NULL );
	return $val;
}

function mysiteapp_get_posts_list_view() {
	$val = (get_query_var('posts_list_view') ? get_query_var('posts_list_view') : NULL );
	return $val;
}

function mysiteapp_is_show_post_content($iterator=0, $posts_list_view='0') {
	if ($posts_list_view == '0')
		$posts_list_view = mysiteapp_get_posts_list_view();
	if (empty($posts_list_view) || $posts_list_view == 'full' || ($iterator==0 && ($posts_list_view=='ffull_rexcerpt' || $posts_list_view=='ffull_rtitle' ) ))
		return true;
	return false;
}

function mysiteapp_is_posts_hide() {
	if (mysiteapp_get_posts_hide() == '1')
		return true;
	return false;
}

function mysiteapp_is_sidebar_hide() {
	if (mysiteapp_get_sidebar_hide() == '1')
		return true;
	return false;
}

function mysiteapp_query_vars($public_query_vars) {
	$public_query_vars[] = 'sidebar_hide';
	$public_query_vars[] = 'posts_hide';
	$public_query_vars[] = 'posts_list_view';
	$public_query_vars[] = 'msa_facebook_comment_page';
	return $public_query_vars;
}
function  mysiteapp_fix_content_fb_social($content){

	global $msap;
	$fixed_content =  $content;

	if ($msap->is_device()){
	
			
	
			$fixed_content = preg_replace('/<p class=\"FacebookLikeButton\">.*?<\/p>/','',$content);				
			$fixed_content = preg_replace('/<iframe id=\"basic_facebook_social_plugins_likebutton\" .*?<\/iframe>/','',$fixed_content);				
		}

    return $fixed_content;
    

}

function mysiteapp_function_clean_helper($func,$parms = array()){


	mysiteapp_clean_buff();	
	
	return call_user_func_array($func,$parms);	
	
	
}

function mysiteapp_clean_buff(){

	ob_start(); 
	ob_end_clean();	
}

function mysiteapp_fix_cache_plugins() {
    // WP Super Cache
    if (function_exists('wp_cache_edit_rejected_ua')) {
	    global $valid_nonce, $cache_rejected_user_agent;
	    if (!in_array(MYSITEAPP_AGENT, $cache_rejected_user_agent)) {
	    	$cache_rejected_user_agent[] = MYSITEAPP_AGENT;
	    	$valid_nonce = true;
	    	ob_start();
	    	$_POST['wp_rejected_user_agent'] = implode("\n", $cache_rejected_user_agent);
	    	wp_cache_edit_rejected_ua();
	    	ob_end_clean();
	    }
	}
	// W3 Total Cache
	if (class_exists('W3_Plugin_TotalCacheAdmin') &&
		(!isset($_REQUEST['page']) || stristr($_REQUEST['page'], "w3tc_") === false)) {
		// Make changes only if the user isn't modifying W3 Total Cache settings
		$w3_config = & w3_instance('W3_Config');
		$w3_total_cache_plugins = array('PgCache', 'Minify', 'Cdn');
		$save = array();
		foreach ($w3_total_cache_plugins as $w3tc_plugin) {
			// Search for the Rejected UAs for each plugin
			$key = strtolower($w3tc_plugin) . '.reject.ua';
			$rejectArr = $w3_config->get_array($key);
			if (!in_array(MYSITEAPP_AGENT, $rejectArr)) {
				array_push($rejectArr, MYSITEAPP_AGENT);
				$w3_config->set($key, $rejectArr);
				// Schedule saving for each plugin
				$save[] = $w3tc_plugin;
			}
		}
		if (count($save) > 0) {
			$w3_config->save(false);
			foreach ($save as $plugin) {
				$w3tc_admin_instance = & w3_instance('W3_Plugin_' . $plugin . 'Admin');
				if (!is_null($w3tc_admin_instance)) {
					if (method_exists($w3tc_admin_instance, 'write_rules_core')) {
						$w3tc_admin_instance->write_rules_core();
					}
					if (method_exists($w3tc_admin_instance, 'write_rules_cache')) {
						$w3tc_admin_instance->write_rules_cache();
					}
				}
			}
		}
	}
}

function mysiteapp_fix_plugins() {
	if (!defined("MYSITEAPP_RUNNING")) { return; }
	// All in One SEO Plugin
	global $aioseop_options;
	if (is_array($aioseop_options)) {
		$curPage = trim($_SERVER['REQUEST_URI'],'/');
		if (!isset($aioseop_options['aiosp_ex_pages'])) {
			$aioseop_options['aiosp_ex_pages'] = $curPage;
		} else {
			$aioseop_options['aiosp_ex_pages'] .= ",".$curPage;
		}
	}
}
add_action('init', 'mysiteapp_fix_plugins');

add_action('init', 'mysiteapp_set_javascript_link');
add_action('wp_head', 'mysiteapp_show_link');

if ($msap->is_webapp())
	add_action('wp_head', 'mysiteapp_head');

add_action( 'admin_menu', 'mysitapp_admin_add_pages', 9 );

add_action('admin_init','mysiteapp_fix_cache_plugins',10);
//add_filter('template', 'mysiteapp_get_template');
add_filter('wp_die_handler','call_error');
//add_filter('stylesheet', 'mysiteapp_get_stylesheet');
add_filter('the_category','mysiteapp_list_cat');
add_filter('the_tags','mysiteapp_list_tags');
add_filter('wp_list_categories','mysiteapp_list_cat');
add_filter('get_archives_link','mysiteapp_list_archive');
add_filter('wp_list_pages','mysiteapp_list_pages');
add_filter('wp_list_bookmarks','mysiteapp_list_links');
if ( function_exists('wp_tag_cloud') )
	add_filter('wp_tag_cloud','mysiteapp_tag_cloud');
add_filter('next_posts_link','mysiteapp_navigation');
add_filter('authenticate', 'mysiteapp_login', 2, 3);
add_action('wp_logout', 'mysiteapp_logout', 30);
//add_filter('redirect_post_location','mysiteapp_createpost',2,3);
add_action('comment_author', 'mysiteapp_comment_author');
add_action('load-post-new.php', 'mysiteapp_post_new');
add_action('save_post', 'mysiteapp_post_new_process');
add_action('publish_post','mysiteapp_new_post_push',10,1);
add_action('publish_future_post','mysiteapp_future_post_push',10,1);
add_action('admin_init','mysiteapp_admin_init',10);
add_filter('query_vars', 'mysiteapp_query_vars');
add_filter('comment_post_redirect','mysiteapp_comment_to_disq',10,2);
add_action('template_redirect','mysiteapp_comment_to_facebook',10);
add_filter('the_content_more_link','mysiteapp_fix_content_more',10,1);
add_filter('the_content','mysiteapp_fix_content_fb_social',20,1);



endif; /*if (!defined('MYSITEAPP_AGENT')):*/