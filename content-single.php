<?php
/**
 * The template part for displaying the content in single.php.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Silk
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-meta">
			<?php silk_posted_on(); ?>

			<?php silk_cats_list(); ?>
		</div><!-- .entry-meta -->

		<?php the_title( '<h1 class="entry-title  page-title">', '</h1>' ); ?>

		<?php if ( has_excerpt() ) : ?>
			<p class="intro  intro--paragraph">
			<?php echo get_the_excerpt(); ?>
			</p>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		
		<?php the_content(); ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links"><span class="pagination-title">' . __( 'Pages:', 'silk_txtd' ),
			'after'  => '</span></div>',
		) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<span class="separator-wrapper--accent">
			<?php get_template_part("assets/svg/separator-simple"); ?>
		</span>
		<?php silk_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->