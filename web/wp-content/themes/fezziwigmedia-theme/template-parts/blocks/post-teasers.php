<?php
echo '<!-- post-teasers.php -->';

$category_id = get_field('post_teasers_category', $block['id']);
$show_title = get_field('show_title', $block['id']);
$show_description = get_field('show_description', $block['id']);

if ($category_id) :
  $category = get_category($category_id);
  $category_slug = $category->slug;
  $category_name = $category->name;
  $category_description = $category->description;
?>

  <?php if ($show_title) : ?>
    <h2><?php echo esc_html($category_name); ?></h2>
  <?php endif; ?>
  <?php if ($show_description) : ?>
    <p><?php echo esc_html($category_description); ?></p>
  <?php endif; ?>

  <?php
  $args = array(
    'cat' => $category_id,
    'posts_per_page' => 5,
  );
  $query = new WP_Query($args);
  if ($query->have_posts()) : ?>
    <div class="post-teaser-list-wrap">
      <ul class="post-teaser-list post-teaser-list--category-<?php echo esc_attr($category_slug); ?>">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
          <li class="post-teaser-list__item">
            <?php get_template_part('template-parts/post-teaser'); ?>
          </li>
        <?php endwhile; ?>
      </ul>
    </div>
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
