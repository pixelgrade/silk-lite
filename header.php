<?php
/**
 * The header for our theme.
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Silk Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?><!DOCTYPE html>
<!--[if IE 9]> <html class="ie9 lt-ie10" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php $classes = ( ! get_theme_mod( 'silklite_single_column_archives', false ) ) ? 'archive-layout--masonry' : 'archive-layout--column'; ?>

<div id="page" class="hfeed site <?php echo esc_attr( $classes ); ?>">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'silk-lite' ); ?></a>

	<?php get_template_part( 'templates/top-header-bar' ); ?>

	<header id="masthead" class="site-header" role="banner">

		<div class="site-branding">
			<?php
			if ( function_exists( 'the_custom_logo' ) ) {
				the_custom_logo();
			} elseif ( function_exists( 'jetpack_the_site_logo' ) ) { // display the Site Logo if present
				jetpack_the_site_logo();
			} ?>

			<?php

			// on the front page and home page we use H1 for the title
			echo ( is_front_page() && is_home() ) ? '<h1 class="site-title">' : '<div class="site-title">'; ?>

			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<span><?php bloginfo( 'name' ); ?></span>
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<text x="50%" y="0.82em" stroke="#fff" text-anchor="middle" stroke-width="<?php echo esc_attr( get_theme_mod( 'silklite_site_title_outline', '3' ) ); ?>">
						<?php bloginfo( 'name' ); ?>

					</text>
				</svg>
			</a>

			<?php echo ( is_front_page() && is_home() ) ? '</h1>' : '</div>'; ?>

			<?php
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>

				<p class="site-description">
					<span class="site-description-text"><?php bloginfo( 'description' ); ?></span>
					<span class="site-description-after" role="presentation"></span>
				</p>

			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="button-toggle  js-nav-trigger" aria-controls="menu-primary-menu" aria-expanded="false">
				<span class="nav-icon icon--lines"></span>
				<span class="button-text  assistive-text"><?php esc_html_e( 'Primary Menu', 'silk-lite' ); ?></span>
			</button>
			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => '',
				'menu_class'     => 'nav  nav--main  js-nav--main',
				'menu_id'        => 'menu-primary-menu',
				'items_wrap'     => '<ul id="%1$s" class="%2$s" aria-hidden="false">%3$s</ul>',
			) ); ?>
			<a href="#search" class="button-toggle  button-toggle--search">
				<span class="button-icon"><i class="fa fa-search"></i></span>
				<span class="button-text  assistive-text"><?php esc_html_e( 'Search', 'silk-lite' ); ?></span>
			</a>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
