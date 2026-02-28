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
// Define the slugs for categories that use each layout.
$layout_a_categories = array('websites');
$layout_b_categories = array('tutorials', 'presentations', 'demos');

// Get the current post categories.
$categories = get_the_category();
$category_slugs = array();
$primary_category_slug = '';

if (!empty($categories)) {
  foreach ($categories as $category) {
    $category_slugs[] = $category->slug;
  }
  $primary_category_slug = $categories[0]->slug;
}

// Determine the card layout for this post.
$layout = 'default';
if (array_intersect($category_slugs, $layout_a_categories)) {
  $layout = 'layout-a';
} elseif (array_intersect($category_slugs, $layout_b_categories)) {
  $layout = 'layout-b';
}

// Build link behavior (layout-b supports external links).
$post_id = get_the_ID();
$link_url = get_permalink();
$link_target = '_self';

if ('layout-b' === $layout) {
  $external_link = get_field('external_link', $post_id);
  if (!empty($external_link['url'])) {
    $link_url = $external_link['url'];
    $link_target = '_blank';
  }
}

get_template_part(
  'template-parts/post-teaser--card',
  null,
  array(
    'layout' => $layout,
    'primary_category_slug' => $primary_category_slug,
    'link_url' => $link_url,
    'link_target' => $link_target,
    'show_read_more' => ('default' === $layout),
  )
);
