<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Fezziwig_Media_Arts
 */

get_header();
?>

	<main id="content" role="main" class="section site-content">
		<div id="content-inner" class="section-inner">

			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
							<h1 class="entry-title"><?php the_title(); ?></h1>
					</header>
					<div class="entry-content">
							<?php
							// Display the post content
							the_content();

							// Get the selected gallery ID
							if ( function_exists('get_field') ) {
									$gallery_id = get_field('gallery_id');
									if ( $gallery_id ) {
											echo do_shortcode("[ngg src='galleries' ids='{$gallery_id}' display='basic_thumbnail']");
									}
							}
							?>
					</div>
				</article>
			<?php endwhile; ?>

		</div>
	</main><!-- #main -->

<?php
get_footer();
