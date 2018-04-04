<?php get_header(); ?>

<title><![CDATA[SeoAllInOneFIX]]></title>
	<?php if (have_posts()) : ?>
	<?php mysiteapp_clean_buff(); ?>
	<?php while (have_posts()) :  ob_start();  the_post(); ?>
	<?php ob_end_clean(); ?>
	<?php  mysiteapp_function_clean_helper('mysiteapp_print_post',array(false));   ?>
	<?php 
		$options = get_option('uppsite_options');
		if(isset($options['disqus'])){
			remove_filter('comments_template', 'dsq_comments_template'); 
		}
	
	?>
	<?php comments_template(); ?>
	
	
	<?php ob_start(); endwhile; ?>
	<?php ob_end_clean(); ?>
	
<?php endif; ?>

<?php get_footer('nav'); ?>
<?php mysiteapp_clean_buff(); ?>