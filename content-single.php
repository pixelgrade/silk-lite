<?php
/**
 * The template part for displaying the content in single.php.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Amelie
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-meta">
			<?php amelie_posted_on(); ?>

			<?php amelie_cats_list(); ?>
		</div><!-- .entry-meta -->

		<?php the_title( '<h1 class="entry-title  page-title">', '</h1>' ); ?>

		<?php if ( has_excerpt() ) : ?>
			<p class="intro-paragraph">
			<?php the_excerpt(); ?>
			</p>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( has_post_thumbnail() ) { ?>
		<div class="entry-featured  entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php }
		the_content(); ?>

<!--		<div class="sharedaddy sd-sharing-enabled"><div class="robots-nocontent sd-block sd-social sd-social-icon-text sd-sharing"><h3 class="sd-title">Share this:</h3><div class="sd-content"><ul><li class="share-facebook"><a rel="nofollow" data-shared="sharing-facebook-1" class="share-facebook sd-button share-icon" href="http://pixelgrade.com/demos/amelie/?p=1&amp;share=facebook&amp;nb=1" title="Share on Facebook"><span>Facebook<span class="share-count">12</span></span></a></li><li class="share-reddit"><a rel="nofollow" data-shared="" class="share-reddit sd-button share-icon" href="http://pixelgrade.com/demos/amelie/?p=1&amp;share=reddit&amp;nb=1" title="Click to share on Reddit"><span>Reddit<span class="share-count">31</span></span></a></li><li class="share-linkedin"><a rel="nofollow" data-shared="sharing-linkedin-1" class="share-linkedin sd-button share-icon" href="http://pixelgrade.com/demos/amelie/?p=1&amp;share=linkedin&amp;nb=1" title="Click to share on LinkedIn"><span>LinkedIn</span></a></li><li class="share-twitter"><a rel="nofollow" data-shared="sharing-twitter-1" class="share-twitter sd-button share-icon" href="http://pixelgrade.com/demos/amelie/?p=1&amp;share=twitter&amp;nb=1" title="Click to share on Twitter"><span>Twitter</span></a></li><li class="share-stumbleupon"><a rel="nofollow" data-shared="" class="share-stumbleupon sd-button share-icon" href="http://pixelgrade.com/demos/amelie/?p=1&amp;share=stumbleupon&amp;nb=1" title="Click to share on StumbleUpon"><span>StumbleUpon</span></a></li><li class="share-tumblr"><a rel="nofollow" data-shared="" class="share-tumblr sd-button share-icon" href="http://pixelgrade.com/demos/amelie/?p=1&amp;share=tumblr&amp;nb=1" title="Click to share on Tumblr"><span>Tumblr</span></a></li><li><a href="#" class="sharing-anchor sd-button share-more"><span>More</span></a></li><li class="share-end"></li></ul><div class="sharing-hidden"><div class="inner" style="left: 20.984375px; top: 402.96875px; display: none;"><ul><li class="share-pinterest"><a rel="nofollow" data-shared="" class="share-pinterest sd-button share-icon" href="http://pixelgrade.com/demos/amelie/?p=1&amp;share=pinterest&amp;nb=1" title="Click to share on Pinterest"><span>Pinterest</span></a></li><li class="share-google-plus-1"><a rel="nofollow" data-shared="sharing-google-1" class="share-google-plus-1 sd-button share-icon" href="http://pixelgrade.com/demos/amelie/?p=1&amp;share=google-plus-1&amp;nb=1" title="Click to share on Google+"><span>Google</span></a></li><li class="share-end"></li><li class="share-end"></li></ul></div></div></div></div></div><div class="sharedaddy sd-block sd-like jetpack-likes-widget-wrapper jetpack-likes-widget-loaded" id="like-post-wrapper-83857624-1-54cf8d0e09db0" data-src="//widgets.wp.com/likes/#blog_id=83857624&amp;post_id=1&amp;origin=pixelgrade.com&amp;obj_id=83857624-1-54cf8d0e09db0" data-name="like-post-frame-83857624-1-54cf8d0e09db0"><h3 class="sd-title">Like this:</h3><div class="likes-widget-placeholder post-likes-widget-placeholder" style="height: 55px; display: none;"><span class="button"><span>Like</span></span> <span class="loading">Loading...</span></div><iframe class="post-likes-widget jetpack-likes-widget" name="like-post-frame-83857624-1-54cf8d0e09db0" height="55px" width="100%" frameborder="0" src="//widgets.wp.com/likes/#blog_id=83857624&amp;post_id=1&amp;origin=pixelgrade.com&amp;obj_id=83857624-1-54cf8d0e09db0"></iframe><span class="sd-text-color"></span><a class="sd-link-color"></a></div><div id="jp-relatedposts" class="jp-relatedposts" style="display: block;">-->
<!--			<h3 class="jp-relatedposts-headline"><em>Related</em></h3>-->
<!--			<div class="jp-relatedposts-items jp-relatedposts-items-visual"><div class="jp-relatedposts-post jp-relatedposts-post0 jp-relatedposts-post-thumbs" data-post-id="1161" data-post-format="video"><a class="jp-relatedposts-post-a" href="http://pixelgrade.com/demos/amelie/?p=1161" title="Post Format: Video (YouTube)-->
<!---->
<!--http://www.youtube.com/watch?v=nwe-H6l4beM The official music video of &quot;Rise Up&quot; from Eddy's Start An Uproar! EP. Learn more about WordPress Embeds." rel="nofollow" data-origin="1" data-position="0"><img class="jp-relatedposts-post-img" src="http://i0.wp.com/img.youtube.com/vi/nwe-H6l4beM/0.jpg?resize=350%2C200" width="350" alt="Post Format: Video (YouTube)"></a><h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a" href="http://pixelgrade.com/demos/amelie/?p=1161" title="Post Format: Video (YouTube)-->
<!---->
<!--http://www.youtube.com/watch?v=nwe-H6l4beM The official music video of &quot;Rise Up&quot; from Eddy's Start An Uproar! EP. Learn more about WordPress Embeds." rel="nofollow" data-origin="1" data-position="0">Post Format: Video (YouTube)</a></h4><p class="jp-relatedposts-post-excerpt">http://www.youtube.com/watch?v=nwe-H6l4beM The official music video of "Rise Up" from Eddy's Start An Uproar! EP. Learn more about WordPress Embeds.</p><p class="jp-relatedposts-post-date">June 2, 2010</p><p class="jp-relatedposts-post-context">In "Post Formats"</p></div><div class="jp-relatedposts-post jp-relatedposts-post1 jp-relatedposts-post-nothumbs" data-post-id="565" data-post-format="link"><a class="jp-relatedposts-post-a jp-relatedposts-post-aoverlay" href="http://pixelgrade.com/demos/amelie/?p=565" title="Post Format: Link-->
<!---->
<!--The WordPress Theme Review Team Website" rel="nofollow" data-origin="1" data-position="1"></a><h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a" href="http://pixelgrade.com/demos/amelie/?p=565" title="Post Format: Link-->
<!---->
<!--The WordPress Theme Review Team Website" rel="nofollow" data-origin="1" data-position="1">Post Format: Link</a></h4><p class="jp-relatedposts-post-excerpt" style="max-height: 10.4545454545455em;">The WordPress Theme Review Team Website</p><p class="jp-relatedposts-post-date">March 7, 2010</p><p class="jp-relatedposts-post-context">In "Post Formats"</p></div><div class="jp-relatedposts-post jp-relatedposts-post2 jp-relatedposts-post-nothumbs" data-post-id="1179" data-post-format="false"><a class="jp-relatedposts-post-a jp-relatedposts-post-aoverlay" href="http://pixelgrade.com/demos/amelie/?p=1179" title="Media: Twitter Embeds-->
<!---->
<!--https://twitter.com/nacin/status/319508408669708289 This post tests WordPress' Twitter Embeds feature." rel="nofollow" data-origin="1" data-position="2"></a><h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a" href="http://pixelgrade.com/demos/amelie/?p=1179" title="Media: Twitter Embeds-->
<!---->
<!--https://twitter.com/nacin/status/319508408669708289 This post tests WordPress' Twitter Embeds feature." rel="nofollow" data-origin="1" data-position="2">Media: Twitter Embeds</a></h4><p class="jp-relatedposts-post-excerpt" style="max-height: 10.4545454545455em;">https://twitter.com/nacin/status/319508408669708289 This post tests WordPress' Twitter Embeds feature.</p><p class="jp-relatedposts-post-date">March 15, 2011</p><p class="jp-relatedposts-post-context">In "Media"</p></div></div></div>-->
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links"><span class="pagination-title">' . __( 'Pages:', 'amelie_txtd' ),
				'after'  => '</span></div>',
			) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<span class="separator-wrapper--accent">
			<?php get_template_part("assets/svg/separator-simple"); ?>
		</span>
		<?php amelie_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->