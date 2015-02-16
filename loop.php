<?php
/**
 * The template for displaying the archives loop content.
 *
 * @package Silk
 */

$classes = 'archive__grid  grid';

if ( ! get_theme_mod( 'silk_single_column_archives', false ) ) {
	$classes .= '  masonry';
} else {
	$classes .= '  single-column';
}
?>
<div id="posts" class="<?php echo $classes; ?>">
<?php
/* Start the Loop */
while ( have_posts() ) : the_post(); ?>

	<?php
		/* Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
		 */
		get_template_part( 'content', get_post_format() ); ?>

<?php endwhile; ?>

<?php
//only display the load more button when Infinite Scroll is active
$is_infinite = class_exists( 'Jetpack') && Jetpack::is_module_active( 'infinite-scroll' );
if ( true === $is_infinite ) : ?>

	<div id="infinite-handle">
		<span class="handle__icon">
			<?php get_template_part("assets/svg/clepsydra"); ?>
		</span>
		<span class="handle__text"><?php _e( 'View More Articles', 'silk_txtd' ); ?></span>
	</div>

<?php endif; ?>

</div><!-- .archive__grid -->

<?php the_posts_navigation(); ?>