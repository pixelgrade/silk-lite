/* ====== Masonry Logic ====== */

var masonry = (function() {

	var $container 		= $('.archive__grid'),
		$sidebar		= $('.sidebar--main'),
		$blocks			= $container.children().addClass('post--animated  post--loaded'),
		initialized		= false,
		containerTop,
		containerBottom,
		sidebarTop,

	init = function() {

		if ($container.length) {
			containerTop = $container.offset().top;
			containerBottom = containerTop + $container.outerHeight();
		}

		if ($sidebar.length) {
			sidebarTop = $sidebar.offset().top;
		}

		$container.masonry({
			itemSelector: '.grid__item',
			transitionDuration: 0
		});

		if (sidebarMasonry()) {
			$sidebar.masonry({
				itemSelector: '.grid__item',
				transitionDuration: 0
			});
		}

		bindEvents();
		showBlocks($blocks);
		initialized = true;
		refresh();
	},

	sidebarMasonry = function() {
		return $sidebar.length && sidebarTop >= containerBottom;
	},

	bindEvents = function() {
		$body.on('post-load', onLoad);
		$container.masonry('on', 'layoutComplete', function() { 
			setTimeout(function() {
				browserSize();
				fixedSidebars.refresh();
				fixedSidebars.update();
			}, 350);
		});
	},

	refresh = function() {

		if (!initialized) {
			return;
		}
		
		$container.masonry('layout');
		if (sidebarMasonry()) {
			$sidebar.masonry('layout');
		}
	},

	showBlocks = function($blocks) {
		if ( ! $.support.touch ) {
			$blocks.each(function(i, obj) {
				var $post = $(obj);
				animator.animatePost($post, i * 100);
			});
			// $blocks.addHoverAnimation();
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