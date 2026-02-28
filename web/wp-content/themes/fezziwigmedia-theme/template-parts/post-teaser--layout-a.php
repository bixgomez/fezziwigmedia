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

<!-- post-teaser--layout-a.php -->
<a href="<?php echo esc_url(get_permalink()); ?>" id="post-<?php the_ID(); ?>" <?php post_class(array('post-teaser', 'post-teaser--layout-a', 'post-teaser--category-' . $category_slug)); ?>>

  <div class="post-teaser__image">
    <?php the_post_thumbnail('thumbnail'); ?>
  </div>

  <div class="post-teaser__content">
    <header class="entry-header post-teaser__header">
      <?php the_title('<h2 class="entry-title post-teaser__title">', '</h2>'); ?>
    </header><!-- .entry-header -->

    <div class="entry-content post-teaser__excerpt">
      <?php the_excerpt(); ?>
    </div><!-- .entry-content -->
  </div>

</a><!-- #post-<?php the_ID(); ?> -->
<!-- /post-teaser--layout-a.php -->
