<?php
echo '<!-- post-teasers.php -->';
$category_id = get_field('post_teasers_category');
if( $category_id ) :
    $args = array(
        'cat' => $category_id,
        'posts_per_page' => 5,
    );
    $query = new WP_Query( $args );
    if( $query->have_posts() ) : ?>
        <ul class="post-teasers">
            <?php while( $query->have_posts() ) : $query->the_post(); ?>
                <li>
                    <?php if( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('thumbnail'); ?>
                        </a>
                    <?php endif; ?>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p><?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?></p>
                </li>
            <?php endwhile; ?>
        </ul>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p>No posts found in this category.</p>
    <?php endif;
else :
    echo '<p>No category selected.</p>';
endif;
?>
