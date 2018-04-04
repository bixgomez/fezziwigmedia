<?php get_header(); ?>

<?php genesis_before_content_sidebar_wrap(); ?>
<div id="content-sidebar-wrap">

	<?php genesis_before_content(); ?>
	<div id="content" class="hfeed">

		<div id="featured-properties">
			<?php if (!dynamic_sidebar('Featured Properties')) : ?>
			<div class="widget">
				<h4><?php _e("Featured Properties", 'genesis'); ?></h4>
				<p><?php _e("This is a widgeted area which is called Featured Properties. It is using the Genesis - Featured Posts widget to display what you see on the AgentPress child theme demo site. To get started, log into your WordPress dashboard, and then go to the Appearance > Widgets screen. There you can drag the Genesis - Featured Posts widget into the Featured Properties widget area on the right hand side. To get the image to display, simply upload an image through the media uploader on the edit page screen and publish your page. The Featured Posts widget will know to display the post image as long as you select that option in the widget interface.", 'genesis'); ?></p>
			</div><!-- end .widget -->
			<?php endif; ?>
		</div><!-- end #featured-properties -->
		
		<div id="featured-posts">
			<?php if (!dynamic_sidebar('Featured Posts')) : ?>
			<div class="widget">
				<h4><?php _e("Featured Posts", 'genesis'); ?></h4>
				<p><?php _e("This is a widgeted area which is called Featured Posts. It is using the Genesis - Featured Posts widget to display what you see on the AgentPress child theme demo site. To get started, log into your WordPress dashboard, and then go to the Appearance > Widgets screen. There you can drag the Genesis - Featured Posts widget into the Featured Properties widget area on the right hand side. To get the image to display, simply upload an image through the media uploader on the edit page screen and publish your page. The Featured Posts widget will know to display the post image as long as you select that option in the widget interface.", 'genesis'); ?></p>
			</div><!-- end .widget -->	
			<?php endif; ?>
		</div><!-- end #featured-posts -->

	</div><!-- end #content -->
	<?php genesis_after_content(); ?>

</div><!-- end #content-sidebar-wrap -->
<?php genesis_after_content_sidebar_wrap(); ?>

<?php get_footer(); ?>