/* ====== Masonry Logic ====== */

var masonry = (function() {

	var $container 		= $('.site-main'),
		$sidebar		= $('.sidebar--main'),
		$blocks			= $container.children().addClass('post--animated  post--loaded'),
		initialized		= false,
		containerTop,
		sidebarTop,

	init = function() {

		if ($container.length) {
			containerTop = $container.offset().top;
		}

		if ($sidebar.length) {
			sidebarTop = $sidebar.offset().top;
		}

		$container.imagesLoaded(function() {
			$container.masonry({
				isAnimated: false,
				itemSelector: '.grid__item',
				hiddenStyle: {
					opacity: 0
				}
			});
			bindEvents();
			showBlocks($blocks);
		});

		if (sidebarMasonry()) {
			$sidebar.masonry({
				isAnimated: false,
				itemSelector: '.grid__item',
				hiddenStyle: {
					opacity: 0
				}
			});
		}

		initialized = true;
	},

	sidebarMasonry = function() {
		return $sidebar.length && sidebarTop > containerTop;
	},

	bindEvents = function() {
		$window.on('debouncedresize', refresh);
		$body.on('post-load', onLoad);
	},

	refresh = function() {

		if (!initialized) {
			init();
		}
		
		$container.masonry('layout');
		if (sidebarMasonry()) {
			$sidebar.masonry('layout');
		}
	},

	showBlocks = function($blocks) {
		if ( ! $.support.touch ) {
			$blocks.addHoverAnimation();
		}
	},

	onLoad = function() {
		var $newBlocks = $container.children().not('.post--loaded').addClass('post--loaded');
		$newBlocks.imagesLoaded(function() {
			$container.masonry('appended', $newBlocks, true).masonry('layout');
			showBlocks($newBlocks);
		});

	};

	return {
		init: init,
		refresh: refresh
	}

})();

/**
 * cardHover jQuery plugin
 *
 * we need to create a jQuery plugin so we can easily create the hover animations on the archive
 * both an window.load and on jetpack's infinite scroll 'post-load'
 */
$.fn.addHoverAnimation = function() {

	return this.each(function(i, obj) {

	    var $obj = $(obj);

	    // if we don't have have elements that need to be animated return
	    if ( ! $obj.length ) {
			return;
	    }

	    // bind the tweens we created above to mouse events accordingly, through hoverIntent to avoid flickering
	    $obj.hoverIntent({
	        over: animateHoverIn,
	        out: animateHoverOut,
	        timeout: 100,
	        interval: 50
	    });

	    function animateHoverIn() {

	    }

	    function animateHoverOut() {

	    }

	});

}