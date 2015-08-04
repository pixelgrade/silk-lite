<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Silk
 */

function silk_jetpack_setup() {
	/**
	 * Add theme support for Infinite Scroll
	 * See: http://jetpack.me/support/infinite-scroll/
	 */
	add_theme_support( 'infinite-scroll', array(
		'type'      => 'click', //load new posts on click please - we have widgets in bellow the posts
		'container' => 'posts', //here is where the posts are - help yourself
		'wrapper'   => false, //we don't need a wrapper because it would mess with the masonry
		'footer'    => 'page', //match footer width to this id
		'click_handle' => false, //tell Jetpack not to output the load more button, we will do that
	) );

	/**
	 * Add theme support for site logo
	 *
	 * First, it's the image size we want to use for the logo thumbnails
	 * Second, the 2 classes we want to use for the "Display Header Text" Customizer logic
	 */
	add_theme_support( 'site-logo', array(
		'size'        => 'silk-site-logo',
		'header-text' => array(
			'site-title',
			'site-description-text',
		)
	) );

	add_image_size( 'silk-site-logo', 1000, 500, false );

	/**
	 * Add theme support for Jetpack responsive videos
	 */
	add_theme_support( 'jetpack-responsive-videos' );

}

add_action( 'after_setup_theme', 'silk_jetpack_setup' );

function silk_get_featured_posts() {
	return apply_filters( 'silk_get_featured_posts', array() );
}

function silk_has_featured_posts( $minimum = 1 ) {
	if ( is_paged() ) {
		return false;
	}

	$minimum = absint( $minimum );
	$featured_posts = silk_get_featured_posts();

	if ( ! is_array( $featured_posts ) ) {
		return false;
	}

	if ( $minimum > count( $featured_posts ) ) {
		return false;
	}

	return true;
} ?>