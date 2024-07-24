<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fezziwig_Media_Arts
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="site-outer">
	<div class="site-wrapper">
		<div class="site-container">
			<div id="page" class="site">

				<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'fezziwig-media-arts' ); ?></a>
				<header id="masthead" class="site-header">
					<div id="masthead-inner" class="section-inner">
						<div class="site-branding">
							<div class="site-branding--titles">
								<h1 class="site-title"><a href="/"><span class="fezziwig">Fezziwig</span> <span class="media-arts">Media Arts</span></a></h1>
								<h2 class="site-subtitle-1">
									<span class="drupal-wordpress">
										<?php
										if (rand(0, 1) === 0) {
											echo 'Drupal and WordPress';
										} else {
											echo 'WordPress and Drupal';
										}
										?>
									</span>
									<span class="divider-dot">·</span>
									<span class="design-dev">
									  <?php
										if (rand(0, 1) === 0) {
											echo 'Design and Development';
										} else {
											echo 'Development and Design';
										}
										?>
									</span>
								</h2>        
							</div>
						</div><!-- .site-branding -->
					</div>
				</header><!-- #masthead -->

				<section id="nav" role="main" class="section section-nav">
					<div id="nav-inner" class="section-inner">
						<nav id="site-navigation" class="main-navigation" role="navigation">
							<ul class="menu">
								<li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-890 current_page_item menu-item-892">
									<a target="" href="/">Home</a>
								</li>
								<li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-880">
									<a target="" href="/about-me/">About Me</a>
								</li>
								<li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-835">
									<a target="" href="/category/websites/">Web Work</a>
								</li>
								<li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-835">
									<a target="" href="/category/presentations/">Presentations</a>
								</li>
								<li class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-950">
									<a target="" href="/my-rates/">My Rates</a>
								</li>
						</ul>
						</nav><!-- #site-navigation -->
					</div><!-- .section-inner -->
				</section>
