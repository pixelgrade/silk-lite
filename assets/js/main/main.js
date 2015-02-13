/* ====== ON DOCUMENT READY ====== */

$(document).ready(function() {
  init();
});

function init() {
  browserSize();
  platformDetect();

  if ( $.support.svg ) {
    var $header     = $('.site-header'),
        $title      = $('.site-title'),
        $span       = $title.find('span'),
        $svg        = $title.find('svg'),
        $text       = $svg.find('text'),
        headerWidth = $header.width(),
        fontSize    = parseInt($span.css('font-size')),
        textWidth,
        titleWidth;

      $span.css('white-space', 'nowrap');

      titleWidth = $span.show().width();

      while (titleWidth > headerWidth) {
        fontSize = fontSize - 1;
        $span.css('font-size', fontSize);
        titleWidth = $span.width();
      }

      $span.hide();

      $title.css('font-size', fontSize);
      $('.site-title svg').width(titleWidth);
      
      setTimeout(function() {
        textWidth = $text.width();
        $text.attr('x', (titleWidth - textWidth)/2);
      }, 300);

  }
}

/* ====== ON WINDOW LOAD ====== */

$window.load(function() {
  browserSize();
  navigation.init();
  slider.init();
  wrapJetpackAfterContent();
  fixedSidebars.update();
  animator.animate();
  scrollToTop();
  infinityHandler();

  if (latestKnownScrollY) $window.trigger('scroll');

});

/* ====== ON RESIZE ====== */

function onResize() {
  browserSize();
  masonry.refresh();
  fixedSidebars.refresh();
  fixedSidebars.update();
}

$window.on('debouncedresize', onResize);

/* ====== ON SCROLL ====== */

function onScroll() {
  latestKnownScrollY = window.scrollY;
  requestTick();
}

$window.on('scroll', onScroll);

function requestTick() {
  if (!ticking) {
    requestAnimationFrame(update);
  }
  ticking = true;
}

function update() {
  fixedSidebars.update();
  navigation.toggleTopBar();
  ticking = false;
}