<?php
/**
 * Silk Lite Theme admin logic.
 *
 * @package Silk Lite
 */

function silklite_admin_setup() {

	/**
	 * Load and initialize Pixelgrade Care notice logic.
	 */
	require_once 'pixcare-notice/class-notice.php';
	PixelgradeCare_Install_Notice::init();
}
add_action('after_setup_theme', 'silklite_admin_setup' );

function silklite_admin_assets() {
	wp_enqueue_style( 'silklite_admin_style', get_template_directory_uri() . '/inc/admin/css/admin.css', array(), '1.3.0', false );
}
add_action( 'admin_enqueue_scripts', 'silklite_admin_assets' );
