<?php
/**
 * The sidebar containing the footer widget area.
 *
 * @package Amelie
 */

if ( ! is_active_sidebar( 'footer-1' ) ) {
	return;
}
?>

<div id="supplementary" class="sidebar  sidebar--footer" role="complementary">
	<?php dynamic_sidebar( 'footer-1' ); ?>
</div><!-- #secondary -->