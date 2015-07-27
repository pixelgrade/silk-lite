/* ====== ON DOCUMENT READY ====== */

$(document).ready(function() {
  init();
});

function init() {
  browserSize();
  platformDetect();
}

/* ====== ON WINDOW LOAD ====== */

$window.load(function() {
  browserSize();
  navigation.init();
  slider.init();
  fixedSidebars.update();
  svgLogo.init();
  animator.animate();
  scrollToTop();
  infinityHandler();

  if (latestKnownScrollY) $window.trigger('scroll');
});

/* ====== ON RESIZE ====== */

function onResize() {
  var newOrientation = windowWidth >= windowHeight ? 'landscape' : 'portrait';

  if (Modernizr.touch) {
    if (orientation != newOrientation) {
      slider.init();
    }
  } else {
    slider.init();
  }


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
  fixedSidebars.init();
  fixedSidebars.update();
  navigation.toggleTopBar();
  svgLogo.update();
  ticking = false;
}