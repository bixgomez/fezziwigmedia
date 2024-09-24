<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fezziwig_Media_Arts
 */

get_header();
?>

<!-- category.php -->
<main id="content" role="main" class="section site-content">
	<div id="content-inner" class="section-inner">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */

			$category = get_queried_object();
			$category_slug = $category->slug;

			echo '<div class="post-teasers post-teasers--' . $category->slug . '">';

			while ( have_posts() ) :
				the_post();
				// First, try to include the template part specific to the current category
				if ( locate_template( 'template-parts/content-teaser-' . $category_slug . '.php', false, false ) ) {
					// Include the category-specific template (like content-teaser-presentations.php)
					get_template_part( 'template-parts/content-teaser', $category_slug );
				} elseif ( locate_template( 'template-parts/content-teaser.php', false, false ) ) {
						// Fallback to the general teaser template
						get_template_part( 'template-parts/content-teaser' );
				} else {
						// Final fallback if neither exist
						get_template_part( 'template-parts/content' );
				}
			endwhile;

			echo '</div>';

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</div>
</main><!-- #main -->

<?php
get_sidebar();
get_footer();
