(function ($, undefined) {
  /**
   * Shared variables
   */
  var ua = navigator.userAgent.toLowerCase(),
      platform = navigator.platform.toLowerCase(),
      $window = $(window),
      $document = $(document),
      $html = $('html'),
      $body = $('body'),
      
      
      iphone = platform.indexOf("iphone"),
      ipod = platform.indexOf("ipod"),
      android = platform.indexOf("android"),
      android_ancient = (ua.indexOf('mozilla/5.0') !== -1 && ua.indexOf('android') !== -1 && ua.indexOf('applewebKit') !== -1) && ua.indexOf('chrome') === -1,
      apple = ua.match(/(iPad|iPhone|iPod|Macintosh)/i),
      windows_phone = ua.indexOf('windows phone') != -1,
      webkit = ua.indexOf('webkit') != -1,
      
      
      firefox = ua.indexOf('gecko') != -1,
      firefox_3x = firefox && ua.match(/rv:1.9/i),
      ie = ua.indexOf('msie' != -1),
      ie_newer = ua.match(/msie (9|([1-9][0-9]))/i),
      ie_older = ie && !ie_newer,
      ie_ancient = ua.indexOf('msie 6') != -1,
      safari = ua.indexOf('safari') != -1 && ua.indexOf('chrome') == -1,
      
      
      windowHeight = $window.height(),
      windowWidth = $window.width(),
      documentHeight = $document.height(),
      
      
      latestKnownScrollY = window.scrollY,
      ticking = false; /* ====== Masonry Logic ====== */

  var masonry = (function () {

    var $container = $('.archive__grid'),
        $blocks = $container.children().addClass('post--animated  post--loaded'),
        
        
        init = function () {
        $container.imagesLoaded(function () {
          $container.masonry({
            isAnimated: false,
            itemSelector: '.grid__item',
            hiddenStyle: {
              opacity: 0
            }
          });
          bindEvents();
          showBlocks($blocks);
        });
        },
        
        
        bindEvents = function () {
        $window.on('debouncedresize', refresh);
        $body.on('post-load', onLoad);
        },
        
        
        refresh = function () {
        $container.masonry('layout');
        },
        
        
        showBlocks = function ($blocks) {
        if (!$.support.touch) {
          $blocks.addHoverAnimation();
        }
        },
        
        
        onLoad = function () {
        var $newBlocks = $container.children().not('.post--loaded').addClass('post--loaded');
        $newBlocks.imagesLoaded(function () {
          $container.masonry('appended', $newBlocks, true).masonry('layout');
          showBlocks($newBlocks);
        });

        };

    return {
      init: init,
      refresh: refresh
    }

  })();

  /**
   * cardHover jQuery plugin
   *
   * we need to create a jQuery plugin so we can easily create the hover animations on the archive
   * both an window.load and on jetpack's infinite scroll 'post-load'
   */
  $.fn.addHoverAnimation = function () {

    return this.each(function (i, obj) {

      var $obj = $(obj);

      // if we don't have have elements that need to be animated return
      if (!$obj.length) {
        return;
      }

      // bind the tweens we created above to mouse events accordingly, through hoverIntent to avoid flickering
      $obj.hoverIntent({
        over: animateHoverIn,
        out: animateHoverOut,
        timeout: 100,
        interval: 50
      });

      function animateHoverIn() {

      }

      function animateHoverOut() {

      }

    });

  } /* ====== Navigation Logic ====== */

  var navigation = (function () {

    var $nav = $('.nav--main').addClass('hover-intent'),
        $navItems = $nav.find('li'),
        navWidth = $nav.outerWidth(),
        navOffset = $nav.offset(),
        navTop = navOffset.top,
        navBottom = navTop + $nav.outerHeight(),
        
        
        init = function () { /* add hover intent to main navigation links */
        $navItems.hoverIntent({
          over: showSubMenu,
          out: hideSubMenu,
          timeout: 300
        });

        $navItems.on('mouseleave', function () {
          hideSubMenu(this);
        });
        },
        
        
        showSubMenu = function () {

        var $item = $(this).addClass('hover');

        if ($item.hasClass('menu-item--mega')) {

          var $subMenu = $item.children('.sub-menu-wrapper'),
              offset, subMenuWidth;

          if ($subMenu.length) {

            subMenuWidth = $subMenu.outerWidth();

            // calculations for positioning the submenu
            var a = $item.index(),
                b = $nav.children().length,
                c = navWidth - subMenuWidth,
                x = (a - b / 2 + 1 / 2) * c / b + c / 2;

            $subMenu.css('left', x);
          }
        }
        },
        
        
        hideSubMenu = function () {

        var $item = $(this);

        if ($item.hasClass('menu-item--mega')) {
          $item.children('.sub-menu-wrapper').css('left', '');
        }

        $item.removeClass('hover');
        },
        
        
        toggleTopBar = function () {

        if (navBottom < latestKnownScrollY) {
          $('.top-bar.fixed').addClass('visible');
          $('.nav--floating').addClass('nav--floating--is-visible');
        } else {
          $('.top-bar.fixed').removeClass('visible');
          $('.nav--floating').removeClass('nav--floating--is-visible');
        }

        };

    return {
      init: init,
      toggleTopBar: toggleTopBar
    }

  })();
  // /* ====== Search Overlay Logic ====== */
  (function () {

    var isOpen = false,
        $overlay = $('.overlay--search');

    // update overlay position (if it's open) on window.resize
    $window.on('debouncedresize', function () {

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
    $('.nav__item--search').on('click touchstart', function (e) {
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
    $('.overlay__close').on('click touchstart', function (e) {

      e.preventDefault();
      e.stopPropagation();

      closeOverlay();

      // unbind overlay dismissal from escape key
      $(document).off('keyup', escOverlay);

    });

  })(); /* ====== Fixed Sidebars Logic ====== */

  var fixedSidebars = (function () {

    var $smallSidebar = $('.single-sidebar'),
        smallSidebarPinned = false,
        smallSidebarPadding = 100,
        smallSidebarOffset;

    var $sidebar = $('.sidebar--main'),
        $main = $('.site-main'),
        mainHeight = $main.outerHeight(),
        sidebarPinned = false,
        sidebarPadding = 60,
        sidebarBottom, sidebarOffset, sidebarHeight,
        
        
        /**
         * initialize sidebar positioning
         */
        
        init = function () {
        update();
        },
        
        
        
        /**
         * update position of the two sidebars depending on scroll position
         */
        
        update = function () {

        /* adjust right sidebar positioning if needed */
        if (sidebarHeight < mainHeight) {

          var windowBottom = latestKnownScrollY + windowHeight,
              sidebarBottom = sidebarHeight + sidebarOffset.top + sidebarPadding,
              mainBottom = mainHeight + sidebarOffset.top + sidebarPadding;


          if (windowBottom > sidebarBottom && !sidebarPinned) {
            $sidebar.css({
              position: 'fixed',
              top: windowHeight - sidebarHeight - sidebarPadding,
              left: sidebarOffset.left
            });
            sidebarPinned = true;
          }

          if (windowBottom <= sidebarBottom && sidebarPinned) {
            $sidebar.css({
              position: '',
              top: '',
              left: ''
            });
            sidebarPinned = false;
          }

          if (windowBottom <= mainBottom) {
            $sidebar.css('top', windowHeight - sidebarHeight - sidebarPadding);
            return;
          }

          if (windowBottom > mainBottom && windowBottom < documentHeight) {
            $sidebar.css('top', mainBottom - sidebarPadding - sidebarHeight - latestKnownScrollY);
          }

          if (windowBottom >= documentHeight) {
            $sidebar.css('top', mainBottom - sidebarPadding - sidebarHeight - documentHeight + windowHeight);
          }

        }

        /* adjust left sidebar positioning if needed */
        if (!$smallSidebar.length) {
          return;
        }

        if (smallSidebarOffset.top - smallSidebarPadding < latestKnownScrollY && !smallSidebarPinned) {
          $smallSidebar.css({
            position: 'fixed',
            top: smallSidebarPadding,
            left: smallSidebarOffset.left
          });
          smallSidebarPinned = true;
        }

        if (smallSidebarOffset.top - smallSidebarPadding >= latestKnownScrollY && smallSidebarPinned) {
          $smallSidebar.css({
            position: '',
            top: '',
            left: ''
          });
          smallSidebarPinned = false;
        }

        },
        
        
        refresh = function () {
        if (!$sidebar.length) return;

        var positionValue = $sidebar.css('position'),
            topValue = $sidebar.css('top'),
            leftValue = $sidebar.css('left'),
            pinnedValue = sidebarPinned;

        $sidebar.css({
          position: '',
          top: '',
          left: ''
        });

        sidebarPinned = false;
        sidebarOffset = $sidebar.offset();
        sidebarHeight = $sidebar.outerHeight();
        mainHeight = $main.outerHeight();

        $sidebar.css({
          position: positionValue,
          top: topValue,
          left: leftValue
        });

        sidebarPinned = pinnedValue;

        };

    return {
      init: init,
      update: update,
      refresh: refresh
    }

  })(); /* ====== Slider Logic ====== */

  var slider = (function () {

    var $sliders = $('.flexslider'),
        
        
        init = function () {

        if ($.flexslider !== undefined && $sliders.length) {

          $sliders.flexslider({
            controlNav: false,
            prevText: "<span>Previous</span>",
            nextText: "<span>Next</span>",
            start: function () {
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

  })(); /* ====== ON DOCUMENT READY ====== */

  $document.ready(function () {
    init();
  });

  function init() {
    browserSize();
    platformDetect();
    masonry.init();
    navigation.init();
    styleArchiveWidget();
    //wrapJetpackAfterContent();
  }

  /* ====== ON WINDOW LOAD ====== */

  $window.load(function () {
    browserSize();
    slider.init();
    fixedSidebars.refresh();
  });

  /* ====== ON RESIZE ====== */

  $window.on('debouncedresize', function () {
    browserSize();
    fixedSidebars.refresh();
  });

  /* ====== ON SCROLL ====== */

  $window.on('scroll', function (e) {
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
/*
 * debouncedresize: special jQuery event that happens once after a window resize
 *
 * latest version and complete README available on Github:
 * https://github.com/louisremi/jquery-smartresize
 *
 * Copyright 2012 @louis_remi
 * Licensed under the MIT license.
 *
 * This saved you an hour of work? 
 * Send me music http://www.amazon.co.uk/wishlist/HNTU0468LQON
 */
  (function ($) {

    var $event = $.event,
        $special, resizeTimeout;

    $special = $event.special.debouncedresize = {
      setup: function () {
        $(this).on("resize", $special.handler);
      },
      teardown: function () {
        $(this).off("resize", $special.handler);
      },
      handler: function (event, execAsap) {
        // Save the context
        var context = this,
            args = arguments,
            dispatch = function () {
            // set correct event type
            event.type = "debouncedresize";
            $event.dispatch.apply(context, args);
            };

        if (resizeTimeout) {
          clearTimeout(resizeTimeout);
        }

        execAsap ? dispatch() : resizeTimeout = setTimeout(dispatch, $special.threshold);
      },
      threshold: 150
    };

  })(jQuery);
  /**
   * requestAnimationFrame polyfill by Erik Möller.
   * Fixes from Paul Irish, Tino Zijdel, Andrew Mao, Klemen Slavič, Darius Bacon
   *
   * MIT license
   */
  if (!Date.now) Date.now = function () {
    return new Date().getTime();
  };

  (function () {
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
      window.requestAnimationFrame = function (callback) {
        var now = Date.now();
        var nextTime = Math.max(lastTime + 16, now);
        return setTimeout(function () {
          callback(lastTime = nextTime);
        }, nextTime - now);
      };
      window.cancelAnimationFrame = clearTimeout;
    }
  }()); /* ====== HELPER FUNCTIONS ====== */



  /**
   * Detect what platform are we on (browser, mobile, etc)
   */

  function platformDetect() {
    $.support.touch = 'ontouchend' in document;
    $.support.svg = (document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure", "1.1")) ? true : false;
    $.support.transform = getSupportedTransform();

    $html.toggleClass('touch', $.support.touch).toggleClass('svg', $.support.svg).toggleClass('transform', !! $.support.transform);
  }



  function browserSize() {
    windowHeight = $window.height();
    windowWidth = $window.width();
    documentHeight = $document.height();
  }



  function getSupportedTransform() {
    var prefixes = ['transform', 'WebkitTransform', 'MozTransform', 'OTransform', 'msTransform'];
    for (var i = 0; i < prefixes.length; i++) {
      if (document.createElement('div').style[prefixes[i]] !== undefined) {
        return prefixes[i];
      }
    }
    return false;
  }


  /**
   * Adding a class and some mark-up to the
   * archive widget to make it look splendid
   */

  function styleArchiveWidget() {
    var archiveWidget = $('.sidebar--main .widget_archive ul').parent();
    archiveWidget.addClass('shrink');
    var separatorMarkup = '<span class="separator  separator--text" role="presentation"><span>More</span></a>';
    archiveWidget.append(separatorMarkup);
    fixedSidebars.refresh();
  }

  /**
   * Wrap Jetpack's related posts and
   * Sharedaddy sharing into one div
   * to make a left sidebar on single posts
   */

  function wrapJetpackAfterContent() {
    // check if we are on single post and the wrap has not been done already by Jetpack
    // (it happens when the theme is activated on a wordpress.com installation)
    if ($('body').hasClass('single-post') && $('#jp-post-flair').length == 0) {

      var $jpSharing = $('.sharedaddy.sd-sharing-enabled');
      var $jpLikes = $('.sharedaddy.sd-like');
      var $jpRelatedPosts = $('#jp-relatedposts');

      if ($jpSharing.length || $jpLikes.length || $jpRelatedPosts.length) {
        $('body').addClass('has--jetpack-sidebar');

        var $jpWrapper = $('<div/>', {
          id: 'jp-post-flair'
        });
        $jpWrapper.appendTo($('.entry-content'));

        if ($jpSharing.length) {
          $jpSharing.appendTo($jpWrapper);
        }

        if ($jpLikes.length) {
          $jpLikes.appendTo($jpWrapper);
        }

        if ($jpRelatedPosts.length) {
          $jpRelatedPosts.appendTo($jpWrapper);
        }
      }
    }
  }



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

})(jQuery);