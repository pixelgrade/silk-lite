<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Amelie
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">

		<?php get_sidebar('footer'); ?>

		<div class="footer-navigation" role="navigation">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => '',
					'menu_class'     => 'nav  nav--footer',
					'depth'          => - 1, //flatten if there is any hierarchy
					'items_wrap'         => '<nav><h5 class="screen-reader-text">'.__( 'Footer navigation', 'amelie_txtd' ).'</h5><ul id="%1$s" class="%2$s">%3$s</ul></nav>',
				)
			); ?>
		</div>
		<div class="site-info" role="contentinfo">
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'amelie_txtd' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'amelie_txtd' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'amelie_txtd' ), 'Amelie', '<a href="http://pixelgrade.com" rel="designer">PixelGrade</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
