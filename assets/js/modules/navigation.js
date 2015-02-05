/* ====== Navigation Logic ====== */

var navigation = (function() {

	var $nav = $('.nav--main');

	init = function() {
		// initialize the logic behind the main navigation
		$nav.ariaNavigation();

		//make sure that the links in the floating-nav, that shows on scroll, are ignored by TAB
		$('.floating-nav' ).find('a' ).attr( 'tabIndex', -1 );
	},

	toggleTopBar = function() {
		var navBottom = $nav.offset().top + $nav.outerHeight();

		if (navBottom < latestKnownScrollY) {
			$('.top-bar.fixed').addClass('visible');
			$('.nav--floating').addClass('nav--floating--is-visible');
		} else {
			$('.top-bar.fixed').removeClass('visible');
			$('.nav--floating').removeClass('nav--floating--is-visible');
		}

	};

	return {
		init: init,
		toggleTopBar: toggleTopBar
	}

})();