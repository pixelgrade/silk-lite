/* ====== Navigation Logic ====== */

var navigation = (function() {

	var $nav      = $('.nav--main').addClass('hover-intent'),
		$navItems = $nav.find('li'),
		navWidth  = $nav.outerWidth(),
	    navOffset = $nav.offset(),
	    navTop    = navOffset.top,
	    navBottom = navTop + $nav.outerHeight(),

	init = function() {
		/* add hover intent to main navigation links */
		$navItems.hoverIntent({
			over: showSubMenu,
			out: hideSubMenu,
			timeout: 300
		});

		$navItems.on('mouseleave', function() {
			hideSubMenu(this);
		});
	},

	showSubMenu = function() {

		var $item = $(this).addClass('hover');

		if ($item.hasClass('menu-item--mega')) {

			var $subMenu = $item.children('.sub-menu-wrapper'),
				offset,
				subMenuWidth;

			if ($subMenu.length) {

				subMenuWidth = $subMenu.outerWidth();

				// calculations for positioning the submenu
				var a = $item.index(),
					b = $nav.children().length,
					c = navWidth - subMenuWidth,
					x = (a - b/2 + 1/2) * c/b + c/2;

				$subMenu.css('left', x);
			}
		}
	},

	hideSubMenu = function() {

		var $item = $(this);

		if ($item.hasClass('menu-item--mega')) {
			$item.children('.sub-menu-wrapper').css('left', '');
		}

		$item.removeClass('hover');
	},

	toggleTopBar = function() {

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