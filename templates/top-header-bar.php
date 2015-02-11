<?php
/**
 * The template for the top header bar.
 *
 * @package Silk
 */ ?>
<div class="top-bar  top-bar--fixed">
	<div class="content">
		<nav id="top-header-left-navigation" class="toolbar-navigation  left" role="navigation">
			<h5 class="screen-reader-text"><?php _e( 'Secondary left navigation', 'silk_txtd' ); ?></h5>
			<?php
			if ( ! get_theme_mod( 'silk_disable_search_in_toolbar', false ) ) { ?>
				<ul class="nav  nav--toolbar">
					<li class="menu-item  nav__item--search"><a href="#"><?php _e( 'Search', 'silk_txtd' ); ?></a></li>
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
			<h5 class="screen-reader-text"><?php _e( 'Secondary right navigation', 'silk_txtd' ); ?></h5>
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