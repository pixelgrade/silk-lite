<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Silk Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

	</div><!-- #content -->

	<?php if ( ! get_theme_mod( 'silklite_disable_search_in_toolbar', false ) ) { ?>

		<div class="overlay--search">
			<div class="overlay__wrapper">

				<?php get_search_form(); ?>

				<p><?php esc_html_e( 'Begin typing your search above and press return to search. Press Esc to cancel.', 'silk-lite' ); ?></p>

			</div>
			<button class="overlay__close"><span class="screen-reader-text"><?php esc_html_e( 'Close search', 'silk-lite' ); ?></span></button>
		</div>

	<?php } ?>

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
					'items_wrap'     => '<nav><h2 class="screen-reader-text">' . esc_html__( 'Footer navigation', 'silk-lite' ).'</h2><ul id="%1$s" class="%2$s">%3$s</ul></nav>',
				)
			); ?>
		</div>

		<div class="site-info" role="contentinfo">

			<?php
			if ( get_theme_mod( 'silklite_footer_copyright', false ) ) {
				echo wp_kses_post( get_theme_mod( 'silklite_footer_copyright', '' ) );
			} else {
				echo '&copy; ' . wp_kses_post( get_bloginfo('name') ) . ' &ndash; ';
			} ?>

			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'silk-lite' ) ); ?>"><?php
				/* translators: %s: WordPress */
				printf( esc_html__( ' Proudly powered by %s', 'silk-lite' ), 'WordPress' ); ?></a>
			<span class="sep"> - </span>
			<?php
			/* translators: %1$s: The theme name, %2$s: The theme author name. */
			printf( esc_html__( 'Theme: %1$s by %2$s.', 'silk-lite' ), 'Silk Lite', '<a href="https://pixelgrade.com/?utm_source=silk-lite-clients&utm_medium=footer&utm_campaign=silk-lite" title="' . esc_html__( 'The Pixelgrade Website', '__theme_txtd' ) . '" rel="nofollow">Pixelgrade</a>' ); ?>

		</div><!-- .site-info -->

		<div class="back-to-top-wrapper">
			<a href="#top" class="back-to-top-button"><?php get_template_part( 'assets/svg/back-to-top' ); ?></a>
		</div>

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
