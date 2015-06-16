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
				<?php echo get_the_excerpt(); //we need to this since Jetpack filters the_excerpt - we don't want this ?>
			</p>

		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php if ( has_post_thumbnail() && get_theme_mod( 'silk_single_featured_image', false ) ) : ?>
			<div class="entry-featured  entry-thumbnail">
				<?php the_post_thumbnail( 'silk-single-image' ); ?>
			</div>
		<?php endif; ?>

		<?php the_content(); ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links"><span class="pagination-title">' . __( 'Pages:', 'silk' ),
			'after'  => '</span></div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'silk' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );
		?>

<div id="jp-post-flair"><div class="sharedaddy sd-sharing-enabled"><div class="robots-nocontent sd-block sd-social sd-social-icon-text sd-sharing"><h3 class="sd-title">Share this</h3><div class="sd-content"><ul><li class="share-facebook"><a rel="nofollow" data-shared="sharing-facebook-20" class="share-facebook sd-button share-icon" href="https://pixelgrade.com/demos/silk/beauty/the-return-of-an-iconic-timeless-piece/?share=facebook&amp;nb=1" target="_blank" title="Share on Facebook"><span>Facebook</span></a></li><li class="share-twitter"><a rel="nofollow" data-shared="sharing-twitter-20" class="share-twitter sd-button share-icon" href="https://pixelgrade.com/demos/silk/beauty/the-return-of-an-iconic-timeless-piece/?share=twitter&amp;nb=1" target="_blank" title="Click to share on Twitter"><span>Twitter</span></a></li><li class="share-pinterest"><a rel="nofollow" data-shared="sharing-pinterest-20" class="share-pinterest sd-button share-icon" href="https://pixelgrade.com/demos/silk/beauty/the-return-of-an-iconic-timeless-piece/?share=pinterest&amp;nb=1" target="_blank" title="Click to share on Pinterest"><span>Pinterest</span></a></li><li class="share-tumblr"><a rel="nofollow" data-shared="" class="share-tumblr sd-button share-icon" href="https://pixelgrade.com/demos/silk/beauty/the-return-of-an-iconic-timeless-piece/?share=tumblr&amp;nb=1" target="_blank" title="Click to share on Tumblr"><span>Tumblr</span></a></li><li><a href="#" class="sharing-anchor sd-button share-more"><span>More</span></a></li><li class="share-end"></li></ul><div class="sharing-hidden"><div class="inner" style="display: none;"><ul><li class="share-print"><a rel="nofollow" data-shared="" class="share-print sd-button share-icon" href="https://pixelgrade.com/demos/silk/beauty/the-return-of-an-iconic-timeless-piece/#print" target="_blank" title="Click to print"><span>Print</span></a></li><li class="share-email share-service-visible"><a rel="nofollow" data-shared="" class="share-email sd-button share-icon" href="https://pixelgrade.com/demos/silk/beauty/the-return-of-an-iconic-timeless-piece/?share=email&amp;nb=1" target="_blank" title="Click to email this to a friend"><span>Email</span></a></li><li class="share-end"></li><li class="share-end"></li></ul></div></div></div></div></div><div id="jp-relatedposts" class="jp-relatedposts" style="display: block;">
	<h3 class="jp-relatedposts-headline"><em>Related</em></h3>
<div class="jp-relatedposts-items jp-relatedposts-items-visual"><div class="jp-relatedposts-post jp-relatedposts-post0 jp-relatedposts-post-thumbs" data-post-id="137" data-post-format="false"><a class="jp-relatedposts-post-a" href="https://pixelgrade.com/demos/silk/fashion/bring-the-chic-over-new-york/" title="Bring The Chic Over New York

