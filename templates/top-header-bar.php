<?php
/**
 * The template for the top header bar.
 *
 * @package Swell
 */ ?>
	<div class="top-header-bar">
		<nav id="top-header-left-navigation" class="toolbar-navigation" role="navigation">
			<h5 class="screen-reader-text"><?php _e( 'Secondary navigation', 'swell_txtd' ); ?></h5>
			<?php
			if ( ! get_theme_mod( 'swell_disable_search_in_toolbar', false ) ) { ?>
				<ul class="nav  nav--toolbar">
					<li class="nav__item--search"><a href="#"><?php _e( 'Search', 'swell_txtd' ); ?></a></li>
				</ul>
			<?php }

			wp_nav_menu(
				array(
					'theme_location' => 'top_header_left',
					'container'      => '',
					'menu_class'     => 'nav nav--toolbar',
					'depth'          => - 1, //flatten if there is any hierarchy
					'fallback_cb'    => false,
				)
			);
			?>
		</nav><!-- #top-header-left-navigation -->
		<nav id="top-header-right-navigation" class="toolbar-navigation" role="navigation">
			<h5 class="screen-reader-text"><?php _e( 'Secondary navigation', 'swell_txtd' ); ?></h5>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'top_header_right',
					'container'      => '',
					'menu_class'     => 'nav nav--toolbar',
					'depth'          => - 1, //flatten if there is any hierarchy
					'fallback_cb'    => false,
				)
			);
			?>
		</nav><!-- #top-header-right-navigation -->
	</div>
<?php
if ( ! get_theme_mod( 'swell_disable_search_in_toolbar', false ) ) { ?>
	<div class="overlay--search">
		<div class="overlay__wrapper">
			<?php get_search_form(); ?>
			<p><?php _e( 'Begin typing your search above and press return to search. Press Esc to cancel.', 'swell_txtd' ); ?></p>
		</div>
		<b class="overlay__close"></b>
	</div>
<?php } ?>