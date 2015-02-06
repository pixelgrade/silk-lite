var animator = (function() {

	initialize = function() {

	},

	animate = function() {
		animateTopBar();
		setTimeout(animateLogo, 100);
		setTimeout(animateMenu, 200); 
		setTimeout(animateSlider, 300);
		setTimeout(animatePosts, 600);
		setTimeout(animateSidebar, 800);
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

	animatePosts = function() {

		var $posts = $('.archive__grid').children();

		$posts.each(function(i, obj) {
			var $post = $(obj),
				delay = i * 100;

			animatePost($post, delay);
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
	};

	return {
		animate: animate
	}

})();