A girl should be two things: classy and fabulous. I am no longer concerned with sensation and innovation, but with the perfection of my style." rel="nofollow" data-origin="20" data-position="0"><img class="jp-relatedposts-post-img" src="https://i1.wp.com/pixelgrade.com/demos/silk/wp-content/uploads/2015/02/ktr_017386321.jpg?resize=350%2C200" width="350" alt="Bring The Chic Over New York"></a><h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a" href="https://pixelgrade.com/demos/silk/fashion/bring-the-chic-over-new-york/" title="Bring The Chic Over New York

A girl should be two things: classy and fabulous. I am no longer concerned with sensation and innovation, but with the perfection of my style." rel="nofollow" data-origin="20" data-position="0">Bring The Chic Over New York</a></h4><p class="jp-relatedposts-post-excerpt">A girl should be two things: classy and fabulous. I am no longer concerned with sensation and innovation, but with the perfection of my style.</p><p class="jp-relatedposts-post-date">April 17, 2014</p><p class="jp-relatedposts-post-context">In "Fashion"</p></div><div class="jp-relatedposts-post jp-relatedposts-post1 jp-relatedposts-post-thumbs" data-post-id="233" data-post-format="false" style="display: block;"><a class="jp-relatedposts-post-a" href="https://pixelgrade.com/demos/silk/style/inspiration-from-the-pre-fall-collection/" title="Inspiration from the Pre-Fall Collection

Pre-fall is perhaps the strangest of the fashion seasons and is definetly one of my favorite periods of the year to play around with fashion." rel="nofollow" data-origin="20" data-position="1"><img class="jp-relatedposts-post-img" src="https://i2.wp.com/pixelgrade.com/demos/silk/wp-content/uploads/2015/02/ktr_2151fff.jpg?resize=350%2C200" width="350" alt="Inspiration from the Pre-Fall Collection"></a><h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a" href="https://pixelgrade.com/demos/silk/style/inspiration-from-the-pre-fall-collection/" title="Inspiration from the Pre-Fall Collection

Pre-fall is perhaps the strangest of the fashion seasons and is definetly one of my favorite periods of the year to play around with fashion." rel="nofollow" data-origin="20" data-position="1">Inspiration from the Pre-Fall Collection</a></h4><p class="jp-relatedposts-post-excerpt">Pre-fall is perhaps the strangest of the fashion seasons and is definetly one of my favorite periods of the year to play around with fashion.</p><p class="jp-relatedposts-post-date">October 27, 2014</p><p class="jp-relatedposts-post-context">In "Fashion"</p></div><div class="jp-relatedposts-post jp-relatedposts-post2 jp-relatedposts-post-thumbs" data-post-id="81" data-post-format="false" style="display: none;"><a class="jp-relatedposts-post-a" href="https://pixelgrade.com/demos/silk/fashion/lessons-from-london-queens/" title="Lessons from London Queens

I picked the British fashion maven’s brain for my latest installment and that prompted me to consider the ten poshest life lessons I've learned from her thus far." rel="nofollow" data-origin="20" data-position="2"><img class="jp-relatedposts-post-img" src="https://i2.wp.com/pixelgrade.com/demos/silk/wp-content/uploads/2015/02/webb_ktr_0134.jpg?resize=350%2C200" width="350" alt="Lessons from London Queens"></a><h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a" href="https://pixelgrade.com/demos/silk/fashion/lessons-from-london-queens/" title="Lessons from London Queens

I picked the British fashion maven’s brain for my latest installment and that prompted me to consider the ten poshest life lessons I've learned from her thus far." rel="nofollow" data-origin="20" data-position="2">Lessons from London Queens</a></h4><p class="jp-relatedposts-post-excerpt">I picked the British fashion maven’s brain for my latest installment and that prompted me to consider the ten poshest life lessons I've learned from her thus far.</p><p class="jp-relatedposts-post-date">March 2, 2014</p><p class="jp-relatedposts-post-context">In "Fashion"</p></div></div></div></div>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<span class="separator-wrapper--accent" role="presentation">
			<?php get_template_part( 'assets/svg/separator-simple' ); ?>
		</span>

		<?php silk_entry_footer(); ?>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->