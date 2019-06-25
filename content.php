<?php
/**
 * The template used for displaying post content on home and archive pages
 *
 * @package Silk Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry__wrapper">

		<header class="entry-header  entry-header--card">

			<?php if ( 'post' == get_post_type() ) { ?>

				<div class="entry-meta  entry-meta--card">
					<?php silklite_posted_on_and_cats(); ?>
				</div><!-- .entry-meta -->

			<?php }

			/* translators: %s: The post URL. */
			the_title( sprintf( '<h2 class="entry-title  entry-title--card"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		</header><!-- .entry-header -->

		<div class="entry-content">

			<?php if ( has_post_thumbnail() ) { ?>
				<a href="<?php the_permalink(); ?>" class="entry-featured  entry-thumbnail" aria-hidden="true">
					<?php the_post_thumbnail( silklite_get_thumbnail_size() ); ?>
					<div class="entry-image-border"></div>
				</a>
			<?php }

			global $post;
			// Check the content for the more text
			$has_more = strpos( $post->post_content, '<!--more' );

			if ( $has_more ) {
				the_content( sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Continue reading %s', 'silk-lite' ),
					the_title( '<span class="screen-reader-text">', '</span>', false )
				) );
			} else {
				the_excerpt();
			} ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links"><span class="pagination-title">' . esc_html__( 'Pages:', 'silk-lite' ),
				'after'  => '</span></div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'silk-lite' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	<div class="color-secondary" role="presentation">
		<div class="divider  wide">
			<?php get_template_part( 'assets/svg/separator-not-simple-svg' ); ?>
		</div>
		<div class="divider  narrow">
			<?php get_template_part( 'assets/svg/separator-simple' ); ?>
		</div>
	</div>

	</div><!-- .entry-content -->
</article><!-- #post-## -->
