<?php
/**
 * The home template
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Amelie
 */

get_header(); ?>

	<?php if ( amelie_has_featured_posts( ) ) : ?>

		<div class="featured-content">
		
			<?php get_template_part( 'content-featured' ); ?>
			
		</div>

	<?php endif; ?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php get_template_part( 'loop' ); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>