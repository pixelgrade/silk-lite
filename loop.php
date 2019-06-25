<?php
/**
 * The template for displaying the archives loop content.
 *
 * @package Silk Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$classes = 'archive__grid  grid'; ?>

<h1 class="screen-reader-text"><?php esc_html_e( 'Blog', 'silk-lite' ); ?></h1>
<div id="posts" class="<?php echo esc_attr( $classes ); ?>">
<?php
/* Start the Loop */
while ( have_posts() ) : the_post();

	/* Include the Post-Format-specific template for the content.
	 * If you want to override this in a child theme, then include a file
	 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
	 */
	get_template_part( 'content', get_post_format() );
endwhile;

//only display the load more button when Infinite Scroll is active
$is_infinite = class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' );
if ( true === $is_infinite ) { ?>

	<div id="infinite-handle">
		<button>
			<span class="handle__icon">
				<?php get_template_part( 'assets/svg/clepsydra' ); ?>
			</span>
			<span class="handle__text"><?php esc_html_e( 'View More Articles', 'silk-lite' ); ?></span>
		</button>
	</div>

<?php } ?>

</div><!-- .archive__grid -->

<?php
the_posts_navigation();
