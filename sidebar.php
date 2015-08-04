<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Silk Lite
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="sidebar  sidebar--main" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->