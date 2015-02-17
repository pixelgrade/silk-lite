<?php
/**
 * The template for displaying the link post format on archives.
 *
 * @package Silk
 */

$thumbnail_size = "silk-single-image";

if ( ! get_theme_mod( 'silk_single_column_archives', false ) ) {
	$thumbnail_size = '  silk-masonry-image';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header  entry-header--card">

		<?php if ( 'post' == get_post_type() ) : ?>

			<div class="entry-meta  entry-meta--card">
				<?php silk_posted_on_and_cats(); ?>
			</div><!-- .entry-meta -->

		<?php endif; ?>

		<?php if ( ! has_post_thumbnail() ) {
			the_title( sprintf( '<h2 class="entry-title  entry-title--card"><a href="%s" rel="bookmark">', esc_url( silk_get_post_format_link_url() ) ), '</a></h2>' );
		} ?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php if ( has_post_thumbnail() ) { ?>
			<a href="<?php silk_get_post_format_link_url(); ?>" class="entry-featured  entry-thumbnail">
				<?php the_post_thumbnail( $thumbnail_size ); ?>
				<div class="entry-image-border"></div>
			</a>
		<?php } ?>

		<span class="separator separator-wrapper--accent">
			<?php get_template_part("assets/svg/separator-simple"); ?>
		</span>

	</div><!-- .entry-content -->
</article><!-- #post-## -->