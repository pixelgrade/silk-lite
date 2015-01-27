<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Amelie
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'amelie_txtd' ); ?></a>

	<?php get_template_part( 'templates/top-header-bar' ); ?>

	<header id="masthead" class="site-header" role="banner">

		<div class="site-branding">
			<?php if ( function_exists( 'jetpack_the_site_logo' ) ) {
				jetpack_the_site_logo();
			}

			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description">
					<span class="site-description-text"><?php bloginfo( 'description' ); ?></span>
				</p>
			<?php endif;
			?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle  assistive-text" aria-controls="menu-primary-menu" aria-expanded="false"><?php _e( 'Primary Menu', 'amelie_txtd' ); ?></button>
			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => '',
				'menu_class'     => 'menu nav  nav--main  js-nav--main',
				'items_wrap' => '<ul id="%1$s" class="%2$s" role="menubar" aria-hidden="false">%3$s</ul>',
				'walker'         => new Amelie_Walker_Primary_Mega_Menu()
			) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
