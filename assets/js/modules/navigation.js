/* ====== Navigation Logic ====== */

var navigation = (function() {

	var $nav = $('ul.nav--main'),

	init = function() {
		// initialize the logic behind the main navigation

		// When there is no main menu selected, a default menu drops in
		// the actual menu ( <ul/> ) is inside a wrapper div.nav.nav--main
		if (!$nav.length) {
			$nav = $('div.nav.nav--main > ul').addClass('nav  nav--main  js-nav--main  is--visible');
			$('div.nav.nav--main').removeClass();
		}

		$nav.ariaNavigation();

		mobileNav();
	},

	mobileNav = function () {
		var $nav = $('ul.nav--main'),
			$navTrigger = $('.js-nav-trigger'),
			navWidth = $nav.outerWidth(),
			isOpen = false;

		/**
		 * bind toggling the navigation drawer to click and touchstart
		 *in order to get rid of the 300ms delay on touch devices we use the touchstart event
		 */
		var triggerEvents = 'click touchstart';
		if (android_ancient) triggerEvents = 'click';
		$navTrigger.on(triggerEvents, function (e) {
			// but we still have to prevent the default behavior of the touchstart event
			// because this way we're making sure the click event won't fire anymore
			e.preventDefault();
			e.stopPropagation();

			isOpen = !isOpen;
			$('body').toggleClass('nav--is-open');

			var offset;

			navWidth = $nav.outerWidth();

			if ($('body').hasClass('rtl')) {
				offset = -1 * navWidth;
			} else {
				offset = navWidth;
			}

			if(!android_ancient) {
				if (!isOpen) {

					$([$nav, $navTrigger]).each(function (i, obj) {
						$(obj).velocity({
							translateX: 0,
							translateZ: 0.01
						}, {
							duration: 300,
							easing: "easeInQuart",
							complete: function() {
								// This helps with accessibility. Elements with display: none
								// won't receive focus. (the menu is hidden on small screens)
								$nav.css('display', 'none');
							}
						});
					});

				} else {

					$([$nav, $navTrigger]).each(function (i, obj) {
						$(obj).velocity({
							translateX: offset,
							translateZ: 0.01
						}, {
							easing: "easeOutCubic",
							duration: 300,
							begin: function() {
								$nav.css('display', 'block');
							}
						});
					});

				}
				$nav.toggleClass('shadow', isOpen);
			}
		});

		// clone and append secondary menus
		$('<li/>', {
			class: "nav--toolbar--left_wrapper"
		}).appendTo('.js-nav--main');

		$('<li/>', {
			class: "nav--toolbar--right_wrapper"
		}).appendTo('.js-nav--main');

		$('<li/>', {
			class: "nav-dropdown_wrapper"
		}).appendTo('.js-nav--main');

		$('.nav--toolbar--left_wrapper').append($('.nav--toolbar--left').clone());
		$('.nav--toolbar--right_wrapper').append($('.nav--toolbar--right').clone());

		$('.nav-dropdown_wrapper').append($('.nav--dropdown').clone());

	},

	handleTopBar = function() {
		if( $('body').hasClass('admin-bar') && is_small ) {
			var offset = $('#wpadminbar').height();

			$(window).scroll(function() {
				if ($(this).scrollTop() > offset) {
					$('.main-navigation').addClass('fixed');
				} else {
					$('.main-navigation').removeClass('fixed');
				}
			});
		}
	};

	return {
		init: init,
		handleTopBar: handleTopBar
	}

})();