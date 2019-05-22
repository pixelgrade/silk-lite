<?php
/**
 * The template for displaying the link post format on archives.
 *
 * @package Silk Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header  entry-header--card">

		<?php if ( ! has_post_thumbnail() ) {
			the_title( sprintf( '<h2 class="entry-title  entry-title--card"><a href="%s" rel="bookmark"><span class="link__text">', esc_url( silklite_get_post_format_link_url() ) ), '</span>&nbsp;<i class="link__icon  fa fa-external-link"></i></a></h2>' );
		} ?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php if ( has_post_thumbnail() ) { ?>
			<a href="<?php silklite_get_post_format_link_url(); ?>" class="entry-featured  entry-thumbnail">
				<?php the_post_thumbnail( silklite_get_thumbnail_size() ); ?>
				<div class="entry-image-border"></div>
			</a>
		<?php } ?>

		<span class="separator separator-wrapper--accent">
			<?php get_template_part( 'assets/svg/separator-simple' ); ?>
		</span>

	</div><!-- .entry-content -->
</article><!-- #post-## -->
