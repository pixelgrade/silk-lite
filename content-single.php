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
			'before' => '<div class="page-links"><span class="pagination-title">' . __( 'Pages:', 'silk_txtd' ),
			'after'  => '</span></div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'silk_txtd' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );
		?>

		<div id="jp-post-flair"><div class="sharedaddy sd-sharing-enabled" style="display: none;"><div class="robots-nocontent sd-block sd-social sd-social-icon-text sd-sharing"><h3 class="sd-title">Share this</h3><div class="sd-content"><ul><li class="share-facebook"><a rel="nofollow" data-shared="sharing-facebook-101" class="share-facebook sd-button share-icon" href="http://pixelgrade.com/demos/silk/beauty/welcome-to-the-gem-palace/?share=facebook&amp;nb=1" target="_blank" title="Share on Facebook"><span>Facebook</span></a></li><li class="share-twitter"><a rel="nofollow" data-shared="sharing-twitter-101" class="share-twitter sd-button share-icon" href="http://pixelgrade.com/demos/silk/beauty/welcome-to-the-gem-palace/?share=twitter&amp;nb=1" target="_blank" title="Click to share on Twitter"><span>Twitter</span></a></li><li class="share-pinterest"><a rel="nofollow" data-shared="" class="share-pinterest sd-button share-icon" href="http://pixelgrade.com/demos/silk/beauty/welcome-to-the-gem-palace/?share=pinterest&amp;nb=1" target="_blank" title="Click to share on Pinterest"><span>Pinterest</span></a></li><li class="share-tumblr"><a rel="nofollow" data-shared="" class="share-tumblr sd-button share-icon" href="http://pixelgrade.com/demos/silk/beauty/welcome-to-the-gem-palace/?share=tumblr&amp;nb=1" target="_blank" title="Click to share on Tumblr"><span>Tumblr</span></a></li><li class="share-email share-service-visible"><a rel="nofollow" data-shared="" class="share-email sd-button share-icon" href="http://pixelgrade.com/demos/silk/beauty/welcome-to-the-gem-palace/?share=email&amp;nb=1" target="_blank" title="Click to email this to a friend"><span>Email</span></a></li><li class="share-print"><a rel="nofollow" data-shared="" class="share-print sd-button share-icon" href="http://pixelgrade.com/demos/silk/beauty/welcome-to-the-gem-palace/#print" target="_blank" title="Click to print"><span>Print</span></a></li><li class="share-end"></li></ul></div></div></div><div id="jp-relatedposts" class="jp-relatedposts" style="display: block;">
	<h3 class="jp-relatedposts-headline"><em>Related</em></h3>
<div class="jp-relatedposts-items jp-relatedposts-items-visual"><div class="jp-relatedposts-post jp-relatedposts-post0 jp-relatedposts-post-thumbs" data-post-id="62" data-post-format="false" style="display: block;"><a class="jp-relatedposts-post-a" href="http://pixelgrade.com/demos/silk/fashion/burgundy-for-paris-fashion-week/" title="Burgundy for Paris Fashion Week

Paris Fashion Week is a clothing trade show held semi-annually in Paris, France with spring/summer and autumn/winter events held each year. Dates are determined by the French Fashion Federation. Currently, Fashion Week is held in the Carrousel du Louvre, as well as at various other venues throughout the city. From…" rel="nofollow" data-origin="101" data-position="0"><img class="jp-relatedposts-post-img" src="http://i0.wp.com/pixelgrade.com/demos/silk/wp-content/uploads/2015/02/webb_ktr_0429.jpg?resize=350%2C200" width="350" alt="Burgundy for Paris Fashion Week"></a><h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a" href="http://pixelgrade.com/demos/silk/fashion/burgundy-for-paris-fashion-week/" title="Burgundy for Paris Fashion Week

