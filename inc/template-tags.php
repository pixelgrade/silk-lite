<?php
/**
 * Custom template tags for Amelie.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Amelie
 */

if ( ! function_exists( 'the_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_posts_navigation() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation posts-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Posts navigation', 'amelie_txtd' ); ?></h2>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( 'Older posts', 'amelie_txtd' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'amelie_txtd' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'amelie_the_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function amelie_the_post_navigation() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Post navigation', 'amelie_txtd' ); ?></h2>
		<div class="article-navigation">
			<?php
			$prev_post = get_previous_post();

			if($prev_post) {
				$prev_thumbnail = get_the_post_thumbnail($prev_post->ID, array(150,150) );

				$post_cat = wp_get_post_categories($prev_post->ID);
				$post_cat = $post_cat[0];
				$post_category = get_category($post_cat);

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
                            <span class="navigation-item__wrapper  flexbox">
                            	<span class="flexbox__item">
                            		<span class="post-thumb">%s</span>
                            	</span>
                            	<span class="flexbox__item">
	                                <span class="post-meta">
	                                %s
	                                <span class="post-category">%s</span>
	                                </span>
	                                <h3 class="post-title">%%title</h3>
                            	</span>
                            </span>
                        </span>', $prev_thumbnail, $time_string, $post_category->name  ) );
			}

			$next_post = get_next_post();

			if($next_post) {
				$post_cat = wp_get_post_categories($next_post->ID);
				$post_cat = $post_cat[0];
				$post_category = get_category($post_cat);

				$next_thumbnail = get_the_post_thumbnail($next_post->ID, array(150,150) );

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
                            	<span class="flexbox__item">
                            		<span class="post-thumb">%s</span>
                            	</span>
                            	<span class="flexbox__item">
	                                <span class="post-meta">
	                                %s
	                                <span class="post-category">%s</span>
	                                </span>
	                                <h3 class="post-title">%%title</h3>
                            	</span>
                            </span>
                        </span>', $next_thumbnail, $time_string, $post_category->name ) );
			}
			?>
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'amelie_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function amelie_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$posted_on = sprintf(
		_x( '%s', 'post date', 'amelie_txtd' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span>';

}
endif;

if ( ! function_exists( 'amelie_get_cats_list' ) ) :

	/**
	 * Returns HTML with comma separated category links
	 */
	function amelie_get_cats_list( $post_ID = null) {

		//use the current post ID is none given
		if ( empty($post_ID) )
			$post_ID = get_the_ID();

		$cats = '';
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'amelie_txtd' ), '', $post_ID );
		if ( $categories_list && amelie_categorized_blog() ) {
			$cats = '<span class="cat-links">' . $categories_list . '</span>';
		}

		return $cats;

	}

endif;

if ( ! function_exists( 'amelie_cats_list' ) ) :

	/**
	 * Prints HTML with comma separated category links
	 */
	function amelie_cats_list( $post_ID = null) {

		echo amelie_get_cats_list($post_ID);

	}

endif;

if ( ! function_exists( 'amelie_get_posted_on_and_cats' ) ) :
	/**
	 * Returns HTML with meta information for the current post-date/time and author.
	 */
	function amelie_get_posted_on_and_cats() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s<sup>%3$s</sup> %4$s</time>';

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date( 'F j') ),
			esc_html( get_the_date( 'S' ) ),
			esc_html( get_the_date( 'Y' ) )
		);

		$cats = amelie_get_cats_list();

		return '<span class="posted-on">' . $time_string . '</span>' . $cats;

	}
endif;

if ( ! function_exists( 'amelie_posted_on_and_cats' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function amelie_posted_on_and_cats() {
		echo amelie_get_posted_on_and_cats();
	}
endif;

if ( ! function_exists( 'amelie_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function amelie_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'amelie_txtd' ) );
		if ( $categories_list && amelie_categorized_blog() ) {
			printf( '<span class="cat-links">' . __( 'Posted in %1$s', 'amelie_txtd' ) . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'amelie_txtd' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . __( ' and tagged with %1$s', 'amelie_txtd' ) . '</span>', $tags_list );
		}

		printf('.');
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'amelie_txtd' ), __( '1 Comment', 'amelie_txtd' ), __( '% Comments', 'amelie_txtd' ) );
		echo '</span>';
	}

	edit_post_link( __( 'Edit post', 'amelie_txtd' ), '<span class="edit-link">', '</span>' );
}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( __( 'Category: %s', 'amelie_txtd' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( __( 'Tag: %s', 'amelie_txtd' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( __( 'Author: %s', 'amelie_txtd' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( __( 'Year: %s', 'amelie_txtd' ), get_the_date( _x( 'Y', 'yearly archives date format', 'amelie_txtd' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( __( 'Month: %s', 'amelie_txtd' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'amelie_txtd' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( __( 'Day: %s', 'amelie_txtd' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'amelie_txtd' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title', 'amelie_txtd' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title', 'amelie_txtd' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title', 'amelie_txtd' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title', 'amelie_txtd' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title', 'amelie_txtd' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title', 'amelie_txtd' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title', 'amelie_txtd' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title', 'amelie_txtd' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title', 'amelie_txtd' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( __( 'Archives: %s', 'amelie_txtd' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( __( '%1$s: %2$s', 'amelie_txtd' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = __( 'Archives', 'amelie_txtd' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function amelie_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'amelie_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'amelie_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so amelie_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so amelie_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in amelie_categorized_blog.
 */
function amelie_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'amelie_categories' );
}
add_action( 'edit_category', 'amelie_category_transient_flusher' );
add_action( 'save_post',     'amelie_category_transient_flusher' ); ?>