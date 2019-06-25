<?php
/**
 * Custom template tags for Silk.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Silk Lite
 */

if ( ! function_exists( 'silklite_the_post_navigation' ) ) :

	/**
	 * Display navigation to next/previous post when applicable, with thumbnail images
	 *
	 */
	function silklite_the_post_navigation() {
		// Don't print empty markup if there's nowhere to navigate.
		$prev_post = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_previous_post();
		$next_post = get_next_post();

		if ( ! $next_post && ! $prev_post ) {
			return;
		} ?>

		<nav class="navigation post-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'silk-lite' ); ?></h2>
			<div class="article-navigation">
				<?php
				if ( $prev_post ) {
					$prev_thumbnail = get_the_post_thumbnail( $prev_post->ID, 'silklite-tiny-image' );

					$post_cat = wp_get_post_categories( $prev_post->ID );
					$post_cat = $post_cat[0];
					$post_category = get_category( $post_cat );

					$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
					if ( get_the_time( 'U', $prev_post->ID ) !== get_the_modified_time( 'U', $prev_post->ID ) ) {
						$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
					}

					$time_string = sprintf( $time_string,
						esc_attr( get_the_date( 'c', $prev_post->ID ) ),
						esc_html( get_the_date( '', $prev_post->ID ) )
					);

					previous_post_link('<span class="navigation-item  navigation-item--previous">%link</span>',
						sprintf('<span class="arrow"></span>
	                        <span class="navigation-item__content">
	                            <span class="navigation-item__wrapper">
                                    <span class="post-thumb">%1$s</span>
	                                <span class="post-info">
	                                    <span class="navigation-item__name">%2$s</span>
		                                <span class="post-meta">
		                                %3$s
		                                <span class="post-category">%4$s</span>
		                                </span>
		                                <h3 class="post-title">%title</h3>
	                                </span>
	                            </span>
	                        </span>', $prev_thumbnail, esc_html__( 'Previous', 'silk-lite' ), $time_string, $post_category->name  ) );
				}

				if ( $next_post ) {
					$post_cat = wp_get_post_categories( $next_post->ID );
					$post_cat = $post_cat[0];
					$post_category = get_category( $post_cat );

					$next_thumbnail = get_the_post_thumbnail( $next_post->ID, 'silklite-tiny-image' );

					$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
					if ( get_the_time( 'U', $next_post->ID ) !== get_the_modified_time( 'U', $next_post->ID ) ) {
						$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
					}

					$time_string = sprintf( $time_string,
						esc_attr( get_the_date( 'c', $next_post->ID ) ),
						esc_html( get_the_date( '', $next_post->ID ) )
					);

					next_post_link('<span class="navigation-item  navigation-item--next">%link</span>',
						sprintf('<span class="arrow"></span>
	                         <span class="navigation-item__content">
	                            <span class="navigation-item__wrapper  flexbox">
                                    <span class="post-thumb">%1$s</span>
	                                <span class="post-info">
	                                    <span class="navigation-item__name">%2$s</span>
		                                <span class="post-meta">
		                                %3$s
		                                <span class="post-category">%4$s</span>
		                                </span>
		                                <h3 class="post-title">%title</h3>
	                                </span>
	                            </span>
	                        </span>', $next_thumbnail, esc_html__( 'Next', 'silk-lite' ), $time_string, $post_category->name ) );
				} ?>

		</nav><!-- .navigation -->

		<?php
	}

endif;

if ( ! function_exists( 'silklite_the_image_navigation' ) ) :

	/**
	 * Display navigation to next/previous image attachment
	 */
	function silklite_the_image_navigation() {
		// Don't print empty markup if there's nowhere to navigate.
		$prev_image = silklite_get_adjacent_image();
		$next_image = silklite_get_adjacent_image( false );

		if ( ! $next_image && ! $prev_image ) {
			return;
		} ?>

		<nav class="navigation post-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Image navigation', 'silk-lite' ); ?></h2>
			<div class="article-navigation">
				<?php
				if ( $prev_image ) {
					$prev_thumbnail = wp_get_attachment_image( $prev_image->ID, 'silklite-tiny-image' ); ?>

					<span class="navigation-item  navigation-item--previous">
						<a href="<?php echo esc_url( get_attachment_link( $prev_image->ID ) ); ?>" rel="prev">
							<span class="arrow"></span>
		                    <span class="navigation-item__content">
		                        <span class="navigation-item__wrapper  flexbox">
		                            <span class="flexbox__item">
		                                <span class="post-thumb"><?php echo $prev_thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		                            </span>
		                            <span class="flexbox__item">
		                                <span class="navigation-item__name"><?php esc_html_e( 'Previous image', 'silk-lite' ); ?></span>
		                                <h3 class="post-title"><?php echo esc_html( get_the_title( $prev_image->ID ) ); ?></h3>
		                            </span>
		                        </span>
		                    </span>
						</a>
					</span>

				<?php }

				if ( $next_image ) {
					$next_thumbnail = wp_get_attachment_image( $next_image->ID, 'silklite-tiny-image' ); ?>

					<span class="navigation-item  navigation-item--next">
						<a href="<?php echo esc_url( get_attachment_link( $next_image->ID ) ); ?>" rel="prev">
							<span class="arrow"></span>
		                    <span class="navigation-item__content">
		                        <span class="navigation-item__wrapper  flexbox">
		                            <span class="flexbox__item">
		                                <span class="post-thumb"><?php echo $next_thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		                            </span>
		                            <span class="flexbox__item">
		                                <span class="navigation-item__name"><?php esc_html_e( 'Next image', 'silk-lite' ); ?></span>
		                                <h3 class="post-title"><?php echo esc_html( get_the_title( $next_image->ID ) ); ?></h3>
		                            </span>
		                        </span>
		                    </span>
						</a>
					</span>

				<?php } ?>

		</nav><!-- .navigation -->

	<?php
	}

endif;

if ( ! function_exists( 'silklite_get_adjacent_image' ) ) :

	/**
	 * Inspired by the core function adjacent_image_link() from wp-includes/media.php
	 *
	 * @param bool $prev Optional. Default is true to display previous link, false for next.
	 * @return mixed  Attachment object if successful. Null if global $post is not set. false if no corresponding attachment exists.
	 */
	function silklite_get_adjacent_image( $prev = true ) {
		if ( ! $post = get_post() ) {
			return null;
		}

		$attachments = get_attached_media( 'image', $post->post_parent );

		foreach ( $attachments as $k => $attachment ) {
			if ( $attachment->ID == $post->ID ) {
				break;
			}
		}

		if ( $attachments ) {
			$k = $prev ? $k - 1 : $k + 1;

			if ( isset( $attachments[ $k ] ) ) {
				return $attachments[ $k ];
			}
		}

		return false;
	}

endif;

if ( ! function_exists( 'silklite_posted_on' ) ) :

	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function silklite_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		echo '<span class="posted-on"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a></span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

endif;

if ( ! function_exists( 'silklite_get_cats_list' ) ) :

	/**
	 * Returns HTML with comma separated category links
	 */
	function silklite_get_cats_list( $post_ID = null) {

		//use the current post ID is none given
		if ( empty( $post_ID ) ) {
			$post_ID = get_the_ID();
		}

		$cats = '';
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'silk-lite' ), '', $post_ID );
		if ( $categories_list && silklite_categorized_blog() ) {
			$cats = '<span class="cat-links">' . $categories_list . '</span>';
		}

		return $cats;

	}

endif;

if ( ! function_exists( 'silklite_cats_list' ) ) :

	/**
	 * Prints HTML with comma separated category links
	 */
	function silklite_cats_list( $post_ID = null) {

		echo silklite_get_cats_list( $post_ID ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	} #function

endif;

if ( ! function_exists( 'silklite_get_posted_on_and_cats' ) ) :

	/**
	 * Returns HTML with meta information for the current post-date/time and author.
	 */
	function silklite_get_posted_on_and_cats() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		$cats = silklite_get_cats_list();

		return '<span class="posted-on">' . $time_string . '</span>' . $cats;

	} #function

endif;

if ( ! function_exists( 'silklite_posted_on_and_cats' ) ) :

	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function silklite_posted_on_and_cats() {
		echo silklite_get_posted_on_and_cats(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

endif;

if ( ! function_exists( 'silklite_entry_footer' ) ) :

	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function silklite_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' == get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'silk-lite' ) );
			if ( $categories_list && silklite_categorized_blog() ) {
				/* translators: %s: The post categories list. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %s', 'silk-lite' ) . '</span>', $categories_list );
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'silk-lite' ) );
			if ( $tags_list ) {
				/* translators: %s: The post tags list. */
				printf( '<span class="tags-links">' . esc_html__( ' and tagged with %s', 'silk-lite' ) . '</span>', $tags_list );
			}

			echo '.';
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			/* translators: %d: The number of comments.  */
			comments_popup_link( esc_html__( 'Leave a comment', 'silk-lite' ), esc_html__( '1 Comment', 'silk-lite' ), esc_html__( '%d Comments', 'silk-lite' ) );
			echo '</span>';
		}

		edit_post_link( esc_html__( 'Edit post', 'silk-lite' ), '<span class="edit-link">', '</span>' );
	} #function

endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function silklite_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'silklite_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'silklite_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so silklite_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so silklite_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in silklite_categorized_blog.
 */
function silklite_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'silklite_categories' );
}
add_action( 'edit_category', 'silklite_category_transient_flusher' );
add_action( 'save_post',     'silklite_category_transient_flusher' );

