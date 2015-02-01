<?php
/**
 * The template for the top header bar.
 *
 * @package Amelie
 */ ?>

<div class="top-bar  one-whole  fixed" aria-hidden="true">
	<div class="content  flag  flag--flush">

		<div class="flag__img">
			<div class="nav-trigger  relative">
				<i class="fa fa-reorder"></i>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'top_header_left',
						'container'      => '',
						'menu_class'     => 'nav  nav--toolbar  nav--dropdown',
						'depth'          => - 1, //flatten if there is any hierarchy
						'fallback_cb'    => false,
					)
				);

				?>
			</div>
			<span class="inline-block  h3"><?php bloginfo( 'name' ); ?></span>
		</div>
		<div class="flag__img  align-right">
			<?php
			if ( ! get_theme_mod( 'amelie_disable_search_in_toolbar', false ) ) { ?>
				<ul class="nav  nav--toolbar">
					<li class="nav__item--search"><a href="#"><?php _e( 'Search', 'amelie_txtd' ); ?></a></li>
				</ul>
			<?php }
			
			wp_nav_menu(
				array(
					'theme_location' => 'top_header_right',
					'container'      => '',
					'menu_class'     => 'nav  nav--toolbar',
					'depth'          => - 1, //flatten if there is any hierarchy
					'fallback_cb'    => false,
				)
			);
			?>
		</div>
	</div>
</div>