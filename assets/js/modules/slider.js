/* ====== Slider Logic ====== */

var slider = (function () {

    var $target = $('.flexslider').hide(),

    init = function() {

        $('.js-slider-clone').remove();

        if (!useSlider()) {
            initFallback();
            return;
        }

        if ($.flexslider !== undefined && $target.length) {

            var $clone = $target.clone().addClass('js-slider-clone').show().insertBefore($target);

            $clone.flexslider({
                animation: "fade",
                slideshow: false, //no autostart slideshow for accessibility purposes
                controlNav: false,
                prevText: '<span class="screen-reader-text">' + silkFeaturedSlider.prevText + '</span>',
                nextText: '<span class="screen-reader-text">' + silkFeaturedSlider.nextText + '</span>',
                start: function() {
                    var $arrow = $('.svg-templates .slider-arrow');
                    $arrow.clone().appendTo('.flex-direction-nav .flex-prev');
                    $arrow.clone().appendTo('.flex-direction-nav .flex-next');
                }
            });
        }
    },

    initFallback = function() {

        var $myTarget = $target.clone();

        $myTarget.wrap('<div class="featured-content">').parent().insertAfter('#masthead').addClass('featured-content--scroll js-slider-clone');
        $myTarget.show();

        var $slides     = $myTarget.find('.slides'),
            slidesWidth = $slides.width(),
            slideWidth  = $slides.children().first().width(),
            marginLeft  = parseInt($target.css('margin-left'), 10),
            padding     = marginLeft + (slidesWidth - slideWidth) / 2;

        $slides.css({
            paddingLeft: padding
        });

        $slides.append('<li style="width:' + padding + 'px">');
    },

    useSlider = function() {
        return !($.support.touch && windowWidth < 800);
        // return !(windowWidth < 800);
        // return !$.support.touch;
    };

    return {
        init: init
    }

})();