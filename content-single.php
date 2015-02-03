<?php
/**
 * The template part for displaying the content in single.php.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Amelie
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-meta">
			<?php amelie_posted_on(); ?>

			<?php amelie_cats_list(); ?>
		</div><!-- .entry-meta -->

		<?php the_title( '<h1 class="entry-title  page-title">', '</h1>' ); ?>

		<?php if ( has_excerpt() ) : ?>
			<p class="intro-paragraph">
			<?php the_excerpt(); ?>
			</p>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( has_post_thumbnail() ) { ?>
		<div class="entry-featured  entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php }
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links"><span class="pagination-title">' . __( 'Pages:', 'amelie_txtd' ),
			'after'  => '</span></div>',
		) );
		?>

		<div class="single-sidebar"></div>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<span class="separator-wrapper--accent">
			<?php get_template_part("assets/svg/separator-simple"); ?>
		</span>
		<?php amelie_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->