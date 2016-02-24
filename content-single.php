<?php
/**
 * The template part for displaying the content in single.php.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Silk Lite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-meta">

			<?php silklite_posted_on(); ?>

			<?php silklite_cats_list(); ?>

		</div><!-- .entry-meta -->

		<?php the_title( '<h1 class="entry-title  page-title">', '</h1>' ); ?>

		<?php if ( has_excerpt() ) : ?>

			<p class="intro  intro--paragraph">
				<?php echo get_the_excerpt(); //we need to this since Jetpack filters the_excerpt - we don't want this ?>
			</p>

		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php if ( has_post_thumbnail() && get_theme_mod( 'silklite_single_featured_image', false ) ) : ?>
			<div class="entry-featured  entry-thumbnail">
				<?php
				if ( is_active_sidebar( 'sidebar-1' ) ) {
					the_post_thumbnail( 'silklite-single-image' );
				} else {
					//if no sidebar is used we need to use a bigger image size since the max width of the content is 1250px
					the_post_thumbnail( 'full' );
				} ?>
			</div>
		<?php endif; ?>

		<?php the_content(); ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links"><span class="pagination-title">' . __( 'Pages:', 'silk-lite' ),
			'after'  => '</span></div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'silk-lite' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<span class="separator-wrapper--accent" role="presentation">
			<?php get_template_part( 'assets/svg/separator-simple' ); ?>
		</span>

		<?php silklite_entry_footer(); ?>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->