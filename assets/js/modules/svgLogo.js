window.svgLogo = (function() {

	var $logo 			= $('.site-branding .site-title'),
		$svg 			= $logo.find('svg'),
		logoOffset		= $logo.offset(),
		logoTop			= logoOffset.top,
		$nav			= $('.main-navigation'),
		navHeight		= $nav.outerHeight(),
		$logoClone		= $logo.clone().empty(),
		$svgClone		= $svg.clone(),
		$newSvg			= $svgClone,
		logoInitialized = false,

	init = function() {

		if ( ! $.support.svg ) return;

		var $header     = $('.site-header'),
			$title      = $('.site-header .site-title'),
			$span       = $title.find('span'),
			$svg        = $title.find('svg'),
			$text       = $svg.find('text'),
			$rect       = $svg.find('rect'),
			headerWidth = $header.width(),
			fontSize    = parseInt($span.css('font-size')),
			scaling     = 1,
			textWidth,
			titleHeight,
			titleWidth,
			spanWidth	= $span.width(),
			spanHeight	= $span.height();

		$span.css('white-space', 'nowrap');

		$title.css('width', '');
		$svg.removeAttr('viewBox').hide();
		$span.css({
			'font-size': '',
			'white-space': ''
		}).show();

		titleWidth = $span.width();

		if (titleWidth > headerWidth) {
			scaling = titleWidth / parseFloat(headerWidth);
			fontSize = parseInt(fontSize / scaling);
			$span.css('font-size', fontSize);
		}

		titleWidth = $title.width();
		titleHeight = $title.height();
		
		$title.width(spanWidth);
		$svg.attr('viewBox', "0 0 " + spanWidth + " " + spanHeight);
		$text.attr('font-size', fontSize);
		
		$span.hide();

		var newSvg = $svg.clone().wrap('<div>').parent().html(),
			$newSvg = $(newSvg);

		$svg.remove();
		$title.children('a').append($newSvg);
		$newSvg.show();

		logoAnimation();
	},

	logoAnimation = function() {

		if ( ! is_small ) return;

		$logoClone	= $logo.clone().empty();
		$svgClone	= $svg.clone();
		
		$svgClone.appendTo($logoClone).show();
		$svgClone.css({
			display: 'block',
			height: navHeight * 2 / 3,
			marginLeft: 'auto',
			marginRight: 'auto'
		});

		$logoClone.css({
			marginTop: navHeight / 6,
			height: navHeight * 5 / 6,
			overflow: 'hidden'
		});

		$newSvg = $($svgClone.clone().wrap('<div>').parent().html());

		$svgClone.remove();
		$logoClone.append($newSvg);
		$logoClone.appendTo($nav);
		$logoClone.width($newSvg.width());
		
		logoInitialized = true; 
	},

	updateLogoAnimation = function() {

		var newVal = 0;

		if ( latestKnownScrollY > logoTop - navHeight ) {
			if ( latestKnownScrollY - logoTop < 0 ) {
				newVal = logoTop - latestKnownScrollY;
			} else {
				newVal = 0;
			}
		} else {
			newVal = navHeight
		}

		console.log(newVal);

		$newSvg.velocity({
			translateY: newVal
		}, {
			duration: 0
		});
	};

	return {
		init: init,
		update: updateLogoAnimation
	}
})();