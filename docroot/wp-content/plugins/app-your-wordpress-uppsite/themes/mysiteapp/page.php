<?php 
$mysiteapp_is_posts_hide = mysiteapp_is_posts_hide();
$mysiteapp_is_sidebar_hide = mysiteapp_is_sidebar_hide();
if (false == $mysiteapp_is_posts_hide) {
	$posts_list_view = mysiteapp_get_posts_list_view();
	$uppsite_options = get_option('uppsite_options');
	$paged = (get_query_var('paged') ? get_query_var('paged') : ( $page ? $page : 1) );
	
	if (is_front_page() && (!isset($uppsite_options['option_homepagelist']) || (isset($uppsite_options['option_homepagelist']) && $uppsite_options['option_homepagelist']=='Yes')) ) {
		$args=array('showposts'=>10, 'paged'=>$paged );
		if (isset($uppsite_options['option_sticky']) && $uppsite_options['option_sticky']=='Yes'){
			// exclude sticky
			$sticky = get_option('sticky_posts') ;
			
			if (get_bloginfo('version') >= 3.1)
				$args['ignore_sticky_posts'] = 1;
			else 
				$args['caller_get_posts'] = 1;
		}
		query_posts($args);
	}
}
?>
<?php get_header(); ?>

<title><![CDATA[SeoAllInOneFIX]]></title>
<posts success="<?php if (have_posts()) : ?>true<?php else: ?>false<?php endif; ?>">
 <!-- posts  -->
<?php if (false == $mysiteapp_is_posts_hide && have_posts()) : $iterator = 0; ?>

	<?php while (have_posts()) : the_post(); ?>
	
     <?php  mysiteapp_print_post(false, $iterator, $posts_list_view); $iterator++;  ?>
		
	<?php endwhile; ?>
	<?php comments_template(); ?>	
<?php endif; ?>
</posts>
<?php if (false == $mysiteapp_is_sidebar_hide): ?>
	<?php get_sidebar(); ?>
<?php else: ?>
	<?php get_sidebar('compact'); ?>
<?php endif;?>
<?php get_footer('nav'); ?>