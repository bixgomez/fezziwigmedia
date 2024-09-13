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

<?php
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        ?>
        <main id="content" role="main" class="section site-content">
            <div id="content-inner" class="section-inner">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <div class="article-content">
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
                        </div>
                        <aside class="article-sidebar"> 
                            <?php
                            // Get the selected gallery ID
                            if ( function_exists('get_field') ) {
                                $gallery_id = get_field('gallery_id');
                                if ( $gallery_id ) {
                                    // Check if the post content already includes the gallery shortcode
                                    $post_content = get_the_content();
                                    if ( strpos($post_content, '[ngg') === false && strpos($post_content, '[gallery') === false ) {
                                        // Only add the shortcode if it is not already present
                                        echo do_shortcode("[ngg src='galleries' ids='{$gallery_id}' display='basic_thumbnail']");
                                    }
                                }
                            }
                            ?>
                        </aside>
                    </div>
                </article>
            </div>
        </main>
        <?php
    endwhile;
endif;
?>

<?php get_footer();
 
