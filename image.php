<?php
/**
 * The template for displaying image attachments
 *
 * @package Silk
 */

get_header(); ?>

<div id="primary" class="content-area">

	<main id="main" class="site-main site-main--single" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'attachment' ); ?>

			<?php silk_the_image_navigation(); ?>

			<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			// The parent post link.
			the_post_navigation( array(
				'prev_text' => '<span class="meta-nav">' . __('Published in', 'silk_txtd') . '</span><span class="post-title">%title</span>',
				)
			); ?>

		<?php endwhile; // End the loop. ?>

	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>