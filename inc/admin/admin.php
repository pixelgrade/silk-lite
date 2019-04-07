<?php
/**
 * Silk Lite Theme admin logic.
 *
 * @package Silk Lite
 */

function silk_lite_admin_setup() {

	/**
	 * Load and initialize Pixelgrade Care notice logic.
	 */
	require_once 'pixcare-notice/class-notice.php';
	PixelgradeCare_Install_Notice::init();
}
add_action('after_setup_theme', 'silk_lite_admin_setup' );