if ( ! function_exists( 'silklite_get_post_format_first_image' ) ) :

	function silklite_get_post_format_first_image() {
		global $post;

		$output = '';
		$pattern = get_shortcode_regex();

		//first search for an image with a caption shortcode
		if (   preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
		       && array_key_exists( 2, $matches )
		       && in_array( 'caption', $matches[2] ) ) {
			$key = array_search( 'caption', $matches[2] );
			if ( false !== $key ) {
				$output = do_shortcode( $matches[0][ $key ] );
			}
		} else {
			//find regular images
			preg_match( '/<img [^\>]*\ \/>/i', $post->post_content, $matches );

			if ( ! empty( $matches[0] ) ) {
				$output = $matches[0];
			}
		}

		return $output;
	} #function

endif;

if ( ! function_exists( 'silklite_get_post_format_link_url' ) ) :

	/**
	 * Returns the URL to use for the link post format.
	 *
	 * First it tries to get the first URL in the content; if not found it uses the permalink instead
	 *
	 * @return string URL
	 */
	function silklite_get_post_format_link_url() {
		$has_url = get_url_in_content( get_the_content() );

		return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}

endif;

/**
 * Handles the output of the media for audio attachment posts. This should be used within The Loop.
 *
 * @return string
 */
function silklite_audio_attachment() {
	return silklite_hybrid_media_grabber( array( 'type' => 'audio', 'split_media' => true ) );
}
/**
 * Handles the output of the media for video attachment posts. This should be used within The Loop.
 *
 * @return string
 */
function silklite_video_attachment() {
	return silklite_hybrid_media_grabber( array( 'type' => 'video', 'split_media' => true ) );
}
