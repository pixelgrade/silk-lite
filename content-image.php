<?php
/**
 * The template for displaying the image post format on archives.
 *
 * @package Silk
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header  entry-header--card">

		<?php if ( 'post' == get_post_type() ) : ?>

			<div class="entry-meta  entry-meta--card">
				<?php silk_posted_on_and_cats(); ?>
			</div><!-- .entry-meta -->

		<?php endif; ?>

		<?php the_title( sprintf( '<h2 class="entry-title  entry-title--card"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php if ( has_post_thumbnail() ) { ?>
			<a href="<?php the_permalink(); ?>" class="entry-featured  entry-thumbnail">
				<?php the_post_thumbnail( silk_get_thumbnail_size() ); ?>
				<div class="entry-image-border"></div>
			</a>
		<?php } else { // we need to search in the content for an image - maybe we find one
			$first_image = silk_get_post_format_first_image();
			if ( ! empty( $first_image ) ) : ?>
				<div class="entry-featured  entry-thumbnail">
					<?php echo $first_image; ?>
					<div class="entry-image-border"></div>
				</div>
			<?php endif;
		} ?>

		<span class="separator separator-wrapper--accent">
			<?php get_template_part( 'assets/svg/separator-simple' ); ?>
		</span>

	</div><!-- .entry-content -->
</article><!-- #post-## -->