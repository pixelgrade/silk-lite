/* ====== Slider Logic ====== */

var slider = (function () {
    
    var $sliders = $('.flexslider'),

    init = function() {

        if ($.flexslider !== undefined && $sliders.length) {

            $sliders.flexslider({
                animation: "fade",
                slideshow: false, //no autostart slideshow for accessibility purposes
                controlNav: false,
                prevText: "<span>Previous</span>",
                nextText: "<span>Next</span>",
                start: function() {
                    var $arrow = $('.svg-templates .slider-arrow');
                    $arrow.clone().appendTo('.flex-direction-nav .flex-prev');
                    $arrow.clone().appendTo('.flex-direction-nav .flex-next');
                }
            });
        }
    };

    return { 
        init: init
    }

})();