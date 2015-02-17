window.svgLogo = (function() {

	var init = function() {

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
	}

	return {
		init: init
	}
})();