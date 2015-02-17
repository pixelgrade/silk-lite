<?php
/**
 * The template used for displaying featured posts content in the home slider
 *
 * @package Silk
 */
?>

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

		<?php the_excerpt(); ?>

	</div><!-- .entry-content -->

	<div class="color-secondary" role="presentation">
		<div class="divider  wide">

			<?php get_template_part("assets/svg/separator-not-simple-svg"); ?>

		</div>

		<div class="divider  narrow">

			<?php get_template_part("assets/svg/separator-simple"); ?>

		</div>
	</div>
	
</article><!-- #post-## -->
