/* ====== HELPER FUNCTIONS ====== */



/**
 * Detect what platform are we on (browser, mobile, etc)
 */

function platformDetect() {
  $.support.touch     = 'ontouchend' in document;
  $.support.svg       = (document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure", "1.1")) ? true : false;
  $.support.transform = getSupportedTransform();

  iOS                 = getIOSVersion(ua);

  $html
    .addClass($.support.touch ? 'touch' : 'no-touch')
    .addClass($.support.svg ? 'svg' : 'no-svg')
    .addClass(!!$.support.transform ? 'transform' : 'no-transform');
}

function getIOSVersion(ua) {
    ua = ua || navigator.userAgent;
    return parseFloat(
        ('' + (/CPU.*OS ([0-9_]{1,5})|(CPU like).*AppleWebKit.*Mobile/i.exec(ua) || [0,''])[1])
            .replace('undefined', '3_2').replace('_', '.').replace('_', '')
    ) || false;
}



function browserSize() {
    windowHeight    = $window.height();
    windowWidth     = $window.width();
    documentHeight  = $document.height();
    orientation     = windowWidth >= windowHeight ? 'landscape' : 'portrait';
}



function getSupportedTransform() {
  var prefixes = ['transform', 'WebkitTransform', 'MozTransform', 'OTransform', 'msTransform'];
  for(var i = 0; i < prefixes.length; i++) {
      if(document.createElement('div').style[prefixes[i]] !== undefined) {
          return prefixes[i];
      }
  }
  return false;
}

/**
 * Handler for the back to top button
 */
function scrollToTop() {
  $('a[href="#top"]').click(function(event){
    event.preventDefault();
    event.stopPropagation();

    $('html').velocity("scroll", 1000);
  });
}

/**
 * Infinite scroll behaviour
 */
function infinityHandler() {
  $("#infinite-handle").on("click", function() {
    $('body').addClass('loading-posts');
  });

  $(document.body).on("post-load", function() {
      $('body').removeClass('loading-posts');
  });
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

function is_touch() {
  return $.support.touch;
}