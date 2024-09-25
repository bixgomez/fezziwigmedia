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
// Define the slugs for categories that use each layout
$layout_a_categories = array('websites');  // Slug for Layout A
$layout_b_categories = array('tutorials', 'presentations', 'demos');  // Slugs for Layout B

// Get the current post categories
$categories = get_the_category();
$category_slugs = array();

// Get the slugs of the categories for the current post
foreach ($categories as $category) {
	$category_slugs[] = $category->slug;
}

// Check if the post belongs to categories using Layout A (websites)
if (array_intersect($category_slugs, $layout_a_categories)) {
    // Load Layout A
    get_template_part('template-parts/content-teaser--layout-a');
} 
// Check if the post belongs to categories using Layout B (tutorials, presentations, demos)
elseif (array_intersect($category_slugs, $layout_b_categories)) {
    // Load Layout B
    get_template_part('template-parts/content-teaser--layout-b');
} else {
    // Optionally, load a default template if needed
    get_template_part('template-parts/content-teaser--default');
}
