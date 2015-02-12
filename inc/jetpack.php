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
	) );

	/**
	 * Add theme support for Featured Content
	 * See: http://jetpack.me/support/featured-content/
	 */
	add_theme_support( 'featured-content', array(
		'filter'     => 'silk_get_featured_posts',
		'max_posts'  => 10,
		'post_types' => array( 'post' ),
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

	if ( ! is_array( $featured_posts ) )
		return false;

	if ( $minimum > count( $featured_posts ) )
		return false;

	return true;
}

/*
 * Change the Jetpack Infinite Scroll load more button markup
 */
function silk_filter_jetpack_infinite_scroll_js_settings( $settings ) {
	//get the path to the file holding the svg
	$clepsydra_template = locate_template( "assets/svg/clepsydra.php" );
	$clepsydra = '';
	//if the file was found save it's contents into the variable
	if ( false !== $clepsydra_template ) {
		$clepsydra = file_get_contents( locate_template( "assets/svg/clepsydra.php" ) );
	}

	$settings['text'] = '<span class="handle__icon">' . $clepsydra . '</span><span class="handle__text">' . __( 'View More Articles', 'silk_txtd' ) .'</span>';

	return $settings;
}
add_filter( 'infinite_scroll_js_settings', 'silk_filter_jetpack_infinite_scroll_js_settings' ); ?>