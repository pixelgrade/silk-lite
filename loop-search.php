<?php
/**
 * The template for displaying the search results loop content.
 *
 * @package Silk Lite
 */

$classes = 'archive__grid  grid';

if ( ! get_theme_mod( 'silklite_single_column_archives', false ) ) {
	$classes .= '  masonry';
} ?>

<div id="posts" class="<?php echo esc_attr( $classes ); ?>">

<?php
/* Start the Loop */
while ( have_posts() ) : the_post(); ?>

	<?php
	/*
	 * Run the loop for the search to output the results.
	 * If you want to overload this in a child theme then include a file
	 * called content-search.php and that will be used instead.
	 */
	get_template_part( 'content', 'search' ); ?>

<?php endwhile; ?>

</div><!-- .archive__grid -->

<?php the_posts_navigation(); ?>