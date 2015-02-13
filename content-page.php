<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Silk
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title  page-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links"><span class="pagination-title">' . __( 'Pages:', 'silk_txtd' ),
				'after'  => '</span></div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'silk_txtd' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php if ( current_user_can('edit_post', get_the_ID() ) ) : ?>

			<span class="separator-wrapper--accent" role="presentation">
				<?php get_template_part("assets/svg/separator-simple"); ?>
			</span>

			<?php edit_post_link( __( 'Edit', 'silk_txtd' ), '<span class="edit-link">', '</span>' ); ?>

		<?php endif; ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->