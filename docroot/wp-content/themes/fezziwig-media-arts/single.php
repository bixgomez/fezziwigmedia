<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Fezziwig_Media_Arts
 */
?>

<?php get_header(); ?>

<!-- single.php -->

<?php

$has_gallery = 0;

// Get the selected gallery ID
if ( function_exists('get_field') ) {
    $gallery_id = get_field('gallery_id');
    if ( $gallery_id ) {
        // Check if the post content already includes the gallery shortcode
        $post_content = get_the_content();
        if ( strpos($post_content, '[ngg') === false && strpos($post_content, '[gallery') === false ) {
            $has_gallery = 1;
            // Only add the shortcode if it is not already present
        }
    }
}
?>

<?php
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        ?>
        <main id="content" role="main" class="section site-content">
            <div id="content-inner" class="section-inner">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="article-content <?php echo $has_gallery ? 'has-gallery' : 'no-gallery'; ?>">   
                        <div class="article-body">
                            <header class="entry-header">
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                            </header>
                            <div class="entry-content">
                                <?php the_content(); ?>
                                <?php
                                $external_link = get_field('external_link');
                                if ( $external_link ) {
                                    $url = $external_link['url'];
                                    $title = $external_link['title'] ? $external_link['title'] : 'Click Here';
                                    $target = $external_link['target'] ? $external_link['target'] : '_self';

                                    echo '<p><a href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '">' . esc_html( $title ) . '</a></p>';
                                }
                                ?>
                            </div>
                            <div class="post-navigation">
                                <?php
                                // Get previous and next posts in the same category
                                $prev_post = get_previous_post(true, '', 'category');
                                $next_post = get_next_post(true, '', 'category');
                                ?>
                                <div class="prev-post">
                                    <?php if (!empty($next_post)) : ?>
                                        <a href="<?php echo get_permalink($next_post->ID); ?>">&larr; <?php echo get_the_title($next_post->ID); ?></a>
                                    <?php endif; ?>
                                </div>
                                <div class="next-post">
                                    <?php if (!empty($prev_post)) : ?>
                                        <a href="<?php echo get_permalink($prev_post->ID); ?>"><?php echo get_the_title($prev_post->ID); ?> &rarr;</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>                        
                        <?php if ( $has_gallery ) { ?>
                        <aside class="article-sidebar"> 
                            <?php echo do_shortcode("[ngg src='galleries' ids='{$gallery_id}' display='basic_thumbnail']"); ?>
                        </aside>
                        <?php } ?>
                    </div>
                </article>
            </div>
        </main>
        <?php
    endwhile;
endif;
?>
<!-- /single.php -->

<?php get_footer();
