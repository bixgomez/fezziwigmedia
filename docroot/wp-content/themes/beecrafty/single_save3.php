<?php get_header(); ?>

<div id="content-sidebar-wrap">

	<div id="content" class="hfeed">
		<?php the_post() ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<div class="post-info">
			<?php the_time('j F, Y'); ?>
		</div>
		<div class="entry-content">

			<?php
			if ( has_post_thumbnail() ) {
				echo ("<div id=\"main-image\">");
				the_post_thumbnail('medium');
				echo ("</div>");
			} 
			?>

			<?php
			if (class_exists('MultiPostThumbnails') && MultiPostThumbnails::has_post_thumbnail('post', 'second-image')) {
				echo ("<div id=\"sub-image-1\">");
				MultiPostThumbnails::the_post_thumbnail('post', 'second-image', NULL, 'medium');
				echo ("</div>");
			}
			?>

			<?php
			if (class_exists('MultiPostThumbnails') && MultiPostThumbnails::has_post_thumbnail('post', 'third-image')) {
				echo ("<div id=\"sub-image-2\">");
				MultiPostThumbnails::the_post_thumbnail('post', 'third-image', NULL, 'medium');
				echo ("</div>");
			}
			?>

			<?php
			if (class_exists('MultiPostThumbnails') && MultiPostThumbnails::has_post_thumbnail('post', 'fourth-image')) {
				echo ("<div id=\"sub-image-3\">");
				MultiPostThumbnails::the_post_thumbnail('post', 'fourth-image', NULL, 'medium');
				echo ("</div>");
			}
			?>
			
			<?php 
			echo ("<div id=\"the-content\">");
			the_content(); 
			echo ("<div id=\"sub-image-3\">");
			?>
			
		</div>
	</div>
	
	<?php get_sidebar(); ?>
	
</div> <!-- /content-sidebar-wrap -->

<?php get_footer(); ?>