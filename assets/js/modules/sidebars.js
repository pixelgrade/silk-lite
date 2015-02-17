/* ====== Fixed Sidebars Logic ====== */

var fixedSidebars = (function() {

	var $smallSidebar       = $('#jp-post-flair'),
		smallSidebarPinned  = false,
		smallSidebarPadding = 100,
		smallSidebarOffset,
		$sidebar        	= $('.sidebar--main'),
		$main           	= $('.site-main'),
		mainHeight      	= $main.outerHeight(),
		mainOffset,
		mainTop,
		mainBottom			= mainTop + mainHeight,
		sidebarPinned   	= false,
		sidebarPadding  	= 60,
		sidebarBottom,
		sidebarHeight,
		sidebarOffset,
		sidebarTop,
		sidebarBottom,

		previousTop = 0,
		animating = false,

		initialized = false,

	/**
	 * initialize sidebar positioning
	 */
	init = function() {

		if ($sidebar.length) {
			sidebarOffset 	= $sidebar.offset();
			sidebarTop 		= sidebarOffset.top;
			sidebarHeight 	= $sidebar.outerHeight();
			sidebarBottom 	= sidebarTop + sidebarHeight;
			mainTop			= $main.offset().top;

			if (mainTop >= sidebarTop) {
				styleWidgets();
			}
		}
		refresh();
		initialized = true;
	},


	/**
	 * Adding a class and some mark-up to the
	 * archive widget to make it look splendid
	 */
	styleWidgets = function() {

	 	if ($.support.touch) {
	 		return;
	 	}

	 	var $widgets 		= $sidebar.find('.widget_categories, .widget_archive, .widget_tag_cloud'),
	 		separatorMarkup = '<span class="separator  separator--text" role="presentation"><span>More</span></a>';

	 	$widgets.each(function() {

	 		var $widget       	= $(this),
		 		widgetHeight  	= $widget.outerHeight(),
	 			newHeight		= 220,
		 		heightDiffrence	= widgetHeight - newHeight,
		 		widgetWidth   	= $widget.outerWidth();

	 		if ( widgetHeight > widgetWidth ) {

	 			$widget.data('heightDiffrence', heightDiffrence);
	 			$widget.css('max-height', newHeight);

	 			$widget.addClass('shrink');
	 			$widget.append(separatorMarkup);
	 			refresh();
	 			masonry.refresh();

	 			$widget.find('a').focus(function () {
	 				$widget.removeClass('shrink').addClass('focused');
	 			});

	 			$widget.on('mouseenter', function() {

	 				$main.css({
	 					'paddingBottom': $sidebar.offset().top + sidebarHeight + heightDiffrence - mainBottom
	 				});

	 				// $widget.addClass('focused');
	 				$widget.css({
	 					'max-height': widgetHeight
	 				});

	 				setTimeout(function() {
	 					refresh();
	 					update();
	 				}, 600);
	 			});

	 			$widget.on('mouseleave', function() {
	 				$main.css({
	 					'paddingBottom': ''
	 				})
	 				// $widget.removeClass('focused');
	 				$widget.css('max-height', newHeight);

	 				setTimeout(function() {
	 					refresh();
	 					update();
	 				}, 600);
	 			});
	 		}

	 	});

	},

	/**
	 * update position of the two sidebars depending on scroll position
	 */
	update = function() {

		if ( !initialized ) {
			init();
		}

		var windowBottom  = latestKnownScrollY + windowHeight;

		sidebarBottom = sidebarHeight + sidebarOffset.top + sidebarPadding;
		mainBottom    = mainHeight + sidebarOffset.top + sidebarPadding;

		if (mainOffset.top != sidebarOffset.top || animating) {
			return;
		}

		/* adjust right sidebar positioning if needed */
		if ( sidebarHeight < mainHeight ) {

			// pin sidebar
			if ( windowBottom > sidebarBottom && !sidebarPinned ) {
				$sidebar.css({  
					position: 'fixed',
					top:      windowHeight - sidebarHeight - sidebarPadding,
					left:     sidebarOffset.left
				});
				sidebarPinned = true;
			}

			// unpin sidebar
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

		if ($main.length) {
			mainOffset = $main.offset();
		}

		if ($sidebar.length) {

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
			sidebarBottom = sidebarOffset.top + sidebarHeight;
			mainHeight    = $main.outerHeight();

			$sidebar.css({
				position: positionValue,
				top: topValue,
				left: leftValue
			});

			sidebarPinned = pinnedValue;
		}

		if ($smallSidebar.length) {
			smallSidebarPinned = false;
			smallSidebarOffset = $smallSidebar.offset();
			smallSidebarHeight = $smallSidebar.outerHeight();
		}

	};

	return {
		init: init,
		update: update,
		refresh: refresh
	}
			
})();