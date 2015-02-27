<?php
/**
 * The template for the top header bar.
 *
 * @package Silk
 */
?>

<?php if ( get_theme_mod( 'silk_sticky_menus', false ) ): ?>

<div class="floating-nav" aria-hidden="true"><!-- Hide all this from screen readers -->
	<div class="top-bar  one-whole  fixed">
		<div class="content">

		<div class="relative  flag  flag--flush">

			<?php if ( has_nav_menu( 'hamburger' ) ): ?>
				<div class="flag__img">
					<div class="nav-trigger  relative">
						<?php

						get_template_part( 'assets/svg/menu-icon-svg' );

						wp_nav_menu(
							array(
								'theme_location' => 'hamburger',
								'container'      => '',
								'menu_class'     => 'nav  nav--dropdown',
								'fallback_cb'    => false,
							)
						);

						?>
					</div>
				</div>
			<?php endif; ?>

			<div class="flag__img">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title" tabindex="-1"><?php bloginfo( 'name' ); ?></a>
			</div>

			<div class="flag__body  align-right"></div>

		</div>

		</div>
	</div><!-- .top-bar -->
</div>

<?php endif; ?>