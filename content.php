<?php
/**
 * The template used for displaying post content on home and archive pages
 *
 * @package Amelie
 */

$thumbnail_size = "amelie-single-image";

if ( ! get_theme_mod( 'amelie_single_column_archives', false ) ) {
	$thumbnail_size = '  amelie-masonry-image';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class("card"); ?>>

	<header class="entry-header  entry-header--card">
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta  entry-meta--card">
			<?php amelie_posted_on_and_cats(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

		<?php the_title( sprintf( '<h2 class="entry-title  entry-title--card"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="entry-featured  entry-thumbnail">
				<?php the_post_thumbnail( $thumbnail_size ); ?>
			</div>
		<?php }

		/* translators: %s: Name of current post */
		the_content( sprintf(
			__( 'Continue reading %s', 'amelie_txtd' ),
			the_title( '<span class="screen-reader-text">', '</span>', false )
		) ); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'amelie_txtd' ),
				'after'  => '</div>',
			) );
		?>
		<span class="separator-wrapper--accent">
			<?php get_template_part("assets/svg/separator-simple"); ?>
		</span>
	</div><!-- .entry-content -->
</article><!-- #post-## -->