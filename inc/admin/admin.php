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
	require_once 'pixcare-notice/class-notice.php'; // phpcs:ignore
	SilkLite_PixelgradeCare_DownloadNotice::init();
}
add_action('after_setup_theme', 'silklite_admin_setup' );
