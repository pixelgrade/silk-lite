// /* ====== Search Overlay Logic ====== */
(function () {

	var isOpen = false,
		$overlay = $('.overlay--search'),
		$whoTriggered = null;

	// update overlay position (if it's open) on window.resize
	$window.on('debouncedresize', function () {

		windowWidth = $window.outerWidth();

		if (isOpen) {
			$overlay.velocity({
				translateX: -1 * windowWidth
			}, {
				duration: 200,
				easing: "easeInCubic"
			});
		}

	});

	/**
	 * dismiss overlay
	 */
	function closeOverlay() {

		if (!isOpen) {
			return;
		}

		var offset;

		if ($body.hasClass('rtl')) {
			offset = windowWidth
		} else {
			offset = -1 * windowWidth
		}

		// we don't need a timeline for this animations so we'll use a simple tween between two states
		$overlay.velocity({
			translateX: offset
		}, {
			duration: 0
		});
		$overlay.velocity({
			translateX: 0
		}, {
			duration: 300,
			easing: "easeInCubic"
		});

		// remove focus from the search field
		$overlay.find('input').blur();

		isOpen = false;

		if( $whoTriggered ) $whoTriggered.focus();
	}

	function escOverlay(e) {
		if (e.keyCode == 27) {
			closeOverlay();
		}
	}

	// create animation and run it on
	$('.js-search-trigger, [href*="#search"]').on('click touchstart', function (e) {
		// prevent default behavior and stop propagation
		e.preventDefault();
		e.stopPropagation();

		// if through some kind of sorcery the navigation drawer is already open return
		if (isOpen) {
			return;
		}

		var offset;

		$whoTriggered = $(this);

		if ($body.hasClass('rtl')) {
			offset = windowWidth
		} else {
			offset = -1 * windowWidth
		}

		// automatically focus the search field so the user can type right away
		$overlay.find('input').focus();

		$overlay.velocity({
			translateX: 0
		}, {
			duration: 0
		}).velocity({
			translateX: offset
		}, {
			duration: 300,
			easing: "easeOut",
			queue: false
		});

		$('.search-form').velocity({
			translateX: 300,
			opacity: 0
		}, {
			duration: 0
		}).velocity({
			opacity: 1
		}, {
			duration: 200,
			easing: "easeOutQuad",
			delay: 200,
			queue: false
		}).velocity({
			translateX: 0
		}, {
			duration: 400,
			easeing: [0.175, 0.885, 0.320, 1.275],
			delay: 50,
			queue: false
		});

		$('.overlay__wrapper > p').velocity({
			translateX: 200,
			opacity: 0
		}, {
			duration: 0
		}).velocity({
			opacity: 1
		}, {
			duration: 400,
			easing: "easeOutQuad",
			delay: 350,
			queue: false
		}).velocity({
			translateX: 0
		}, {
			duration: 400,
			easing: [0.175, 0.885, 0.320, 1.275],
			delay: 250,
			queue: false
		});

		// bind overlay dismissal to escape key
		$(document).on('keyup', escOverlay);

		isOpen = true;
	});

	// create function to hide the search overlay and bind it to the click event
	$('.overlay__close').on('click touchstart', function (e) {

		e.preventDefault();
		e.stopPropagation();

		closeOverlay();

		// unbind overlay dismissal from escape key
		$(document).off('keyup', escOverlay);
	});

	// Trap focus inside of search overlay
	$('.overlay--search .overlay__close').blur( function (e) {
		e.preventDefault();
		e.stopPropagation();

		if ( isOpen ) {
			$('.overlay--search .search-field').focus();
		}
	});

})();