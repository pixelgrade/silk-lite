<?php
/**
 * The template for displaying the audio post format on archives.
 *
 * @package Silk Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//get the media objects from the content and bring up only the first one
$media = silklite_audio_attachment();
$media = apply_filters('embed_oembed_html', $media ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header  entry-header--card">

		<?php if ( 'post' == get_post_type() ) : ?>

			<div class="entry-meta  entry-meta--card">
				<?php silklite_posted_on_and_cats(); ?>
			</div><!-- .entry-meta -->

		<?php endif; ?>

		<?php
		/* translators: %s: The post URL. */
		the_title( sprintf( '<h2 class="entry-title  entry-title--card"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php if ( ! empty( $media ) ) { ?>
			<div class="entry-media">
				<?php echo $media; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div><!-- .entry-media -->
		<?php
		}

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
		}

		wp_link_pages( array(
			'before' => '<div class="page-links"><span class="pagination-title">' . esc_html__( 'Pages:', 'silk-lite' ),
			'after'  => '</span></div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'silk-lite' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) ); ?>

		<span class="separator separator-wrapper--accent">
			<?php get_template_part( 'assets/svg/separator-simple' ); ?>
		</span>

	</div><!-- .entry-content -->
</article><!-- #post-## -->
