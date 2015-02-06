/**
 * Silk Customizer JavaScript - keeps things nicer for all
 * v 1.0.0
 */

/**
 * Some AJAX powered controls
 * jQuery is available
 */
(function( $ ) {

	// Change site title and description when they are typed
	wp.customize( 'blogname', function( value ) {
		value.bind( function( text ) {
			$( '.site-title a' ).text( text );
		} );
	} );

	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( text ) {
			$( '.site-description-text' ).text( text );
		} );
	} );

})( jQuery );