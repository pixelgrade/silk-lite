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
				<?php

				get_template_part('assets/svg/menu-icon-svg');

				wp_nav_menu(
					array(
						'theme_location' => 'top_header_left',
						'container'      => '',
						'menu_class'     => 'nav  nav--toolbar  nav--dropdown',
						'fallback_cb'    => false,
					)
				);

				?>
			</div>
		</div>

		<div class="flag__img">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block  h3"><?php bloginfo( 'name' ); ?></a>
		</div>
		<div class="flag__body  align-right">
			<h5 class="screen-reader-text"><?php _e( 'Secondary navigation', 'amelie_txtd' ); ?></h5>
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
					'fallback_cb'    => false,
				)
			);
			?>
		</div>
	</div>
</div>

<?php 
wp_nav_menu(
	array(
		'theme_location' => 'top_header_left',
		'container'      => '',
		'menu_class'     => 'nav  nav--stacked  nav--floating  nav--floating--left',
		'fallback_cb'    => false,
		'depth' 		 => -1
	)
);

wp_nav_menu(
	array(
		'theme_location' => 'top_header_right',
		'container'      => '',
		'menu_class'     => 'nav  nav--stacked  nav--floating  nav--floating--right',
		'fallback_cb'    => false,
		'depth' 		 => -1
	)
);
?>
