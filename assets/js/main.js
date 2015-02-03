(function($, window, undefined) {

  // /* ====== SHARED VARS  - jQuery ====== */
  // These depend on jQuery
  
  /**
   * Detect browser size and remember it in global variables
   */

  function browserSize() {
      windowHeight    = $window.height();
      windowWidth     = $window.width();
      documentHeight  = $document.height();
  }


  /**
   * Detect what platform are we on (browser, mobile, etc)
   */
  
  var ua              = navigator.userAgent.toLowerCase(),
      platform        = navigator.platform.toLowerCase(),
      $window         = $(window),
      $document       = $(document),
      $html           = $('html'),
      $body           = $('body'),
      
      iphone          = platform.indexOf("iphone"),
      ipod            = platform.indexOf("ipod"),
      android         = platform.indexOf("android"),
      android_ancient = (ua.indexOf('mozilla/5.0') !== -1 && ua.indexOf('android') !== -1 && ua.indexOf('applewebKit') !== -1) && ua.indexOf('chrome') === -1,
      apple           = ua.match(/(iPad|iPhone|iPod|Macintosh)/i),
      windows_phone   = ua.indexOf('windows phone') != -1,
      webkit          = ua.indexOf('webkit') != -1,

      firefox         = ua.indexOf('gecko') != -1,
      firefox_3x      = firefox && ua.match(/rv:1.9/i),
      ie              = ua.indexOf('msie' != -1),
      ie_newer        = ua.match(/msie (9|([1-9][0-9]))/i),
      ie_older        = ie && !ie_newer,
      ie_ancient      = ua.indexOf('msie 6') != -1,
      safari          = ua.indexOf('safari') != -1 && ua.indexOf('chrome') == -1,

      windowHeight    = $window.height(),
      windowWidth     = $window.width(),
      documentHeight  = $(document).height();

  function getSupportedTransform() {
    var prefixes = ['transform', 'WebkitTransform', 'MozTransform', 'OTransform', 'msTransform'];
    for(var i = 0; i < prefixes.length; i++) {
        if(document.createElement('div').style[prefixes[i]] !== undefined) {
            return prefixes[i];
        }
    }
    return false;
  }

  function platformDetect() {
    $.support.touch     = 'ontouchend' in document;
    $.support.svg       = (document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure", "1.1")) ? true : false;
    $.support.transform = getSupportedTransform();

    $html
      .toggleClass('touch', $.support.touch)
      .toggleClass('svg', $.support.svg)
      .toggleClass('transform', !!$.support.transform);
  }

  // /* ====== Masonry Logic ====== */
  function masonryInit() {

    var $container  = $('.archive__grid'),
        $blocks     = $container.children().addClass('post--animated  post--loaded'),
        slices      = $blocks.first().children().length;

    // initialize masonry after the images have loaded
    $container.imagesLoaded(function() {

      // prepare hover animations
      if (!$html.hasClass('touch'))
        $blocks.addHoverAnimation();

      // initialize masonry
      $container.masonry({
        isAnimated: false,
        itemSelector: '.grid__item',
        hiddenStyle: {
          opacity: 0
        }
      });

      /**
       * function used to display cards with a simple fade in transition
       */
      function showBlocks($blocks) { }

      // animate cards in
      showBlocks($blocks);

      // update the masonry layout on window.resize
      $window.smartresize(function() { $container.masonry('layout'); });

      // handle behavior for infinite scroll
      $(document.body).on('post-load', function() {

        // figure out which are the new loaded posts
        var $newBlocks = $('.archive__grid').children().not('.post--loaded').addClass('post--loaded');

        // when images have loaded take care of the layout, prepare hover animations, and animate cards in
        $newBlocks.imagesLoaded(function() {
          $container.masonry('appended', $newBlocks, true).masonry('layout');
          if (!$html.hasClass('touch'))
            $newBlocks.addHoverAnimation();
          showBlocks($newBlocks);
        });
      });

    });

  }

  // /* ====== Navigation Logic ====== */
  var $nav      = $('.nav--main'),
      navOffset = $nav.offset(),
      navTop    = navOffset.top,
      $navTrigger = $('.nav__trigger'),
      navBottom = navTop + $nav.outerHeight();

  function toggleTopBar() {

    if (navBottom < latestKnownScrollY) {
      $('.top-bar.fixed').addClass('visible');
      $('.nav--floating').addClass('nav--floating--is-visible');
    } else {
      $('.top-bar.fixed').removeClass('visible');
      $('.nav--floating').removeClass('nav--floating--is-visible');
    }
  }

  /**
   * bind toggling the navigation drawer to click and touchstart
   *in order to get rid of the 300ms delay on touch devices we use the touchstart event
   */
  var triggerEvents = 'click touchstart';

  if (android_ancient) {
    triggerEvents = 'click';
  }

  $navTrigger.on(triggerEvents, function(e) {
    // but we still have to prevent the default behavior of the touchstart event
    // because this way we're making sure the click event won't fire anymore
    e.preventDefault();
    e.stopPropagation();

    isOpen = !isOpen;
    $body.toggleClass('nav--is-open');

    var offset;

    navWidth = $nav.outerWidth();

    if ($body.hasClass('rtl')) {
      offset = -1 * navWidth;
    } else {
      offset = navWidth;
    }

    if (!is_android) {
      if (!isOpen) {

        $([$nav, $navTrigger]).each(function(i, obj) {
          $(obj).velocity({
            translateX: 0,
            translateZ: 0.01
          }, {
            duration: 300,
            easing: "easeInQuart"
          });
        });

      } else {

        $([$nav, $navTrigger]).each(function(i, obj) {
          $(obj).velocity({
            translateX: offset,
            translateZ: 0.01
          }, {
            easing: "easeOutCubic",
            duration: 300
          });
        });

      }
      $nav.toggleClass('shadow', isOpen);
    }
  });

  /**
   * Adding a class and some mark-up to the
   * archive widget to make it look splendid
   */
  function styleArchiveWidget() {
    var archiveWidget = $('.sidebar--main .widget_archive ul').parent();
    archiveWidget.addClass('shrink');
    var separatorMarkup = '<span class="separator  separator--text" role="presentation"><span>More</span></a>';
    archiveWidget.append(separatorMarkup);
  }

  /**
   * Wrap Jetpack's related posts and
   * Sharedaddy sharing into one div
   * to make a left sidebar on single posts
   */
  function wrapJetpackAfterContent() {
    // check if we are on single post and the wrap has not been done already by Jetpack
    // (it happens when the theme is activated on a wordpress.com installation)
    if( $('body').hasClass('single-post') && $('#jp-post-flair').length == 0 ) {
      var $jpWrapper = $('<div/>', { id: 'jp-post-flair' });

      $jpWrapper.appendTo($('.entry-content'));

      var $jpSharing = $('.sharedaddy.sd-sharing-enabled');
      if( $jpSharing.length ) {
        $jpSharing.appendTo($jpWrapper);
      }

      var $jpLikes = $('.sharedaddy.sd-like');
      if( $jpLikes.length ) {
        $jpLikes.appendTo($jpWrapper);
      }

      var $jpRelatedPosts = $('#jp-relatedposts');
      if( $jpRelatedPosts.length ) {
        $jpRelatedPosts.appendTo($jpWrapper);
      }


    }
  }

  /**
   * cardHover jQuery plugin
   *
   * we need to create a jQuery plugin so we can easily create the hover animations on the archive
   * both an window.load and on jetpack's infinite scroll 'post-load'
   */
  $.fn.addHoverAnimation = function() {

    return this.each(function(i, obj) {

      var $obj      = $(obj),
          $handler  = $obj.find('.hover__handler'),
          $hover    = $obj.find('.hover');

      // if we don't have have elements that need to be animated return
      if (!$hover.length) {
        return;
      }

      // bind the tweens we created above to mouse events accordingly, through hoverIntent to avoid flickering
      if ($handler.length) {
        $handler.hoverIntent({
          over: animateHoverIn,
          out: animateHoverOut,
          timeout: 100,
          interval: 50
        });
      }

      function animateHoverIn() {

      }

      function animateHoverOut() {

      }

    });
  };

  // /* ====== Search Overlay Logic ====== */
  (function() {

    var isOpen = false,
      $overlay = $('.overlay--search');

    // update overlay position (if it's open) on window.resize
    $window.on('smartresize', function() {

      windowWidth = $window.outerWidth();

      if (isOpen) {
        $overlay.velocity({
          translateX: -1 * windowWidth
        }, {
          duration: 200,
          easing: "easeInCubic"
        });
      }

    });

    /**
     * dismiss overlay
     */
    function closeOverlay() {

      if (!isOpen) {
        return;
      }

      var offset;

      if ($body.hasClass('rtl')) {
        offset = windowWidth
      } else {
        offset = -1 * windowWidth
      }

      // we don't need a timeline for this animations so we'll use a simple tween between two states
      $overlay.velocity({
        translateX: offset
      }, {
        duration: 0
      });
      $overlay.velocity({
        translateX: 0
      }, {
        duration: 300,
        easing: "easeInCubic"
      });

      // remove focus from the search field
      $overlay.find('input').blur();

      isOpen = false;
    }

    function escOverlay(e) {
      if (e.keyCode == 27) {
        closeOverlay();
      }
    }

    // create animation and run it on
    $('.nav__item--search').on('click touchstart', function(e) {
      // prevent default behavior and stop propagation
      e.preventDefault();
      e.stopPropagation();

      // if through some kind of sorcery the navigation drawer is already open return
      if (isOpen) {
        return;
      }

      var offset;

      if ($body.hasClass('rtl')) {
        offset = windowWidth
      } else {
        offset = -1 * windowWidth
      }

      // automatically focus the search field so the user can type right away
      $overlay.find('input').focus();

      $overlay.velocity({
        translateX: 0
      }, {
        duration: 0
      }).velocity({
        translateX: offset
      }, {
        duration: 300,
        easing: "easeOut",
        queue: false
      });

      $('.search-form').velocity({
        translateX: 300,
        opacity: 0
      }, {
        duration: 0
      }).velocity({
        opacity: 1
      }, {
        duration: 200,
        easing: "easeOutQuad",
        delay: 200,
        queue: false
      }).velocity({
        translateX: 0
      }, {
        duration: 400,
        easeing: [0.175, 0.885, 0.320, 1.275],
        delay: 50,
        queue: false
      });

      $('.overlay__wrapper > p').velocity({
        translateX: 200,
        opacity: 0
      }, {
        duration: 0
      }).velocity({
        opacity: 1
      }, {
        duration: 400,
        easing: "easeOutQuad",
        delay: 350,
        queue: false
      }).velocity({
        translateX: 0
      }, {
        duration: 400,
        easing: [0.175, 0.885, 0.320, 1.275],
        delay: 250,
        queue: false
      });

      // bind overlay dismissal to escape key
      $(document).on('keyup', escOverlay);

      isOpen = true;
    });

    // create function to hide the search overlay and bind it to the click event
    $('.overlay__close').on('click touchstart', function(e) {

      e.preventDefault();
      e.stopPropagation();

      closeOverlay();

      // unbind overlay dismissal from escape key
      $(document).off('keyup', escOverlay);

    });

  })();

  // /* ====== Smart Resize Logic ====== */
  // It's best to debounce the resize event to a void performance hiccups
  (function($, sr) {

    /**
     * debouncing function from John Hann
     * http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
     */
    var debounce = function(func, threshold, execAsap) {
        var timeout;

        return function debounced() {
          var obj = this,
            args = arguments;

          function delayed() {
            if (!execAsap) func.apply(obj, args);
            timeout = null;
          }

          if (timeout) clearTimeout(timeout);
          else if (execAsap) func.apply(obj, args);

          timeout = setTimeout(delayed, threshold || 200);
        };
      }
      // smartresize
    jQuery.fn[sr] = function(fn) {
      return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr);
    };

  })(jQuery, 'smartresize');

  var latestKnownScrollY = window.scrollY,
    ticking = false;

  function requestTick() {
    "use strict";

    if (!ticking) {
      requestAnimationFrame(update);
    }
    ticking = true;
  }

  function update() {
    "use strict";
    toggleTopBar();
    ticking = false;
  }

  /* ====== INTERNAL FUNCTIONS END ====== */


  /* ====== ONE TIME INIT ====== */

  function init() {

    /* GLOBAL VARS */
    touch = false;

    /* GET BROWSER DIMENSIONS */
    browserSize();

    /* DETECT PLATFORM */
    platformDetect();

    masonryInit();
  }


  /* --- GLOBAL EVENT HANDLERS --- */


  /* ====== ON DOCUMENT READY ====== */

  $(document).ready(function() {
    init();
  });


  /* ====== ON WINDOW LOAD ====== */

  $window.load(function() {

    var $nav      = $('.nav--main').addClass('hover-intent'),
        $navItems = $nav.find('li'),
        navWidth  = $nav.outerWidth(),
        $sliders  = $('.flexslider');

    /* initialize flexslider */
    if (typeof $.flexslider !== 'undefined' && $sliders.length) {
      $sliders.flexslider({
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

    /* add hover intent to main navigation links */
    $navItems.hoverIntent({
      over: showSubMenu,
      out: hideSubMenu,
      timeout: 300
    });

    function showSubMenu() {

      var $item = $(this);

      if ( $item.hasClass('menu-item--mega') ) {

        var $subMenu = $item.children('.sub-menu-wrapper'),
            offset,
            subMenuWidth;

        if ($subMenu.length) {
          subMenuWidth = $subMenu.outerWidth();
          // calculations for positioning the submenu
          a = $item.index(),
          b = $nav.children().length,
          c = navWidth - subMenuWidth,
          x = (a - b/2 + 1/2) * c/b + c/2;

          $subMenu.css('left', x);
        }
      }

      $(this).addClass('hover');
    }

    function hideSubMenu() {

      var $item = $(this);

      if ( $item.hasClass('menu-item--mega') ) {
        $item.children('.sub-menu-wrapper').css('left', '');
      }

      $item.removeClass('hover');
    }

    $('.nav--main li').on('mouseleave', function(event) {
      hideSubMenu(this);
    });

    styleArchiveWidget();
    wrapJetpackAfterContent();

  });

  /* ====== ON RESIZE ====== */

  $window.smartresize(function() {
    browserSize();
  });

  /* ====== ON SCROLL ====== */

  $window.on('scroll', function(e) {
    "use strict";
    latestKnownScrollY = window.scrollY;
    requestTick();
  });

  // /* ====== HELPER FUNCTIONS ====== */
  /**
   * function similar to PHP's empty function
   */

  function empty(data) {
    if (typeof(data) == 'number' || typeof(data) == 'boolean') {
      return false;
    }
    if (typeof(data) == 'undefined' || data === null) {
      return true;
    }
    if (typeof(data.length) != 'undefined') {
      return data.length === 0;
    }
    var count = 0;
    for (var i in data) {
      // if(data.hasOwnProperty(i))
      //
      // This doesn't work in ie8/ie9 due the fact that hasOwnProperty works only on native objects.
      // http://stackoverflow.com/questions/8157700/object-has-no-hasownproperty-method-i-e-its-undefined-ie8
      //
      // for hosts objects we do this
      if (Object.prototype.hasOwnProperty.call(data, i)) {
        count++;
      }
    }
    return count === 0;
  }

  /**
   * function to add/modify a GET parameter
   */

  function setQueryParameter(uri, key, value) {
    var re = new RegExp("([?|&])" + key + "=.*?(&|$)", "i");
    separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
      return uri.replace(re, '$1' + key + "=" + value + '$2');
    } else {
      return uri + separator + key + "=" + value;
    }
  }

  /**
   * requestAnimationFrame polyfill by Erik Möller.
   * Fixes from Paul Irish, Tino Zijdel, Andrew Mao, Klemen Slavič, Darius Bacon
   *
   * MIT license
   */

  if (!Date.now)
    Date.now = function() {
      return new Date().getTime();
    };

  (function() {
    'use strict';

    var vendors = ['webkit', 'moz'];
    for (var i = 0; i < vendors.length && !window.requestAnimationFrame; ++i) {
      var vp = vendors[i];
      window.requestAnimationFrame = window[vp + 'RequestAnimationFrame'];
      window.cancelAnimationFrame = (window[vp + 'CancelAnimationFrame'] || window[vp + 'CancelRequestAnimationFrame']);
    }
    if (/iP(ad|hone|od).*OS 6/.test(window.navigator.userAgent) // iOS6 is buggy
      || !window.requestAnimationFrame || !window.cancelAnimationFrame) {
      var lastTime = 0;
      window.requestAnimationFrame = function(callback) {
        var now = Date.now();
        var nextTime = Math.max(lastTime + 16, now);
        return setTimeout(function() {
            callback(lastTime = nextTime);
          },
          nextTime - now);
      };
      window.cancelAnimationFrame = clearTimeout;
    }
  }());

})(jQuery, window);