Paris Fashion Week is a clothing trade show held semi-annually in Paris, France with spring/summer and autumn/winter events held each year. Dates are determined by the French Fashion Federation. Currently, Fashion Week is held in the Carrousel du Louvre, as well as at various other venues throughout the city. From…" rel="nofollow" data-origin="101" data-position="0">Burgundy for Paris Fashion Week</a></h4><p class="jp-relatedposts-post-excerpt">Paris Fashion Week is a clothing trade show held semi-annually in Paris, France with spring/summer and autumn/winter events held each year. Dates are determined by the French Fashion Federation. Currently, Fashion Week is held in the Carrousel du Louvre, as well as at various other venues throughout the city. From…</p><p class="jp-relatedposts-post-date">October 14, 2014</p><p class="jp-relatedposts-post-context">In "Fashion"</p></div><div class="jp-relatedposts-post jp-relatedposts-post1 jp-relatedposts-post-thumbs" data-post-id="227" data-post-format="false" style="display: none;"><a class="jp-relatedposts-post-a" href="http://pixelgrade.com/demos/silk/beauty/style-from-milan-fashion-week/" title="Style from Milan Fashion Week

It is the prevailing styles in behaviour and the newest creations of textile designers. Because the mtore technical term costume is regularly linked to the term." rel="nofollow" data-origin="101" data-position="1"><img class="jp-relatedposts-post-img" src="http://i2.wp.com/pixelgrade.com/demos/silk/wp-content/uploads/2015/02/webb_ktr_00302.jpg?resize=350%2C200" width="350" alt="Style from Milan Fashion Week"></a><h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a" href="http://pixelgrade.com/demos/silk/beauty/style-from-milan-fashion-week/" title="Style from Milan Fashion Week

It is the prevailing styles in behaviour and the newest creations of textile designers. Because the mtore technical term costume is regularly linked to the term." rel="nofollow" data-origin="101" data-position="1">Style from Milan Fashion Week</a></h4><p class="jp-relatedposts-post-excerpt">It is the prevailing styles in behaviour and the newest creations of textile designers. Because the mtore technical term costume is regularly linked to the term.</p><p class="jp-relatedposts-post-date">April 12, 2014</p><p class="jp-relatedposts-post-context">In "Beauty"</p></div><div class="jp-relatedposts-post jp-relatedposts-post2 jp-relatedposts-post-thumbs" data-post-id="183" data-post-format="false" style="display: none;"><a class="jp-relatedposts-post-a" href="http://pixelgrade.com/demos/silk/lifestyle/hugos-chic-new-bag-have-a-bit-of-wanderlust/" title="Hugo’s Chic New Bag Have a Bit of Wanderlust

Creativity is intelligence having fun—I saw that on Instagram today. Albert Einstein said it!" rel="nofollow" data-origin="101" data-position="2"><img class="jp-relatedposts-post-img" src="http://i2.wp.com/pixelgrade.com/demos/silk/wp-content/uploads/2015/02/webb_ktr_0468ff.jpg?resize=350%2C200" width="350" alt="Hugo’s Chic New Bag Have a Bit of Wanderlust"></a><h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a" href="http://pixelgrade.com/demos/silk/lifestyle/hugos-chic-new-bag-have-a-bit-of-wanderlust/" title="Hugo’s Chic New Bag Have a Bit of Wanderlust

Creativity is intelligence having fun—I saw that on Instagram today. Albert Einstein said it!" rel="nofollow" data-origin="101" data-position="2">Hugo’s Chic New Bag Have a Bit of Wanderlust</a></h4><p class="jp-relatedposts-post-excerpt">Creativity is intelligence having fun—I saw that on Instagram today. Albert Einstein said it!</p><p class="jp-relatedposts-post-date">April 9, 2014</p><p class="jp-relatedposts-post-context">In "Lifestyle"</p></div></div></div></div>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<span class="separator-wrapper--accent" role="presentation">
			<?php get_template_part( 'assets/svg/separator-simple' ); ?>
		</span>

		<?php silk_entry_footer(); ?>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->