<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Silk Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title  page-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php the_content(); ?>

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

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php if ( current_user_can( 'edit_post', get_the_ID() ) ) : ?>

			<span class="separator-wrapper--accent" role="presentation">
				<?php get_template_part( 'assets/svg/separator-simple' ); ?>
			</span>

			<?php edit_post_link( esc_html__( 'Edit', 'silk-lite' ), '<span class="edit-link">', '</span>' ); ?>

		<?php endif; ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
