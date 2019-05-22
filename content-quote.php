<?php
/**
 * The template for displaying the quote post format on archives.
 *
 * @package Silk Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	//let's see if we have a featured image
	$post_thumbnail_style = '';
	if ( has_post_thumbnail() ) {
		$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), silklite_get_thumbnail_size() );
		if ( isset( $post_thumbnail[0] ) ) {
			$post_thumbnail_style = 'style="background-image: url(' . esc_url( $post_thumbnail[0] ) . ');"';
		}
	}
	?>

	<div class="entry-content" <?php echo $post_thumbnail_style; ?> >

		<div class="content-quote">
			<div class="flexbox">
				<div class="flexbox__item">
					<?php
					$content = get_the_content( sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Continue reading %s', 'silk-lite' ),
						the_title( '<span class="screen-reader-text">', '</span>', false )
					) );

					//test if there is a </blockquote> tag in here
					if ( false !== strpos( $content,'</blockquote>' ) ) {
						echo wp_kses_post( $content );
					} else {
						//we will wrap the whole content in blockquote since this is definitely intended as a quote
						echo '<blockquote>' . wp_kses_post( $content ) . '</blockquote>';
					} ?>
				</div>
			</div>
		</div>

		<span class="separator separator-wrapper--accent">
			<?php get_template_part( 'assets/svg/separator-simple' ); ?>
		</span>

	</div><!-- .entry-content -->
</article><!-- #post-## -->
