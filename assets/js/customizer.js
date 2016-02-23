/**
 * Silk Lite Customizer JavaScript - keeps things nicer for all
 * v 1.0.4
 */
(function( $, exports ) {
	$( document ).ready( function() {
		// when the customizer is ready add our actions
		wp.customize.bind( 'ready', function() {

			if ( typeof silkCustomizerObject !== "undefined" && $('.preview-notice' ).length > 0 ) {
				$( '<a class="badge-silk-pro" href="' + silkCustomizerObject.upsell_link + '">' + silkCustomizerObject.upsell_label + '</a>' ).insertAfter( '.preview-notice' );
				$( '<a class="dismiss-upgrade-notice" href="' + silkCustomizerObject.dismiss_link + '">dismiss</a>' ).insertAfter( '.badge-silk-pro' );
			}
		} );
	} );
})( jQuery, window );