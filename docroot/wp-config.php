<?php
# Database Configuration
define( 'DB_NAME', 'FezziwigWebWorks' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'dungar33z' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
$table_prefix = 'wp_';



# Security Salts, Keys, Etc
define( 'AUTH_KEY', '9cQnf)=VFSU(l(0W:7-g&Tkc4b+|Brz%ViH4~VUooojkM[*6-&t7^TFs<)jP|Tf/' );
define( 'SECURE_AUTH_KEY', '@mrPXCW|=h*s-+W0~@{zxf~`cI.:P 5&&j$JnNfN<5Jc]2E ^7tVTG}hTf*xF!qV' );
define( 'LOGGED_IN_KEY', '*7hfxq|r15]>JW=Fh?4_fHGM(zgQn9JqT&]|jxr0n>l`U0kQ #F~e[dB!5Lyh&CD' );
define( 'NONCE_KEY', 'k]#+QB5j?*jpND^-HMJa!lmpRmn]mxmZ-#[G^{/!Af91j}opv#k|,:AuC:+(^4fM' );
define( 'AUTH_SALT', '_"w7E59*vb+pl5)/lF"2DLGVvoq+*X/J}?l%Iq$bx/8zPou[}-W!S2CWDl<9OB.-' );
define( 'SECURE_AUTH_SALT', 'cOU8yK3:8,%>~S/YLGn5a|(G6:T]G-w`37$94Nv3|A:VajALH_G8|5Imh~Sr;Loy' );
define( 'LOGGED_IN_SALT', '>2LiSEBQm?.be~8}nOAD>_@)W(6)-Q1Bl8w8F/7Lf{b(*K8Ye|bGckZC{8:GOsVT' );
define( 'NONCE_SALT', '5(NGKd{lzrU~gCJ-[!epX"E:x]~(yEaAgG{fu`[uAC=0"]a~E^Z)cX:W^bV!3_H)' );



# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'fezziwig' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', '5be5950df2b310f12e95b6356cd99bbc5869da28' );

define( 'WPE_FOOTER_HTML', "<a href=\"http://wpengine.com/\" target=\"_blank\">Best Hosting For WordPress</a>" );

define( 'WPE_CLUSTER_ID', '101141' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', true );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_LBMASTER_IP', '' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'fezziwigwebworks:8888', 1 => 'fezziwigwebworks:8888', 2 => 'fezziwigwebworks:8888', );

$wpe_varnish_servers=array ( 0 => 'pod-101141', );

$wpe_special_ips=array ( 0 => '35.184.103.223', );

$wpe_ec_servers=array ( );

$wpe_largefs=array ( );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( 'default' =>  array ( 0 => 'unix:///tmp/memcached.sock', ), );
define( 'WPLANG', '' );



# WP Engine Settings





define( 'WPE_CACHE_TYPE', 'standard' );

























$wpe_profiler_path = null;


/*SSLSTART*/
if ( isset( $_SERVER['HTTP_X_WPE_SSL'] ) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on';
/*SSLEND*/



# Custom Settings











define( 'WP_DEBUG', false );

$_wpe_preamble_path = null;



# That's It. Pencils down
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}
require_once( ABSPATH . 'wp-settings.php' );

$_wpe_preamble_path = null; if(false){}
