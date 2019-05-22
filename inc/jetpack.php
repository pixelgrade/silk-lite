<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Silk Lite
 */

/**
 * Load the theme's duplicate files if Jetpack is not present
 * This way we provide a smooth transition to those that decide to use Jetpack
 * See: http://jetpack.me/
 */
function silklite_load_jetpack_compatibility() {

	//first test if Jetpack is present and activated
	// only if it is not present load the duplicated code from the theme
	if ( ! class_exists( 'Jetpack' ) ) {
		//this is not safe -- needed to prefix the functions
		require_once get_template_directory() . '/inc/jetpack/responsive-videos.php';
	}
}
add_action( 'after_setup_theme', 'silklite_load_jetpack_compatibility' );

function silklite_jetpack_setup() {
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
	 * Add theme support for Jetpack responsive videos
	 */
	add_theme_support( 'jetpack-responsive-videos' );

}
add_action( 'after_setup_theme', 'silklite_jetpack_setup' );
