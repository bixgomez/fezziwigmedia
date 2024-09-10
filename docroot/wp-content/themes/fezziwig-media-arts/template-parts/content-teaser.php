<?php
/**
 * Template part for displaying post teasers
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fezziwig_Media_Arts
 */

?>

<!-- content-teaser.php -->
<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'post-teaser' ) ); ?>>

	<div class="post-teaser-image">
		<?php the_post_thumbnail('thumbnail'); ?>
	</div>

	<div class="post-teaser-text">
		<header class="entry-header">
			<?php
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'fezziwig-media-arts' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fezziwig-media-arts' ),
					'after'  => '</div>',
				)
			);
			?>

			<?php
				$external_link = get_field('external_link', $post->ID);
				if ( $external_link ) :
					$link_url = $external_link['url']; // Get the URL
					$link_text = $external_link['title'] ? $external_link['title'] : $link_url; // Use URL if no title
					$link_target = $external_link['target'] ? $external_link['target'] : '_self'; // Get target, default to _self
					?>
					<p class="external-link">
						<a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" rel="noopener noreferrer">
							<?php echo esc_html($link_text); ?>
						</a>
					</p>
			<?php endif; ?>

		</div><!-- .entry-content -->
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
<!-- /content-teaser.php -->