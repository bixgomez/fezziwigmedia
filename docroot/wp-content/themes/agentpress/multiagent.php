<?php
/*
Template Name: Multi-Agent
*/

// Add Multi-Agent Page Widget Area, after content
add_action('genesis_after_post_content', 'multiagent_widget_after_content');
function multiagent_widget_after_content() {
	dynamic_sidebar('Multi-Agent Page');
}

// Use the Genesis page.php template
require_once(PARENT_DIR . '/page.php');
?>