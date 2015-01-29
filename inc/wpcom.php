<?php
/**
 * WordPress.com-specific functions and definitions.
 *
 * @package Amelie
 * @since   Amelie 1.0
 */

/**
 * Adds support for wp.com-specific theme functions.
 *
 * @global array $themecolors
 */
function amelie_wpcom_setup() {
	global $themecolors;

	// Set theme colors for third party services.
	// hex color code without #
	if ( ! isset( $themecolors ) ) {
		$themecolors = array(
			'bg'     => '',
			'border' => '',
			'text'   => '',
			'link'   => '',
			'url'    => '',
		);
	}
}
add_action( 'after_setup_theme', 'amelie_wpcom_setup' );

/**
 * Remove sharing from blog home
 *
 */
function amelie_remove_share() {
	if ( ! is_home() ) {
		return;
	}

	remove_filter( 'post_flair', 'sharing_display', 20 );

	if ( class_exists( 'Jetpack_Likes' ) ) {
		remove_filter( 'post_flair', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
	}
}
add_action( 'loop_start', 'amelie_remove_share' );