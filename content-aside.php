<?php
/**
 * The template for displaying the aside post format on archives.
 *
 * @package Silk Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header  entry-header--card">

		<?php if ( 'post' == get_post_type() ) { ?>

			<div class="entry-meta  entry-meta--card">
				<?php silklite_posted_on_and_cats(); ?>
			</div><!-- .entry-meta -->

		<?php } ?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content( sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Continue reading %s', 'silk-lite' ),
			the_title( '<span class="screen-reader-text">', '</span>', false )
		) ); ?>

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
		<span class="separator separator-wrapper--accent">
			<?php get_template_part( 'assets/svg/separator-simple' ); ?>
		</span>

	</div><!-- .entry-content -->
</article><!-- #post-## -->
