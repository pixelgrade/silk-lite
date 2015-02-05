/**
 * jQuery plugin to make the main navigation WAI-ARIA compatible
 * Inspired by http://simplyaccessible.com/examples/css-menu/option-6/
 *
 * It needs jquery.hoverIntent
 */
(function ($) {

  $.fn.ariaNavigation = function (settings) {

    //Map of all the alphanumeric keys so one can jump through submenus by typing the first letter
    //Also use the ESC key to close a submenu
    var keyCodeMap = {
      48: "0",
      49: "1",
      50: "2",
      51: "3",
      52: "4",
      53: "5",
      54: "6",
      55: "7",
      56: "8",
      57: "9",
      59: ";",
      65: "a",
      66: "b",
      67: "c",
      68: "d",
      69: "e",
      70: "f",
      71: "g",
      72: "h",
      73: "i",
      74: "j",
      75: "k",
      76: "l",
      77: "m",
      78: "n",
      79: "o",
      80: "p",
      81: "q",
      82: "r",
      83: "s",
      84: "t",
      85: "u",
      86: "v",
      87: "w",
      88: "x",
      89: "y",
      90: "z",
      96: "0",
      97: "1",
      98: "2",
      99: "3",
      100: "4",
      101: "5",
      102: "6",
      103: "7",
      104: "8",
      105: "9"
    },
        $nav = $(this),
        $topLevelLinks = $nav.find('> li > a'),
        navWidth = $nav.outerWidth();

    //default settings
    settings = jQuery.extend({
      menuHoverClass: 'show-menu',
      topMenuHoverClass: 'hover'
    }, settings);


    /**
     *  First add the needed WAI-ARIA markup - supercharge the menu
     */

    // Add ARIA role to menubar and menu items
    $nav.attr('role', 'menubar').find('li').attr('role', 'menuitem');

    // Set tabIndex to -1 so that $topLevelLinks can't receive focus until menu is open
    $topLevelLinks.next('ul').attr('data-test', 'true').attr({
      'aria-hidden': 'true',
      'role': 'menu'
    }).find('a').attr('tabIndex', -1);

    // Add aria-haspopup for appropriate items
    $topLevelLinks.each(function () {
      if ($(this).next('ul').length > 0) $(this).parent('li').attr('aria-haspopup', 'true');
    });


    /**
     * Now let's begin binding things to their proper events
     */

    // First, bind to the hover event
    // use hoverIntent to make sure we avoid flicker
    $topLevelLinks.closest('li').hoverIntent({
      over: function () {
        //clean up first
        $(this).closest('ul').find('ul.' + settings.menuHoverClass).attr('aria-hidden', 'true').removeClass(settings.menuHoverClass).find('a').attr('tabIndex', -1);

        $(this).closest('ul').find('.' + settings.topMenuHoverClass).removeClass(settings.topMenuHoverClass);

        //now do things
        showSubMenu($(this));

      },
      out: function () {
        hideSubMenu($(this));
      },
      timeout: 300
    });

    // Secondly, bind to the focus event - very important for WAI-ARIA purposes
    $topLevelLinks.focus(function () {
      //clean up first
      $(this).closest('ul').find('ul.' + settings.menuHoverClass).attr('aria-hidden', 'true').removeClass(settings.menuHoverClass).find('a').attr('tabIndex', -1);

      $(this).closest('ul').find('.' + settings.topMenuHoverClass).removeClass(settings.topMenuHoverClass);

      //now do things
      showSubMenu($(this).closest('li'));

    });


    // Now bind arrow keys for navigating the menu
    // First the top level links (the permanent visible links)
    $topLevelLinks.keydown(function (e) {
      var $item = $(this);

      if (e.keyCode == 37) { //left arrow
        e.preventDefault();
        // This is the first item
        if ($item.parent('li').prev('li').length == 0) {
          $item.parents('ul').find('> li').last().find('a').first().focus();
        } else {
          $item.parent('li').prev('li').find('a').first().focus();
        }
      } else if (e.keyCode == 38) { //up arrow
        e.preventDefault();
        if ($item.parent('li').find('ul').length > 0) {
          $item.parent('li').find('ul').attr('aria-hidden', 'false').addClass(settings.menuHoverClass).find('a').attr('tabIndex', 0).last().focus();
        }
      } else if (e.keyCode == 39) { //right arrow
        e.preventDefault();
        // This is the last item
        if ($item.parent('li').next('li').length == 0) {
          $item.parents('ul').find('> li').first().find('a').first().focus();
        } else {
          $item.parent('li').next('li').find('a').first().focus();
        }
      } else if (e.keyCode == 40) { //down arrow
        e.preventDefault();
        if ($item.parent('li').find('ul').length > 0) {
          $item.parent('li').find('ul').attr('aria-hidden', 'false').addClass(settings.menuHoverClass).find('a').attr('tabIndex', 0).first().focus();
        }
      } else if (e.keyCode == 13 || e.keyCode == 32) { //enter or space keys
        // If submenu is hidden, open it
        e.preventDefault();
        $item.parent('li').find('ul[aria-hidden=true]').attr('aria-hidden', 'false').addClass(settings.menuHoverClass).find('a').attr('tabIndex', 0).first().focus();
      } else if (e.keyCode == 27) { //escape key
        e.preventDefault();
        $('.' + settings.menuHoverClass).attr('aria-hidden', 'true').removeClass(settings.menuHoverClass).find('a').attr('tabIndex', -1);
      } else { //cycle through the child submenu items based on the first letter
        $item.parent('li').find('ul[aria-hidden=false] a').each(function () {
          if ($item.text().substring(0, 1).toLowerCase() == keyCodeMap[e.keyCode]) {
            $item.focus();
            return false;
          }
        });
      }
    });

    // Now do the keys bind for the submenus links
    var links = $topLevelLinks.parent('li').find('ul').find('a');
    $(links).keydown(function (e) {
      var $item = $(this);

      if (e.keyCode == 38) { //up arrow
        e.preventDefault();
        // This is the first item
        if ($item.parent('li').prev('li').length == 0) {
          $item.parents('ul').parents('li').find('a').first().focus();
        } else {
          $item.parent('li').prev('li').find('a').first().focus();
        }
      } else if (e.keyCode == 40) { //down arrow
        e.preventDefault();
        if ($item.parent('li').next('li').length == 0) {
          $item.parents('ul').parents('li').find('a').first().focus();
        } else {
          $item.parent('li').next('li').find('a').first().focus();
        }
      } else if (e.keyCode == 27 || e.keyCode == 37) { //escape key or left arrow => jump to the upper level links
        e.preventDefault();
        $item.parents('ul').first().parent('.sub-menu-wrapper').prev('a').focus().parents('ul').first().find('.' + settings.menuHoverClass).attr('aria-hidden', 'true').removeClass(settings.menuHoverClass).find('a').attr('tabIndex', -1);

        $item.parents('ul').first().closest('li').removeClass(settings.topMenuHoverClass);
      } else if (e.keyCode == 32) { //space key
        e.preventDefault();
        window.location = $item.attr('href');
      } else {

        //cycle through the menu items based on the first letter
        var found = false;
        $item.parent('li').nextAll('li').find('a').each(function () {
          if ($item.text().substring(0, 1).toLowerCase() == keyCodeMap[e.keyCode]) {
            $item.focus();
            found = true;
            return false;
          }
        });

        if (!found) {
          $item.parent('li').prevAll('li').find('a').each(function () {
            if ($item.text().substring(0, 1).toLowerCase() == keyCodeMap[e.keyCode]) {
              $item.focus();
              return false;
            }
          });
        }
      }
    });


    // Hide menu if click or focus occurs outside of navigation
    $nav.find('a').last().keydown(function (e) {
      if (e.keyCode == 9) { //tab key
        // If the user tabs out of the navigation hide all menus
        hideSubMenus();
      }
    });

    //close all menus when pressing ESC key
    $(document).keydown(function (e) {
      if (e.keyCode == 27) { //esc key
        hideSubMenus();
      }
    });

    //close all menus on click outside
    $(document).click(function () {
      hideSubMenus();
    });

    $nav.click(function (e) {
      e.stopPropagation();
    });

    function showSubMenu($item) {

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

      $item.addClass(settings.topMenuHoverClass);

      $item.children('.sub-menu-wrapper').first().find('ul').first() //affect only the first ul found - the one with the submenus, ignore the mega menu items
      .attr('aria-hidden', 'false').addClass(settings.menuHoverClass).find('a').attr('tabIndex', 0); //set the tabIndex to 0 so we let the browser figure out the tab order
    }

    function hideSubMenu($item) {

      if ($item.hasClass('menu-item--mega')) {
        $item.children('.sub-menu-wrapper').css('left', '');
      }

      $item.children('a').first().attr('aria-hidden', 'true').removeClass(settings.menuHoverClass).find('a').attr('tabIndex', -1);

      $item.removeClass(settings.topMenuHoverClass);
    }

    function hideSubMenus() {

      $('.' + settings.menuHoverClass).attr('aria-hidden', 'true').removeClass(settings.menuHoverClass).find('a').attr('tabIndex', -1);

      $('.' + settings.topMenuHoverClass).removeClass(settings.topMenuHoverClass);

    }
  }

})(jQuery);
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
}());
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
        $sidebar = $('.sidebar--main'),
        $blocks = $container.children().addClass('post--animated  post--loaded'),
        initialized = false,
        containerTop, sidebarTop,
        
        init = function () {

        if ($container.length) {
          containerTop = $container.offset().top;
        }

        if ($sidebar.length) {
          sidebarTop = $sidebar.offset().top;
        }

        $container.imagesLoaded(function () {
          $container.masonry({
            isAnimated: false,
            itemSelector: '.grid__item',
            hiddenStyle: {
              opacity: 0
            }
          });

          if (sidebarMasonry()) {
            $sidebar.masonry({
              isAnimated: false,
              itemSelector: '.grid__item',
              hiddenStyle: {
                opacity: 0
              }
            });
          }

          bindEvents();
          showBlocks($blocks);
          initialized = true;
          refresh();
        });
        },
        
        
        sidebarMasonry = function () {
        return $sidebar.length && sidebarTop > containerTop;
        },
        
        
        bindEvents = function () {
        $window.on('debouncedresize', refresh);
        $body.on('post-load', onLoad);
        },
        
        
        refresh = function () {

        if (!initialized) {
          return;
        }

        $container.masonry('layout');
        if (sidebarMasonry()) {
          $sidebar.masonry('layout');
        }
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

    var $nav = $('.nav--main'),
        
        
        init = function () {
        // initialize the logic behind the main navigation
        $nav.ariaNavigation();

        //make sure that the links in the floating-nav, that shows on scroll, are ignored by TAB
        $('.floating-nav').find('a').attr('tabIndex', -1);
        },
        
        
        toggleTopBar = function () {
        var navBottom = $nav.offset().top + $nav.outerHeight();

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
        sidebarBottom, mainOffset, sidebarOffset, sidebarHeight,
        
        previousTop = 0,
        animating = false,
        
        
        initialized = false,
        
        
        
        /**
         * initialize sidebar positioning
         */
        
        init = function () {
        refresh();
        initialized = true;
        },
        
        
        
        /**
         * update position of the two sidebars depending on scroll position
         */
        
        update = function () {

        if (!initialized) {
          init();
        }

        var windowBottom = latestKnownScrollY + windowHeight,
            sidebarBottom = sidebarHeight + sidebarOffset.top + sidebarPadding,
            mainBottom = mainHeight + sidebarOffset.top + sidebarPadding,
            newTop;

        if (mainOffset.top != sidebarOffset.top || animating) {
          return;
        }

        /* adjust right sidebar positioning if needed */
        if (sidebarHeight < mainHeight) {

          // pin sidebar
          if (windowBottom > sidebarBottom && !sidebarPinned) {
            $sidebar.css({
              position: 'fixed',
              top: windowHeight - sidebarHeight - sidebarPadding,
              left: sidebarOffset.left
            });
            sidebarPinned = true;
          }

          // unpin sidebar
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

        if ($main.length) {
          mainOffset = $main.offset();
        }

        if ($sidebar.length) {

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
        }

        if ($smallSidebar.length) {
          smallSidebarPinned = false;
          smallSidebarOffset = $smallSidebar.offset();
          smallSidebarHeight = $smallSidebar.outerHeight();
        }


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
            slideshow: false,
            //no autostart slideshow for accessibility purposes
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

  $(document).ready(function () {
    init();
  });

  function init() {
    browserSize();
    platformDetect();
    masonry.init();
    navigation.init();
    styleArchiveWidget();
    wrapJetpackAfterContent();
  }

  /* ====== ON WINDOW LOAD ====== */

  $window.load(function () {
    browserSize();
    slider.init();
    fixedSidebars.init();
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

  function is_touch() {
    return $.support.touch;
  } /* ====== HELPER FUNCTIONS ====== */



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

    if ($.support.touch) {
      return;
    }

    var archiveWidget = $('.sidebar--main .widget_archive ul').parent(),
        separatorMarkup = '<span class="separator  separator--text" role="presentation"><span>More</span></a>';

    archiveWidget.addClass('shrink');
    archiveWidget.append(separatorMarkup);
    fixedSidebars.refresh();
    masonry.refresh();

    archiveWidget.find('a').focus(function () {
      archiveWidget.removeClass('shrink');
    });
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