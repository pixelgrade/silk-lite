<?php
/**
 * The template for displaying the quote post format on archives.
 *
 * @package Silk
 */

$thumbnail_size = "silk-single-image";

if ( ! get_theme_mod( 'silk_single_column_archives', false ) ) {
	$thumbnail_size = '  silk-masonry-image';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header  entry-header--card">

		<?php if ( 'post' == get_post_type() ) : ?>

			<div class="entry-meta  entry-meta--card">
				<?php silk_posted_on_and_cats(); ?>
			</div><!-- .entry-meta -->

		<?php endif; ?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php
		//let's see if we have a featured image
		$post_thumbnail_html = '';
		if ( has_post_thumbnail() ) {
			$post_thumbnail     = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $thumbnail_size );
			if (isset($post_thumbnail[ 0 ])) {
				$post_thumbnail_html = '<div class="entry-thumbnail  quote-wrapper" style="background-image: url(' . $post_thumbnail[ 0 ] . ');" ></div>';
			}
		}

		echo $post_thumbnail_html; ?>

		<div class="content-quote">
			<div class="flexbox">
				<div class="flexbox__item">
					<?php
					/* translators: %s: Name of current post */
					$content = get_the_content( sprintf(
						__( 'Continue reading %s', 'silk_txtd' ),
						the_title( '<span class="screen-reader-text">', '</span>', false )
					) );

					//test if there is a </blockquote> tag in here
					if ( strpos($content,'</blockquote>') !== false ) {
						echo $content;
					} else {
						//we will wrap the whole content in blockquote since this is definitely intended as a quote
						echo '<blockquote>' . $content . '</blockquote>';
					} ?>
				</div>
			</div>
		</div>

		<span class="separator separator-wrapper--accent">
			<?php get_template_part("assets/svg/separator-simple"); ?>
		</span>

	</div><!-- .entry-content -->
</article><!-- #post-## -->