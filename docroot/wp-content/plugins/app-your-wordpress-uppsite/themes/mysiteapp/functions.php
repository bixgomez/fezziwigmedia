<?php 

header ("content-type: text/xml"); 
remove_all_filters('get_sidebar');
remove_all_filters('get_header');
remove_all_filters('get_footer');
remove_all_filters('the_post');
//remove_all_filters('the_content');
remove_all_actions('loop_start');
remove_all_actions('loop_end');
remove_all_actions('the_excerpt');
remove_all_actions('wp_footer');
remove_all_actions('wp_print_footer_scripts');
remove_all_actions('comments_array');
remove_all_filters('comments_number');

function readintro($filename)
{		
	$path = TEMPLATEPATH . '/' . $filename;
	if ( file_exists( $path ) )		
		print file_get_contents($path);
}

// Widget Settings

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Sidebar',
		'before_widget' => '<div id="%1$s" class="sidebarbox">', 
	'after_widget' => '</div>', 
	'before_title' => '<h3>', 
	'after_title' => '</h3>', 
	));
	
function widget_webdemar_search() {
?>
    	<div class="sidebarbox">
			<h3>Search</h3>
				<div class="searchform">
					<form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
						<input type="text" name="s" id="search" />	
						<input type="hidden" id="search-submit" value="Search" />		
					</form>
				</div>
		</div>
	
<?php
}

if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Search'), 'widget_webdemar_search');

?>