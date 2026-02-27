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

				<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'fezziwigmedia-theme' ); ?></a>
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
							<?php
							wp_nav_menu(
									array(
											'theme_location' => 'primary',
											'menu_id'        => 'primary-menu',
											'container'      => false,
											'menu_class'     => 'menu',
									)
							);
							?>
						</nav><!-- #site-navigation -->
				  </div><!-- .section-inner -->
		    </section>
