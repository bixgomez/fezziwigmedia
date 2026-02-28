<?php

/**
 * Template part for displaying post teasers
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fezziwig_Media_Arts
 */
?>

<?php
$post_id = get_the_ID();
$categories = get_the_category();
$category_slug = '';

if (!empty($categories)) {
  $category_slug = $categories[0]->slug;
}

// Retrieve the external link field for the current post
$external_link = get_field('external_link', $post_id);
$the_link = get_permalink();
$the_target = '_self';
if ($external_link) {
  $the_link = $external_link['url'];
  $the_target = '_blank';
}
?>

<!-- post-teaser--layout-b.php -->
<a href="<?php echo esc_url($the_link); ?>" id="post-<?php the_ID(); ?>" target="<?php echo esc_attr($the_target); ?>" <?php post_class(array('post-teaser', 'post-teaser--layout-b', 'post-teaser--category-' . $category_slug)); ?>>

  <div class="post-teaser__image">
    <?php the_post_thumbnail('thumbnail'); ?>
  </div>

  <div class="post-teaser__content">
    <header class="entry-header post-teaser__header">
      <?php the_title('<h2 class="entry-title post-teaser__title">', '</h2>'); ?>
    </header><!-- .entry-header -->

    <div class="entry-content post-teaser__excerpt">
      <?php
      the_excerpt();
      ?>
    </div><!-- .entry-content -->
  </div>

</a><!-- #post-<?php the_ID(); ?> -->
<!-- /post-teaser--layout-b.php -->
