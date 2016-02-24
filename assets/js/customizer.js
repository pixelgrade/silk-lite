/**
 * Silk Lite Customizer JavaScript - keeps things nicer for all
 * v 1.0.4
 */
(function( $, exports ) {
	$( document ).ready( function() {
		// when the customizer is ready add our actions
		wp.customize.bind( 'ready', function() {

			if ( typeof silkCustomizerObject !== "undefined" && $('.preview-notice' ).length > 0 ) {
				$( '<a class="badge-silk-pro" target="_blank" href="' + silkCustomizerObject.upsell_link + '">' + silkCustomizerObject.upsell_label + '</a><div class="upsell_link_details">Not interested? <a href="' + silkCustomizerObject.dismiss_link + '" class="upsell_link_dismiss">Dismiss</a></div>' ).insertAfter( '.preview-notice' );
			} else {
				$('.wp-full-overlay-sidebar-content').addClass('upsell_links_dismissed');
			}
		} );
	} );
})( jQuery, window );