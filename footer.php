<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Silk
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">

		<?php get_sidebar( 'footer' ); ?>

		<div class="footer-navigation" role="navigation">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => '',
					'menu_class'     => 'nav  nav--footer',
					'depth'          => - 1, //flatten if there is any hierarchy
					'items_wrap'         => '<nav><h5 class="screen-reader-text">'.__( 'Footer navigation', 'silk' ).'</h5><ul id="%1$s" class="%2$s">%3$s</ul></nav>',
				)
			); ?>
		</div>

		<div class="site-info" role="contentinfo">

			<?php
			if ( get_theme_mod( 'silk_footer_copyright', false ) ) {
				echo get_theme_mod( 'silk_footer_copyright', '' );
			} else {
				echo '© '.get_bloginfo('name').' –';
			}

			printf( ' %1$s <span>'. __( 'by', 'silk' ) .'</span> %2$s',
				'<a href="https://pixelgrade.com/themes/silk/" title="'. __( 'SILK - A Fashion Magazine WordPress Theme', 'silk' ) .'" rel="theme">'. __( 'Silk Theme', 'silk' ) .'</a>',
				'<a href="https://pixelgrade.com" title="'. __( 'The PixelGrade Website', 'silk' ) .'" rel="designer">PixelGrade</a>');
			?>

		</div><!-- .site-info -->

		<div class="back-to-top-wrapper">
			<a href="#top" class="back-to-top-button"><?php get_template_part( 'assets/svg/back-to-top' ); ?></a>
		</div>

	</footer><!-- #colophon -->
</div><!-- #page -->

<div class="svg-templates  hidden">
	<?php get_template_part( 'assets/svg/slider-arrow-svg' ); ?>
</div>

<?php if ( ! get_theme_mod( 'silk_disable_search_in_toolbar', false ) ) : ?>

	<div class="overlay--search">
		<div class="overlay__wrapper">

			<?php get_search_form(); ?>

			<p><?php _e( 'Begin typing your search above and press return to search. Press Esc to cancel.', 'silk' ); ?></p>

		</div>
		<b class="overlay__close"></b>
	</div>

<?php endif; ?>

<?php get_template_part( 'templates/top-bar' ); ?>

<?php wp_footer(); ?>

</body>
</html>