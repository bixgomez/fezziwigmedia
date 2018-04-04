<!-- start sliding boxes -->
<div class="homepage-gallery">
	<?php $recent = new WP_Query(array('cat' => genesis_get_option('gallery_cat'), 'showposts' => genesis_get_option('number_images'))); while($recent->have_posts()) : $recent->the_post();?>
		<div class="polaroid-bg">
			<div class="boxgrid slidedown">
				<a href="<?php the_permalink() ?>" rel="bookmark"><?php genesis_image(array('format' => 'html', 'size' => 'Gallery', 'attr' => array('class' => 'cover'))); ?></a>
				<a href="<?php the_permalink() ?>" rel="bookmark">
					<h3><?php $title = the_title('','',FALSE); echo substr($title, 0, 20); ?></h3>
					<?php
						$subtitle = get_post_meta
						($post->ID, 'subtitle', $single = true);
						if($subtitle !== '') echo '<h4>' . $subtitle . '</h4>';
					?>
				</a>
				<!-- comment this line out remove the author -->
				<!-- <p>by <?php the_author(); ?></p> -->
                <!-- uncomment this line to use an excerpt instead -->
				<!--?php the_content_limit('30',' more &raquo'); ?-->
			</div>
		</div>
	<?php endwhile; ?>
</div>