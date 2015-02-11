/* ====== Navigation Logic ====== */

var navigation = (function() {

	var $nav = $('.nav--main'),

	init = function() {
		// initialize the logic behind the main navigation
		$nav.ariaNavigation();
		$nav.clone(true)
			.removeClass('nav--main')
			.addClass('nav--toolbar')
			.appendTo('.floating-nav .flag__body');

		$('.nav--toolbar--left')
			.clone()
			.removeClass('nav--toolbar nav--toolbar--left')
			.addClass('nav--stacked nav--floating nav--floating--left')
			.appendTo('.floating-nav');

		$('.nav--toolbar--right')
			.clone()
			.removeClass('nav--toolbar nav--toolbar--right')
			.addClass('nav--stacked nav--floating nav--floating--right')
			.appendTo('.floating-nav');

		// make sure that the links in the floating-nav, that shows on scroll, are ignored by TAB
		$('.floating-nav').find('a').attr( 'tabIndex', -1 );
	},

	toggleTopBar = function() {
		var navBottom = $nav.offset().top + $nav.outerHeight();

		if (navBottom < latestKnownScrollY) {
			$('.top-bar.fixed').addClass('visible');
			$('.nav--floating').addClass('nav--floating--is-visible');
			$('.article-navigation .navigation-item').addClass('hover-state');
		} else {
			$('.top-bar.fixed').removeClass('visible');
			$('.nav--floating').removeClass('nav--floating--is-visible');
			$('.article-navigation .navigation-item').removeClass('hover-state');
		}

	};

	return {
		init: init,
		toggleTopBar: toggleTopBar
	}

})();