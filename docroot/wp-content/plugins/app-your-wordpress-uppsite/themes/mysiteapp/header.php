<?php 

header ("content-type: text/xml; charset=UTF-8"); 

print '<?xml version="1.0" encoding="UTF-8"?>';
print "\n";
printf('<mysiteapp result="true" wordpress_version="%s" plugin_version="%s">',get_bloginfo('version'), 
	( function_exists('mysiteapp_get_plugin_version') ? mysiteapp_get_plugin_version() : null ) );

	if(function_exists('wp_get_current_user'))
	{
		//print wp_logout_url();
		$current_user = wp_get_current_user();
		printf('<user ID="%s"><name><![CDATA[%s]]></name><logout_hash><![CDATA[%s]]></logout_hash><logout_url><![CDATA[%s]]></logout_url><login_url><![CDATA[%s]]></login_url></user>'
		,$current_user->ID
		,$current_user->user_login
		,wp_create_nonce('log-out')
		,mysiteapp_logout_url_wrapper()
		,site_url('wp-login.php'));
	
	} 


?>