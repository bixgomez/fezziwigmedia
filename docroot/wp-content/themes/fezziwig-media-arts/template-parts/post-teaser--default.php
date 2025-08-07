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
$categories = get_the_category();
$category_slug = '';

if (!empty($categories)) {
  $category_slug = $categories[0]->slug;
}
?>

<!-- post-teaser--default.php -->
<a href="<?php echo esc_url(get_permalink()); ?>" class="post-teaser post-teaser--<?php echo $category_slug; ?>">

  <div class="post-teaser-image">
    <?php the_post_thumbnail('thumbnail'); ?>
  </div>

  <div class="post-teaser-text">
    <header class="entry-header">
      <?php the_title('<h2 class="entry-title">', '</h2>'); ?>
    </header>

    <div class="entry-content">
      <?php the_excerpt(); ?>
    </div>

    <div class="read-more-link">
      READ MORE
    </div>
  </div>

</a><!-- #post-<?php the_ID(); ?> -->
<!-- /post-teaser--default.php -->