<?php
/**
 * @package swell
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-meta">
			<?php swell_posted_on();

			$categories_list = get_the_category_list( __( ', ', 'swell_txtd' ) );
			if ( $categories_list && swell_categorized_blog() ) {
				printf( '<span class="cat-links">' . __( '%1$s', 'swell_txtd' ) . '</span>', $categories_list );
			}

			?>
		</div><!-- .entry-meta -->

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'swell_txtd' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php swell_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->