/* ====== ON DOCUMENT READY ====== */

$document.ready(function() {
  init();
});

function init() {
  browserSize();
  platformDetect();
  masonry.init();
  navigation.init();
  styleArchiveWidget();
}

/* ====== ON WINDOW LOAD ====== */

$window.load(function() {
  browserSize();
  slider.init();
  fixedSidebars.refresh();
});

/* ====== ON RESIZE ====== */

$window.on('debouncedresize', function() {
  browserSize();
  fixedSidebars.refresh();
});

/* ====== ON SCROLL ====== */

$window.on('scroll', function(e) {
  latestKnownScrollY = window.scrollY;
  requestTick();
});

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