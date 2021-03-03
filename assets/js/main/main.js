/* ====== ON DOCUMENT READY ====== */

$(document).ready(function() {
  init();
});

function init() {
  browserSize();
  platformDetect();
}

/* ====== ON WINDOW LOAD ====== */

$window.on('load', function() {
  browserSize();
  navigation.init();
  fixedSidebars.update();
  svgLogo.init();
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
  latestKnownScrollY = $window.scrollTop();

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
  svgLogo.update();
  ticking = false;
}
