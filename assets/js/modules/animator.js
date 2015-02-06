var animator = (function() {

	initialize = function() {

	},

	animate = function() {

		var isSingle 	= $('.site-main--single').length,
			hasSlider 	= $('.flexslider').length,
			hasSidebar	= $('.sidebar--main').length,
			delay;

		animateTopBar();
		setTimeout(animateLogo, 100);
		setTimeout(animateMenu, 200);

		if (hasSlider) {
			setTimeout(animateSlider, 300);
			setTimeout(animateMain, 600);
			delay = 600;
		} else {
			setTimeout(animateMain, 300);
			delay = 600;
		}

		if (hasSidebar) {
			setTimeout(animateSidebar, delay + 200);
			setTimeout(animateFooter, delay + 400);
			delay = delay + 400;
		} else {
			setTimeout(animateFooter, delay + 200);
			delay = delay + 200;
		}
	},

	animateTopBar = function() {
		$('.top-bar').velocity({
			opacity: 1
		}, {
			duration: 300,
			easing: "easeOutCubic"
		});
	},

	animateLogo = function() {

		var $title 			= $('.site-title'),
			$description 	= $('.site-description'),
			$descText		= $('.site-description-text'),
			$after 			= $('.site-description-after'),
			descWidth;

		$title.velocity({
			opacity: 1
		}, {
			duration: 300,
			easing: 'easeOutCubic'
		});

		if ($description.length) {
			descWidth = $descText.outerWidth();

			$('.site-description').velocity({
				color: '#000000'
			}, {
				duration: 300,
				delay: 100,
				easing: 'easeOutCubic'
			});

			$after.css({
				width: descWidth,
				opacity: 1
			});

			$after.velocity({
				width: '100%'
			}, {
				duration: 300,
				delay: 200,
				easing: 'easeOutCubic'
			});
		}
	},

	animateMenu = function() {

		$('.nav--main').velocity({
			borderTopColor: '#e6e6e6'
		}, {
			duration: 300,
			easing: 'easeOutCubic'
		});

		$('.nav--main > li').velocity({
			opacity: 1
		}, {
			duration: 300,
			delay: 100,
			easing: 'easeOutCubic'
		});
	},

	animateSlider = function() {

		var $slider 	= $('.flexslider'),
			$container	= $slider.find('.flag__body'),
			$thumbnail	= $slider.find('.flag__img img'),
			$border 	= $slider.find('.entry-thumbnail-border'),
			$meta 		= $container.find('.entry-meta'),
			$title		= $container.find('.entry-title'),
			$content	= $container.find('.entry-content'),
			$divider 	= $container.find('.separator-wrapper--accent');

		$thumbnail.add($meta).velocity({
			opacity: 1
		}, {
			duration: 300,
			easing: 'easeOutQuad'
		});

		$border.velocity({
			borderWidth: 0,
		}, {
			duration: 300,
			easing: 'easeOutQuad'
		});


		$title.velocity({
			opacity: 1
		}, {
			duration: 400,
			delay: 100,
			easing: 'easeOutCubic'
		});

		$content.add($divider).velocity({
			opacity: 1
		}, {
			duration: 400,
			delay: 200,
			easing: 'easeOutCubic'
		});
	},

	animateMain = function() {

		var $posts = $('.archive__grid').children();

		if ($posts.length) {

			$posts.each(function(i, obj) {
				var $post = $(obj),
					delay = i * 100;

				animatePost($post, delay);
			});

		} else {
			animateMainSingle();
		}
	},

	animateMainSingle = function() {

		var $main 		= $('.site-main'),
			$header 	= $main.find('.entry-header');
			$meta 		= $header.find('.entry-meta'),
			$title 		= $header.find('.entry-title')
			$excerpt	= $title.next('.intro'),
			$content	= $main.find('.entry-content, .entry-footer, .post-navigation, .comments-area');

		$meta.velocity({
			opacity: 1
		}, {
			duration: 300,
			easing: 'easeOutCubic'
		});

		$title.velocity({
			opacity: 1
		}, {
			duration: 300,
			delay: 100,
			easing: 'easeOutCubic'
		});

		$excerpt.velocity({
			opacity: 1
		}, {
			duration: 300,
			delay: 200,
			easing: 'easeOutCubic'
		});

		$content.velocity({
			opacity: 1
		}, {
			duration: 300,
			delay: 300,
			easing: 'easeOutCubic'
		});
	},

	animatePost = function($post, delay) {
		$post.velocity({
			opacity: 1
		}, {
			duration: 300,
			delay: delay,
			easing: 'easeOutCubic'
		});
	},

	animateSidebar = function() {
		$('.sidebar--main').velocity({
			opacity: 1
		}, {
			duration: 300,
			easing: 'easeOutCubic'
		});
	},

	animateFooter = function() {
		$('.site-footer').velocity({
			opacity: 1
		}, {
			duration: 300,
			easing: 'easeOutCubic'
		});
	};

	return {
		animate: animate
	}

})();