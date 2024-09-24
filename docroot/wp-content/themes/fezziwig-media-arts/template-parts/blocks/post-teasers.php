<?php
echo '<!-- post-teasers.php -->';
$category_id = get_field('post_teasers_category');
if( $category_id ) :
  $category = get_category($category_id);
  $category_slug = $category->slug;
  $category_name = $category->name;
  $category_description = $category->description;
  ?>
  <h2><?php echo esc_html($category_name); ?></h2>
  <p><?php echo esc_html($category_description); ?></p>
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
          <?php 
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
          ?>
        </li>
      <?php endwhile; ?>
    </ul>
    <?php
    // Reset post data after the loop
    wp_reset_postdata();
    ?>
  <?php else : ?>
    <p>No posts found in this category.</p>
  <?php endif;
else :
  echo '<p>No category selected.</p>';
endif;
?>
