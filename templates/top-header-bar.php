<?php
/**
 * The template for the top header bar.
 *
 * @package Silk Lite
 */ ?>
<div class="top-bar  top-bar--fixed">
	<div class="content">
		<nav id="top-header-left-navigation" class="toolbar-navigation  left" role="navigation">
			<h2 class="screen-reader-text"><?php _e( 'Secondary left navigation', 'silk-lite' ); ?></h2>
			<?php
			if ( ! get_theme_mod( 'silklite_disable_search_in_toolbar', false ) ) { ?>
				<ul class="nav  nav--toolbar">
					<li class="menu-item  nav__item--search"><button class="js-search-trigger"><?php _e( 'Search', 'silk-lite' ); ?></button></li>
				</ul>
			<?php }

			wp_nav_menu(
				array(
					'theme_location' => 'top_header_left',
					'container'      => '',
					'menu_class'     => 'nav  nav--toolbar  nav--toolbar--left',
					'depth'          => -1, // flatten if there is any hierarchy
					'fallback_cb'    => false,
				)
			);
			?>
		</nav><!-- #top-header-left-navigation -->
		<nav id="top-header-right-navigation" class="toolbar-navigation  right" role="navigation">
			<h2 class="screen-reader-text"><?php _e( 'Secondary right navigation', 'silk-lite' ); ?></h2>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'top_header_right',
					'container'      => '',
					'menu_class'     => 'nav  nav--toolbar  nav--toolbar--right  right',
					'depth'          => -1, // flatten if there is any hierarchy
					'fallback_cb'    => false,
				)
			);
			?>
		</nav><!-- #top-header-right-navigation -->
	</div><!-- .content -->
</div><!-- .top-bar -->