<?php
/**
 * The template for the home featured posts slider area.
 *
 * @package Silk
 */

$featured = silk_get_featured_posts();

if ( empty( $featured ) )
	return;
?>

<div id="featured-content" class="flexslider">
	<ul class="featured-posts slides" id="featured-slides">

	<?php foreach ( $featured as $post ) : setup_postdata( $post ); ?>

		<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="flag">

				<div class="flag__img  one-half">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<span class="entry-thumbnail">

							<?php if ( has_post_thumbnail() ) : ?>

								<?php the_post_thumbnail( 'silk-slider-image' ); ?>

								<span class="entry-thumbnail-border"></span>

							<?php endif; ?>

						</span>
					</a>
				</div><!-- .flag__img.one-half -->

				<div class="flag__body  one-half">

					<?php get_template_part("content-slide"); ?>

				</div><!-- .flag__body.one-half -->

			</div><!-- .flag -->

		</li><!-- #post-## -->

	<?php
		endforeach;
		wp_reset_postdata(); ?>

	</ul>
</div>