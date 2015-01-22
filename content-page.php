<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package swell
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
				'before' => '<div class="page-links">' . __( 'Pages:', 'swell_txtd' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php if ( current_user_can('edit_post', get_the_ID() ) ) { ?>
		<hr/>
		<?php edit_post_link( __( 'Edit', 'swell_txtd' ), '<span class="edit-link">', '</span>' ); ?>
		<?php } ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->