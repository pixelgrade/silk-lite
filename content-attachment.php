<?php
/**
 * The template part for displaying the content in image.php.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Silk Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<div class="entry-attachment">

			<?php
			echo wp_get_attachment_image( get_the_ID(), 'large' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			if ( has_excerpt() ) { ?>
				<div class="entry-caption">
					<?php the_excerpt(); ?>
				</div><!-- .entry-caption -->
			<?php } ?>

		</div><!-- .entry-attachment -->

		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links"><span class="pagination-title">' . esc_html__( 'Pages:', 'silk-lite' ),
			'after'  => '</span></div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'silk-lite' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) ); ?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php if ( current_user_can( 'edit_post', get_the_ID() ) ) { ?>

			<span class="separator-wrapper--accent" role="presentation">
				<?php get_template_part( 'assets/svg/separator-simple' ); ?>
			</span>

			<?php edit_post_link( esc_html__( 'Edit', 'silk-lite' ), '<span class="edit-link">', '</span>' ); ?>

		<?php } ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
