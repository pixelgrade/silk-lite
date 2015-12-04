<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Silk Lite
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
					'items_wrap'     => '<nav><h2 class="screen-reader-text">'.__( 'Footer navigation', 'silk-lite' ).'</h2><ul id="%1$s" class="%2$s">%3$s</ul></nav>',
				)
			); ?>
		</div>

		<div class="site-info" role="contentinfo">

			<?php
			if ( get_theme_mod( 'silklite_footer_copyright', false ) ) {
				echo get_theme_mod( 'silklite_footer_copyright', '' );
			} else {
				echo '&copy; ' . get_bloginfo('name') . ' &ndash; ';
			} ?>

			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'silk-lite' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'silk-lite' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'silk-lite' ), 'Silk', '<a href="https://pixelgrade.com" title="'. __( 'The PixelGrade Website', 'silk-lite' ) .'" rel="designer">PixelGrade</a>' ); ?>

		</div><!-- .site-info -->

		<div class="back-to-top-wrapper">
			<a href="#top" class="back-to-top-button"><?php get_template_part( 'assets/svg/back-to-top' ); ?></a>
		</div>

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php if ( ! get_theme_mod( 'silklite_disable_search_in_toolbar', false ) ) : ?>

	<div class="overlay--search">
		<div class="overlay__wrapper">

			<?php get_search_form(); ?>

			<p><?php _e( 'Begin typing your search above and press return to search. Press Esc to cancel.', 'silk-lite' ); ?></p>

		</div>
		<b class="overlay__close"></b>
	</div>

<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>