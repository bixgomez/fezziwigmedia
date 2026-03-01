<?php

/**
 * Shared card template for displaying post teasers.
 *
 * @package Fezziwig_Media_Arts
 */

$layout = isset($args['layout']) ? sanitize_html_class($args['layout']) : 'default';
$primary_category_slug = isset($args['primary_category_slug']) ? sanitize_html_class($args['primary_category_slug']) : '';
$link_url = isset($args['link_url']) ? $args['link_url'] : get_permalink();
$link_target = isset($args['link_target']) ? $args['link_target'] : '_self';
$show_read_more = !empty($args['show_read_more']);

$card_classes = array(
  'post-teaser',
  'post-teaser--' . $layout,
);

if (!empty($primary_category_slug)) {
  $card_classes[] = 'post-teaser--category-' . $primary_category_slug;
}
?>

<!-- post-teaser--card.php -->
<a href="<?php echo esc_url($link_url); ?>" id="post-<?php the_ID(); ?>" <?php if ('_blank' === $link_target) : ?>target="_blank" rel="noopener noreferrer" <?php endif; ?><?php post_class($card_classes); ?>>

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

    <?php
    $technologies = get_the_terms(get_the_ID(), 'technology');
    if ($technologies && !is_wp_error($technologies)) : ?>
      <ul class="technology-pills">
        <?php foreach ($technologies as $tech) : ?>
          <li class="technology-pill"><?php echo esc_html($tech->name); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <?php if ($show_read_more) : ?>
      <div class="post-teaser__read-more">
        READ MORE
      </div>
    <?php endif; ?>
  </div>

</a><!-- #post-<?php the_ID(); ?> -->
<!-- /post-teaser--card.php -->
