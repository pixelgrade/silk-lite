<?php
/**
 * The template for displaying the video post format on archives.
 *
 * @package Silk
 */

//get the media objects from the content and bring up only the first one
/* translators: %s: Name of current post */
$content = apply_filters( 'the_content', get_the_content( sprintf(
	__( 'Continue reading %s', 'silk' ),
	the_title( '<span class="screen-reader-text">', '</span>', false )
) ) );
$media   = get_media_embedded_in_content( $content );
if ( ! empty( $media ) ) {
	$content = str_replace( $media[0], '', $content );
} ?>

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

		<?php if ( ! empty( $media ) ) { ?>
			<div class="entry-media">
				<?php echo apply_filters( 'embed_oembed_html', $media[0] ); ?>
			</div><!-- .entry-media -->
		<?php
		}

		if ( $content ) {
			echo $content;

			wp_link_pages( array(
				'before' => '<div class="page-links"><span class="pagination-title">' . __( 'Pages:', 'silk' ),
				'after'  => '</span></div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'silk' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		} ?>

		<span class="separator separator-wrapper--accent">
			<?php get_template_part( 'assets/svg/separator-simple' ); ?>
		</span>

	</div><!-- .entry-content -->
</article><!-- #post-## -->