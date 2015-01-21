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

		<?php if ( has_post_thumbnail() ) { ?>
			<div class="entry-featured  entry-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div>
		<?php } ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'swell_txtd' ),
				'after'  => '</div>',
			) );
		?>

<!---->
<!--		<div id="jp-post-flair" class="sharedaddy sharedaddy-dark sd-like-enabled sd-sharing-enabled"><div class="sharedaddy sd-sharing-enabled"><div class="robots-nocontent sd-block sd-social sd-social-icon-text sd-sharing"><h3 class="sd-title">Share this:</h3><div class="sd-content"><ul><li class="share-email share-service-visible"><a rel="nofollow" class="share-email sd-button share-icon" href="https://pixelgradesandbox.wordpress.com/2014/07/27/maira-kalman-portraits-in-creativity/?share=email&amp;nb=1" title="Click to email this to a friend"><span>Email</span></a></li><li class="share-print"><a rel="nofollow" class="share-print sd-button share-icon" href="https://pixelgradesandbox.wordpress.com/2014/07/27/maira-kalman-portraits-in-creativity/#print" title="Click to print"><span>Print</span></a></li><li class="share-end"></li></ul></div></div></div><div class="sharedaddy sd-block sd-like jetpack-likes-widget-wrapper jetpack-likes-widget-loaded" id="like-post-wrapper-76819505-24-54be24a3cceb7" data-src="//widgets.wp.com/likes/#blog_id=76819505&amp;post_id=24&amp;origin=pixelgradesandbox.wordpress.com&amp;obj_id=76819505-24-54be24a3cceb7" data-name="like-post-frame-76819505-24-54be24a3cceb7"><h3 class="sd-title">Like this:</h3><div class="likes-widget-placeholder post-likes-widget-placeholder" style="height: 55px; display: none;"><span class="button"><span>Like</span></span> <span class="loading">Loading...</span></div><iframe class="post-likes-widget jetpack-likes-widget" name="like-post-frame-76819505-24-54be24a3cceb7" height="55px" width="100%" frameborder="0" src="//widgets.wp.com/likes/#blog_id=76819505&amp;post_id=24&amp;origin=pixelgradesandbox.wordpress.com&amp;obj_id=76819505-24-54be24a3cceb7"></iframe><span class="sd-text-color"></span><a class="sd-link-color"></a></div>-->
<!--			<div id="jp-relatedposts" class="jp-relatedposts" style="display: block;">-->
<!--				<h3 class="jp-relatedposts-headline"><em>Related</em></h3>-->
<!--				<div class="jp-relatedposts-items jp-relatedposts-items-visual"><div class="jp-relatedposts-post jp-relatedposts-post0 jp-relatedposts-post-nothumbs" data-post-id="301" data-post-format="false"><a class="jp-relatedposts-post-a jp-relatedposts-post-aoverlay" href="https://pixelgradesandbox.wordpress.com/2014/10/23/post-with-auto-excerpt/" title="Post With Auto-Excerpt-->
<!---->
<!--Dungaree loafer relaxed skort strong eyebrows statement Cara D. center part tortoise-shell sunglasses white shirt. Powder blue playsuit cashmere la marinière Acne luxe Prada Saffiano. Ecru neutral Saint Laurent indigo tee gold collar. Denim shorts envelope clutch sneaker Céline leggings skirt. Leather Paris street style crop oxford print chambray plaited…" rel="nofollow" data-origin="24" data-position="0"></a><h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a" href="https://pixelgradesandbox.wordpress.com/2014/10/23/post-with-auto-excerpt/" title="Post With Auto-Excerpt-->
<!---->
<!--Dungaree loafer relaxed skort strong eyebrows statement Cara D. center part tortoise-shell sunglasses white shirt. Powder blue playsuit cashmere la marinière Acne luxe Prada Saffiano. Ecru neutral Saint Laurent indigo tee gold collar. Denim shorts envelope clutch sneaker Céline leggings skirt. Leather Paris street style crop oxford print chambray plaited…" rel="nofollow" data-origin="24" data-position="0">Post With Auto-Excerpt</a></h4><p class="jp-relatedposts-post-excerpt" style="max-height: 6.38888888888889em;">Dungaree loafer relaxed skort strong eyebrows statement Cara D. center part tortoise-shell sunglasses white shirt. Powder blue playsuit cashmere la marinière Acne luxe Prada Saffiano. Ecru neutral Saint Laurent indigo tee gold collar. Denim shorts envelope clutch sneaker Céline leggings skirt. Leather Paris street style crop oxford print chambray plaited…</p><p class="jp-relatedposts-post-context"></p></div><div class="jp-relatedposts-post jp-relatedposts-post1 jp-relatedposts-post-thumbs" data-post-id="29" data-post-format="false"><a class="jp-relatedposts-post-a" href="https://pixelgradesandbox.wordpress.com/2014/07/24/get-the-look-black-and-a-dose-of-attitude/" title="Get The Look: Black and a dose of attitude-->
<!---->
<!--Culpa airport first-class sed handsome, ex joy occaecat flat white. Shinkansen bespoke deserunt liveable uniforms punctual perfect Airbus A380 ryokan essential. Impeccable irure espresso minim cillum. Boutique bulletin occaecat, global ut finest cupidatat. A good adult picker can harvest over two hundred pounds of cherries and earn $8 a day,…" rel="nofollow" data-origin="24" data-position="1"><img class="jp-relatedposts-post-img" src="https://pixelgradesandbox.files.wordpress.com/2014/07/get-the-look-featured.jpg?w=350&amp;h=200&amp;crop=1" width="350" alt="Get The Look: Black and a dose of attitude"></a><h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a" href="https://pixelgradesandbox.wordpress.com/2014/07/24/get-the-look-black-and-a-dose-of-attitude/" title="Get The Look: Black and a dose of attitude-->
<!---->
<!--Culpa airport first-class sed handsome, ex joy occaecat flat white. Shinkansen bespoke deserunt liveable uniforms punctual perfect Airbus A380 ryokan essential. Impeccable irure espresso minim cillum. Boutique bulletin occaecat, global ut finest cupidatat. A good adult picker can harvest over two hundred pounds of cherries and earn $8 a day,…" rel="nofollow" data-origin="24" data-position="1">Get The Look: Black and a dose of attitude</a></h4><p class="jp-relatedposts-post-excerpt">Culpa airport first-class sed handsome, ex joy occaecat flat white. Shinkansen bespoke deserunt liveable uniforms punctual perfect Airbus A380 ryokan essential. Impeccable irure espresso minim cillum. Boutique bulletin occaecat, global ut finest cupidatat. A good adult picker can harvest over two hundred pounds of cherries and earn $8 a day,…</p><p class="jp-relatedposts-post-context">In "Lifestyle"</p></div><div class="jp-relatedposts-post jp-relatedposts-post2 jp-relatedposts-post-thumbs" data-post-id="62" data-post-format="gallery"><a class="jp-relatedposts-post-a" href="https://pixelgradesandbox.wordpress.com/2014/07/17/the-distinguished-gentleman/" title="The Distinguished Gentleman" rel="nofollow" data-origin="24" data-position="2"><img class="jp-relatedposts-post-img" src="https://pixelgradesandbox.files.wordpress.com/2014/07/3_l0042.jpg?w=350&amp;h=200&amp;crop=1" width="350" alt="The Distinguished Gentleman"></a><h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a" href="https://pixelgradesandbox.wordpress.com/2014/07/17/the-distinguished-gentleman/" title="The Distinguished Gentleman" rel="nofollow" data-origin="24" data-position="2">The Distinguished Gentleman</a></h4><p class="jp-relatedposts-post-excerpt"></p><p class="jp-relatedposts-post-context">In "Gallery"</p></div></div></div></div>-->


	</div><!-- .entry-content -->

	<hr />
	<footer class="entry-footer">
		<?php swell_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	<hr />
</article><!-- #post-## -->