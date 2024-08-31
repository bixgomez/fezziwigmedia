<?php
echo '<!-- post-teasers.php -->';
$category_id = get_field('post_teasers_category');
if( $category_id ) :
  $category = get_category($category_id); // Get the category object
  ?>
  <h2><?php echo esc_html($category->name); ?></h2> <!-- Display category name -->
  <p><?php echo esc_html($category->description); ?></p> <!-- Display category description -->
  <?php
  $args = array(
    'cat' => $category_id,
    'posts_per_page' => 5,
  );
  $query = new WP_Query( $args );
  if( $query->have_posts() ) : ?>
    <ul class="post-teasers">
      <?php while( $query->have_posts() ) : $query->the_post(); ?>
        <li>
          <?php get_template_part('template-parts/blocks/post-teaser'); ?>
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
