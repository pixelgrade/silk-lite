/* ====== Fixed Sidebars Logic ====== */

var fixedSidebars = (function() {

	var $smallSidebar       = $('#jp-post-flair'),
		smallSidebarOffset,
		smallSidebarHeight,
		smallSidebarBottom,
		$sidebar        	= $('.sidebar--main'),
		sidebarHeight,
		sidebarOffset,
		sidebarBottom,

		padding 			= parseInt($('.site-header').css('marginBottom'), 10),
		adminBar   			= $('#wpadminbar').length ? 32 : 0,
		$main 				= $('.site-main'),
		mainBottom,

		initialized = false,

	/**
	 * initialize sidebar positioning
	 */
	init = function() {

		if (initialized) {
			return;
		}

		styleWidgets();
		wrapJetpackAfterContent();
		refresh();
		initialized = true;
	},

	/**
	* Wrap Jetpack's related posts and
	* Sharedaddy sharing into one div
	* to make a left sidebar on single posts
	*/
	wrapJetpackAfterContent = function() {
		// check if we are on single post and the wrap has not been done already by Jetpack
		// (it happens when the theme is activated on a wordpress.com installation)

		if ( $('#jp-post-flair').length != 0 )
			$('body').addClass('has--jetpack-sidebar');

		if( $('body').hasClass('single-post') && $('#jp-post-flair').length == 0 ) {

			var $jpSharing = $('.sharedaddy.sd-sharing-enabled');
			var $jpLikes = $('.sharedaddy.sd-like');
			var $jpRelatedPosts = $('#jp-relatedposts');

			if ( $jpSharing.length || $jpLikes.length || $jpRelatedPosts.length ) {

				$('body').addClass('has--jetpack-sidebar');

				var $jpWrapper = $('<div/>', { id: 'jp-post-flair' });
				$jpWrapper.appendTo($('.entry-content'));

				if( $jpSharing.length ) {
					$jpSharing.appendTo($jpWrapper);
				}

				if( $jpLikes.length ) {
					$jpLikes.appendTo($jpWrapper);
				}

				if( $jpRelatedPosts.length ) {
					$jpRelatedPosts.appendTo($jpWrapper);
				}
			}
		}
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

	 	$widgets.each(function(i, obj) {
	 		var $widget       	= $(obj),
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
	 			});

	 			$widget.on('mouseleave', function() {
	 				$main.css({
	 					'paddingBottom': ''
	 				})
	 				// $widget.removeClass('focused');
	 				$widget.css('max-height', newHeight);
	 			});
	 		}

			delayUpdate();

	 	});

	},

	delayUpdate = function() {
		setTimeout(function() {
			refresh();
			update();
		}, 600);
	},

	/**
	 * update position of the two sidebars depending on scroll position
	 */
	update = function() {

		if ( !initialized ) {
			init();
		}

		updateMainSidebar();
		updateSmallSidebar();

	},

	updateMainSidebar = function() {
		// if we do have a sidebar to work if
		if ( $sidebar.length ) {
			// if it is already pinned
	 		if (latestKnownScrollY <= sidebarOffset.top + sidebarHeight - windowHeight + padding) {
		 		// apply needed properties
		 		$sidebar.css({
		 			position: '',
		 			top: '',
		 			left: ''
		 		});
	 		// or if it needs to be pinned to the bottom
	 		} else if (latestKnownScrollY >= mainBottom - windowHeight + padding) {
				$sidebar.css({
		 			position: '',
		 			top: mainBottom - sidebarBottom,
		 			left: ''
		 		});
		 	// or it just needs to be sticky and move with the scroll
	 		} else {
				$sidebar.css({
					position: 'fixed',
					top: windowHeight - sidebarHeight - padding,
					left: sidebarOffset.left
				});
	 		}
		}
	},

	updateSmallSidebar = function() {
		// if we do have a sidebar to work if
		if ( $smallSidebar.length ) {
			// if it is already pinned
	 		if ( latestKnownScrollY <= smallSidebarOffset.top - padding ) {
		 		// apply needed properties
		 		$smallSidebar.css({
		 			position: '',
		 			top: '',
		 			left: ''
		 		});
	 		// or if it needs to be pinned to the bottom
	 		} else if ( latestKnownScrollY >= mainBottom - smallSidebarHeight - padding ) {
				$smallSidebar.css({
		 			position: '',
		 			top: mainBottom - smallSidebarBottom,
		 			left: ''
		 		});
		 	// or it just needs to be sticky and move with the scroll
	 		} else {
				$smallSidebar.css({
					position: 'fixed',
					top: padding,
					left: smallSidebarOffset.left
				});
	 		}
		}
	},

	refresh = function() {
		refreshMain();
		refreshMainSidebar();
		refreshSmallSidebar();
	},

	refreshMain = function() {
		mainBottom = $('#content').offset().top + $('#content').height()
	},

	refreshMainSidebar = function() {
		if ( $sidebar.length ) {

			$sidebar.css({
				position: '',
				top: '',
				left: ''
			});

			sidebarOffset = $sidebar.offset();
			sidebarHeight = $sidebar.outerHeight();
			sidebarBottom = sidebarOffset.top + sidebarHeight;

		}
	},

	refreshSmallSidebar = function() {
		if ( $smallSidebar.length ) {

			$smallSidebar.css({
				position: '',
				top: '',
				left: ''
			});

			smallSidebarOffset = $smallSidebar.offset();

			$smallSidebar.find('.sd-sharing-enabled, .sd-like, .jp-relatedposts-post').show().each(function(i, obj) {

				var $box 		= $(obj),
					boxOffset	= $box.offset(),
					boxHeight	= $box.outerHeight(),
					boxBottom	= boxOffset.top - smallSidebarOffset.top + boxHeight;

				if ( boxBottom + padding > windowHeight ) {
					$box.hide();
				} else {
					$box.show();
				}
			});

			var $relatedposts = $('.jp-relatedposts');

			if ( $relatedposts.length ) {
				$relatedposts.show();
				if ( ! $relatedposts.find('.jp-relatedposts-post:visible').length ) {
					$relatedposts.hide();
				}
			}

			smallSidebarHeight = $smallSidebar.outerHeight();
			smallSidebarBottom = smallSidebarOffset.top + smallSidebarHeight;
		}
	};

	return {
		init: init,
		update: update,
		refresh: refresh
	}

})();