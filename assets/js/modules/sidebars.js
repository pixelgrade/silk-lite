/* ====== Fixed Sidebars Logic ====== */

var fixedSidebars = (function() {

	var $smallSidebar       = $('.single-sidebar'),
		smallSidebarPinned  = false,
		smallSidebarPadding = 100,
		smallSidebarOffset;

	var $sidebar        = $('.sidebar--main'),
		$main           = $('.site-main'),
		mainHeight      = $main.outerHeight(),
		sidebarPinned   = false,
		sidebarPadding  = 60,
		sidebarBottom,
		sidebarOffset,
		sidebarHeight,

	/**
	 * initialize sidebar positioning
	 */
	init = function() {
		update();
	},

	/**
	 * update position of the two sidebars depending on scroll position
	 */
	update = function() {

		/* adjust right sidebar positioning if needed */
		if ( sidebarHeight < mainHeight ) {

			var windowBottom  = latestKnownScrollY + windowHeight,
				sidebarBottom = sidebarHeight + sidebarOffset.top + sidebarPadding,
				mainBottom    = mainHeight + sidebarOffset.top + sidebarPadding;


			if ( windowBottom > sidebarBottom && !sidebarPinned ) {
				$sidebar.css({  
					position: 'fixed',
					top:      windowHeight - sidebarHeight - sidebarPadding,
					left:     sidebarOffset.left
				});
				sidebarPinned = true;
			}

			if ( windowBottom <= sidebarBottom && sidebarPinned ) {
				$sidebar.css({
					position: '',
					top:      '',
					left:     ''
				});
				sidebarPinned = false;
			}

			if ( windowBottom <= mainBottom ) {
				$sidebar.css('top', windowHeight - sidebarHeight - sidebarPadding);
				return;
			}

			if ( windowBottom > mainBottom && windowBottom < documentHeight ) {
				$sidebar.css('top', mainBottom - sidebarPadding - sidebarHeight - latestKnownScrollY);
			}

			if ( windowBottom >= documentHeight ) {
				$sidebar.css('top', mainBottom - sidebarPadding - sidebarHeight - documentHeight + windowHeight);
			}	

		}

		/* adjust left sidebar positioning if needed */
		if ( ! $smallSidebar.length ) {
			return;
		}   

	 	if ( smallSidebarOffset.top - smallSidebarPadding < latestKnownScrollY && ! smallSidebarPinned ) {
			$smallSidebar.css({  
				position: 'fixed',
				top: smallSidebarPadding,
				left: smallSidebarOffset.left
			});
			smallSidebarPinned = true;
		}   

	 	if ( smallSidebarOffset.top - smallSidebarPadding >= latestKnownScrollY && smallSidebarPinned ) {
			$smallSidebar.css({
				position: '',
				top: '',
				left: ''
			});
			smallSidebarPinned = false;
		}

	},

	refresh = function() {
		if ( !$sidebar.length ) return;

		var positionValue 	= $sidebar.css('position'),
			topValue 		= $sidebar.css('top'),
			leftValue 		= $sidebar.css('left'),
			pinnedValue		= sidebarPinned;

		$sidebar.css({
			position: '',
			top: '',
			left: ''
		});

		sidebarPinned = false;
		sidebarOffset = $sidebar.offset();
		sidebarHeight = $sidebar.outerHeight();
		mainHeight    = $main.outerHeight();

		$sidebar.css({
			position: positionValue,
			top: topValue,
			left: leftValue
		});

		sidebarPinned = pinnedValue;

	};

	return {
		init: init,
		update: update,
		refresh: refresh
	}
			
})();