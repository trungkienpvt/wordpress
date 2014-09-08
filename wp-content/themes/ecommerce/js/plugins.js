/**
 * @name Site
 * @description Define global variables and functions
 * @version 1.0
 */
var Site = (function($, window, undefined) {
  var privateVar = 1;
  function init(){
    $('.scroll-container').smScroll({
      scrollContent: '.scroll-cont',
      vScroller: '.dragger',
      upButton: '.btn-up',
      downButton: '.btn-down',
      textSelect: true,

      contentEase: 'easeOutCirc',
      contentEaseDuration: 1000,
      scrollerEase: 'easeOutCirc',
      scrollerEaseDuration: 1000
    });
    $('.nav-menu').subMenu();
    $('.media-page').infiniteScroll({
      inner: '> ul:last',
      callback: function(){
        regulatory();
      }
    });
  }
  function setClassTable(){
    var tables = $('.table-1');
    tables.each(function(){
      $(this).find('tbody tr:odd').addClass('odd');
      $(this).find('tbody tr:even').addClass('even');
    });
  }
  function regulatory(){
    var popup = $('.popup-1');
    popup.smLayer({
      position: 'center',
      animation: true,
      autoOpen: false,
      removeOnClose: false,
      closeButtons: '.close',
      overlay: 'sm-overlay',
      duration: 400,
      easing: 'linear',
      zIndex: 1002
    });
    $('.show-popup').unbind('click.showpopup').bind('click.showpopup', function(e){
      var urlLink = $(this).attr('href');
      e.preventDefault();
      Site.openLoading();
      $.ajax({
        'url': urlLink,
        success: function (res) {
          var content = popup.find('.content');
          content.html(res);
          Site.closeLoading();
          popup.smLayer('open');
        }
      });
    });
  }
  function fagAjax() {
    var fund = $('.fund-request'),
        fundLi = fund.find('ul li');
    fundLi.bind('click', function (e) {
      //alert($(this).html());
      e.preventDefault();
        var el = $(this);
        var urlLink = el.find('a').attr('href');
        fundLi.find('a').removeClass('active');
        el.find('a').addClass('active');
        Site.openLoading();
        $.ajax({
          url : urlLink,
          success: function (res) {
           // data = jQuery.parseJSON(res);
            $('.replies-list').html('');

            $('.replies-list').append(res);
            Site.closeLoading();
            $('.scroll-container').smScroll('refresh');
          }
        });
    });
  }
  function readmoreAjax(){
    var content = $('#content'),
        btnReadmore = content.find('.btn'),
        contentMore = $('#content-more'),
        container = content.parent();
    btnReadmore.unbind('click.readmore').bind('click.readmore', function(e){
      e.preventDefault();
      var urlLink = $(this).attr('href');
      Site.openLoading();
        $.ajax({
          url : urlLink,
          success: function (res) {
            contentMore.html(res);
            Site.closeLoading();
            container.animate({
              'margin-left': -960
            },300);
            contentMore.find('.btn').unbind('click.back').bind('click.back', function(e){
              e.preventDefault();
              container.animate({
                'margin-left': 0
              },300, function(){
                contentMore.empty();
              });
            });
            regulatory();
            $('#content-more').infiniteScroll({
              'inner': '.block-red > .list-thumb > ul',
              'callback': function(){
                regulatory();
              }
            });
          }
        });
    });
  }
  function scrollPage(){
    var target = $('#footer .inner');
    $(window).unbind('scroll.toogle').bind('scroll.toogle', function(){
      if($(window).scrollTop() + $(window).height() >= $(document).height()){
        if(target.is(':hidden')){
          setTimeout(function(){
            target.slideDown({
              duration: 500
            });
            $('html, body').animate({
              'scrollTop': 50000
            },300);
          },200);
        }
      }
    });
  }
  function openLoading() {
    var wS = $(window).width();
    var hS = $(window).height();
    overlay = $('<div class="overlay"></div>');
    overlay.css({
      'position': 'fixed',
      'width': wS,
      'height': hS,
      'backgroundColor': 'white',
      'opacity': '0',
      'display': 'none',
      'top': 0,
      'left': 0,
      'z-index': 9999999
    });
    $('body').append(overlay);
    divLoading = $('<div>');
    divLoading.css({
      'height': '32',
      'width': '32',
      'display': 'none',
      'zIndex': '9999',
      'top': '40%',
      'left': '50%',
      'position': 'fixed'
    });
    $('body').append(divLoading);
    overlay.fadeIn();
    divLoading.html("<img src='/wp-content/themes/vinaland/images/loading.gif'/>").fadeIn();
  }
  function closeLoading() {
    overlay.fadeOut().remove();
    divLoading.fadeOut().remove();
  }

  function privateMethod1() {
    // todo
  }
  return {
    publicVar: 1,
    publicObj: {
      var1: 1,
      var2: 2
    },
    init: init,
    fagAjax: fagAjax,
    scrollPage: scrollPage,
    readmoreAjax: readmoreAjax,
    regulatory: regulatory,
    setClassTable: setClassTable,
    publicMethod1: privateMethod1,
    openLoading: openLoading,
    closeLoading: closeLoading
  };

})(jQuery, window);

jQuery(function() {

  // Firefox
  if(navigator.userAgent.indexOf('Firefox') > 0){
    $('html').addClass('ff');
  }
  // IE
  else if(navigator.userAgent.indexOf('MSIE') > 0){
    $('html').addClass('ie');
  }
  else if(navigator.userAgent.indexOf('Chrome') > 0){
    $('html').addClass('chrome');
  }
  else if(navigator.userAgent.indexOf('Safari') > 0){
    $('html').addClass('safari');
  }

  Site.init();
  Site.fagAjax();
  Site.regulatory();
  Site.scrollPage();
  Site.readmoreAjax();
  Site.setClassTable();
  Site.publicMethod1();

});

/**
 * @name smScroll
 * @description description
 * @version 1.0
 * @options
 *    scrollType
    scrollContent
    contentContainer
    ulContent

    upButton
    downButton
    vScroller
    prevButton
    nextButton
    hScroller

    autoHide
    textSelect
    clickToScroll
    scrollerAutoHeight

    scrollerGenerate
    vSrollbarClass
    vScrollerClass
    hSrollbarClass
    hScrollerClass

    iScrollTouch
    friction
    touchDelay
    iscrollInterval

    wheelStep
    keydownStep
    holdDelay:
    holdInterval
    hideScrollTime

    contentEase:
    contentEaseDuration
    scrollerEase
    scrollerEaseDuration
 * @events
    onScroll
 * @methods
 *    init
 *    scroll
 *    hScroll
 *    refresh
 *    destroy
 */

;(function($, window, undefined){
  var pluginName = 'smScroll';
  var userAgent = navigator.userAgent;
  var isIOS = userAgent.match(/iPad/i) || userAgent.match(/iPhone/i);
  var touchable = isIOS || ('ontouchstart' in document.documentElement);

  function Plugin(element, options){
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, options);
    this.vars = {};
    this.nameSpace = '.' + pluginName + Math.round(Math.random() * 1000).toString();

    if(/vertical|both/i.test(this.options.scrollType)){
      this.upButton = this.element.find(this.options.upButton);
      this.downButton = this.element.find(this.options.downButton);
      if(this.options.scrollerGenerate){
        var vScrollerContainer = $('<div class="' + this.options.vSrollbarClass + '"><a class="' + this.options.vScrollerClass + '">&nbsp;</a></div>').appendTo(this.element);
        this.vScroller = vScrollerContainer.children();
      }else{
        this.vScroller = this.element.find(this.options.vScroller);
      }
      this.vertical = true;
    }
    if(/horizontal|both/i.test(this.options.scrollType)){
      this.prevButton = this.element.find(this.options.prevButton);
      this.nextButton = this.element.find(this.options.nextButton);
      if(this.options.scrollerGenerate){
        var hScrollerContainer = $('<div class="' + this.options.hSrollbarClass + '"><a class="' + this.options.hScrollerClass + '">&nbsp;</a></div>').appendTo(this.element);
        this.hScroller = hScrollerContainer.children();
      }else{
        this.hScroller = this.element.find(this.options.hScroller);
      }
      this.horizontal = true;
    }

    this.refresh();
    this.init();
  }

  Plugin.prototype = {
    init: function(){
      var thisObj = this;
      var vars = thisObj.vars;

      var vTouching = false;
      var hTouching = false;
      var vTouch = false;
      var hTouch = false;
      var prevContentTop = 0;
      var prevContentLeft = 0;
      var isIscroll = thisObj.options.iScrollTouch;

      vars.vDragging = false;
      vars.hDragging = false;
      vars.startX = 0;
      vars.startY = 0;
      vars.prevScrollerTop = 0;
      vars.prevScrollerLeft = 0;

      vars.curScrollerTop = 0;
      vars.curContentTop = 0;
      vars.curScrollerLeft = 0;
      vars.curContentLeft = 0;

      vars.yDirection = 1;
      vars.xDirection = 1;
      vars.movedY = 0;
      vars.movedX = 0;
      this.inited = true;

      this.element.bind('mouseenter' + this.nameSpace, function(){
        $.fn[pluginName].curSMScroll = thisObj;
      }).bind('mouseleave' + this.nameSpace, function(){
        $.fn[pluginName].curSMScroll = null;
      });

      this.vScroller && this.vScroller.bind('mousedown' + this.nameSpace, function(e){
        e.preventDefault();
        vars.vDragging = true;
        vars.startY = e.pageY;
        vars.prevScrollerTop = vars.curScrollerTop;
        $.fn[pluginName].draggingSMScroll = thisObj;
      });

      this.hScroller && this.hScroller.bind('mousedown' + this.nameSpace, function(e){
        e.preventDefault();
        vars.hDragging = true;
        vars.startX = e.pageX;
        vars.prevScrollerLeft = vars.curScrollerLeft;
        $.fn[pluginName].draggingSMScroll = thisObj;
      });

      if(!$(document).data('smScrollEvent')){
        $(document).data('smScrollEvent', true);
        $(document).bind('mousemove.' + pluginName, function(e){
          e.preventDefault();
          var curScroll = $.fn[pluginName].draggingSMScroll;
          if(!curScroll){
            return;
          }
          if(curScroll.vars.vDragging){
            curScroll.vars.curContentTop = -(curScroll.vars.prevScrollerTop + e.pageY - curScroll.vars.startY) / curScroll.vars.maxScrollerTop * curScroll.vars.maxContentTop;
            curScroll.vScroll(curScroll.vars.curContentTop);
          }
          if(curScroll.vars.hDragging){
            curScroll.vars.curContentLeft = -(curScroll.vars.prevScrollerLeft + e.pageX - curScroll.vars.startX) / curScroll.vars.maxScrollerLeft * curScroll.vars.maxContentLeft;
            curScroll.hScroll(curScroll.vars.curContentLeft);
          }
        }).bind('mouseup.' + pluginName, function(e){
          var curScroll = $.fn[pluginName].draggingSMScroll;
          if(!curScroll){
            return;
          }

          curScroll.vars.vDragging = false;
          curScroll.vars.hDragging = false;

          clearInterval(curScroll.vars.holdInterval);
          clearTimeout(curScroll.vars.waitHoldTimeout);

          if(curScroll.options.textSelect){
            clearTimeout(curScroll.vars.textSelectTimeout);
          }
          $.fn[pluginName].draggingSMScroll = null;
        }).bind('keydown.' + pluginName, function(e){
          var curScroll = $.fn[pluginName].curSMScroll;
          if(curScroll === null || curScroll.vars.disable){
            return;
          }
          if(curScroll.vertical){
            if(e.which === 38){
              e.preventDefault();
              curScroll.vars.curContentTop += curScroll.options.keydownStep;
              curScroll.vScroll(curScroll.vars.curContentTop);
            }
            if(e.which === 40){
              e.preventDefault();
              curScroll.vars.curContentTop -= curScroll.options.keydownStep;
              curScroll.vScroll(curScroll.vars.curContentTop);
            }
          }
          if(curScroll.horizontal){
            if(e.which === 37){
              e.preventDefault();
              curScroll.vars.curContentLeft += curScroll.options.keydownStep;
              curScroll.hScroll(curScroll.vars.curContentLeft);
            }
            if(e.which === 39){
              e.preventDefault();
              curScroll.vars.curContentLeft -= curScroll.options.keydownStep;
              curScroll.hScroll(curScroll.vars.curContentLeft);
            }
          }
        });
      }

      this.contentContainer.bind('mousewheel' + this.nameSpace, function(e, delta){
        if(!vars.disable){
          e.preventDefault();
          if(thisObj.vertical){
            vars.curContentTop += delta * thisObj.options.wheelStep;
            thisObj.vScroll(vars.curContentTop);
          }
          if(thisObj.options.scrollType === 'horizontal'){
            vars.curContentLeft += delta * thisObj.options.wheelStep;
            thisObj.hScroll(vars.curContentLeft);
          }
        }
      });

      if(thisObj.vertical){
        thisObj.vScrollBar.bind('mousewheel' + this.nameSpace, function(e, delta){
          if(!vars.disable){
            e.preventDefault();
            vars.curContentTop += delta * thisObj.options.wheelStep;
            thisObj.vScroll(vars.curContentTop);
          }
        });

        this.upButton.bind('mousedown' + this.nameSpace, function(e){
          e.preventDefault();
          $.fn[pluginName].draggingSMScroll = thisObj;
          thisObj.vScroll(vars.curContentTop + thisObj.options.keydownStep);
          clearTimeout(vars.waitHoldTimeout);
          vars.waitHoldTimeout = setTimeout(function(){
            vars.holdInterval = setInterval(function(){
              if(vars.curContentTop >= 0){
                clearInterval(vars.holdInterval);
              }else{
                thisObj.vScroll(vars.curContentTop + thisObj.options.keydownStep);
              }
            }, thisObj.options.holdInterval);
          }, thisObj.options.holdDelay);
        });

        this.downButton.bind('mousedown' + this.nameSpace, function(e){
          e.preventDefault();
          $.fn[pluginName].draggingSMScroll = thisObj;
          thisObj.vScroll(vars.curContentTop - thisObj.options.keydownStep);
          clearTimeout(vars.waitHoldTimeout);
          vars.waitHoldTimeout = setTimeout(function(){
            vars.holdInterval = setInterval(function(){
              if(vars.curContentTop <= -vars.maxContentTop){
                clearInterval(vars.holdInterval);
              }else{
                thisObj.vScroll(vars.curContentTop - thisObj.options.keydownStep);
              }
            }, thisObj.options.holdInterval);
          }, thisObj.options.holdDelay);
        });
      }

      if(thisObj.horizontal){
        thisObj.hScrollBar.bind('mousewheel' + this.nameSpace, function(e, delta){
          if(!vars.disable){
            e.preventDefault();
            vars.curContentLeft += delta * thisObj.options.wheelStep;
            thisObj.hScroll(vars.curContentLeft);
          }
        });
        this.prevButton.bind('mousedown' + this.nameSpace, function(e){
          e.preventDefault();
          $.fn[pluginName].draggingSMScroll = thisObj;
          thisObj.hScroll(vars.curContentLeft + thisObj.options.keydownStep);
          clearTimeout(vars.waitHoldTimeout);
          vars.waitHoldTimeout = setTimeout(function(){
            vars.holdInterval = setInterval(function(){
              if(vars.curContentLeft >= 0){
                clearInterval(vars.holdInterval);
              }else{
                thisObj.hScroll(vars.curContentLeft + thisObj.options.keydownStep);
              }
            }, thisObj.options.holdInterval);
          }, thisObj.options.holdDelay);
        });

        this.nextButton.bind('mousedown' + this.nameSpace, function(e){
          e.preventDefault();
          $.fn[pluginName].draggingSMScroll = thisObj;
          thisObj.hScroll(vars.curContentLeft - thisObj.options.keydownStep);
          clearTimeout(vars.waitHoldTimeout);
          vars.waitHoldTimeout = setTimeout(function(){
            vars.holdInterval = setInterval(function(){
              if(vars.curContentLeft <= -vars.maxContentLeft){
                clearInterval(vars.holdInterval);
              }else{
                thisObj.hScroll(vars.curContentLeft - thisObj.options.keydownStep);
              }
            }, thisObj.options.holdInterval);
          }, thisObj.options.holdDelay);
        });
      }

      if(thisObj.options.textSelect){
        var xPadding = 50,
        yPadding = 100,
        maxXVal = 10,
        maxYVal = 10;

        var centerX = 0;
        var centerY = 0;

        var viewportLeft = thisObj.contentContainer.offset().left;
        var viewportWidth = thisObj.contentContainer.width();
        var viewportTop = thisObj.contentContainer.offset().top;
        var viewportHeight = thisObj.contentContainer.height();

        vars.textSelect = false;
        var selectSpeedX = 0;
        var selectSpeedY = 0;
        vars.textSelectTimeout = null;

        var selectScroll = function(){
          if(thisObj.vertical && thisObj.horizontal){
            if(Math.abs(selectSpeedY) > Math.abs(selectSpeedX)){
              selectSpeedY !== 0 && thisObj.vScroll(vars.curContentTop - selectSpeedY);
            }else{
              selectSpeedX !== 0 && thisObj.hScroll(vars.curContentLeft - selectSpeedX);
            }
          }else{
            if(thisObj.vertical){
              selectSpeedY !== 0 && thisObj.vScroll(vars.curContentTop - selectSpeedY);
            }
            if(thisObj.horizontal){
              selectSpeedX !== 0 && thisObj.hScroll(vars.curContentLeft - selectSpeedX);
            }
          }
          vars.textSelectTimeout = setTimeout(function(){
            selectScroll();
          }, thisObj.options.holdInterval);
        };

        centerX = viewportWidth / 2 - xPadding;
        centerY = viewportHeight / 2 - yPadding;

        thisObj.contentContainer.bind('mousemove' + this.nameSpace, function(e){
          var speedX = 0;
          var curX = e.pageX - viewportLeft - viewportWidth / 2;
          var signX = (curX > 0)?1:-1;
          curX = Math.abs(curX) - centerX;
          if(curX > 0){
            speedX = signX * curX * maxXVal / xPadding;
          }

          var speedY = 0;
          var curY = e.pageY - viewportTop - viewportHeight / 2;
          var signY = (curY > 0)?1:-1;
          curY = Math.abs(curY) - centerY;
          if(curY > 0){
            speedY = signY * curY * maxYVal / yPadding;
          }
          if(vars.textSelect){
            selectSpeedX = speedX;
            selectSpeedY = speedY;
          }
        });

        this.contentContainer.bind('mousedown' + this.nameSpace, function(e){
          $.fn[pluginName].draggingSMScroll = thisObj;
          clearTimeout(vars.textSelectTimeout);
          vars.textSelect = true;
          selectSpeedX = 0;
          selectSpeedY = 0;
          selectScroll();
        });
      }

      if(thisObj.options.clickToScroll){
        if(thisObj.vertical){
          thisObj.vScrollBar.bind('mousedown' + thisObj.nameSpace, function(e){
            if(e.target.tagName.toLowerCase() === 'a'){
              return;
            }
            var scrollTarget = (thisObj.vScrollBar.offset().top - e.pageY) * vars.maxContentTop / vars.maxScrollerTop;
            var sign = (scrollTarget < vars.curContentTop)?-1:1;
            $.fn[pluginName].draggingSMScroll = thisObj;
            vars.holdInterval = setInterval(function(){
              if(sign < 0){
                if(vars.curContentTop <= scrollTarget){
                  clearInterval(vars.holdInterval);
                }else{
                  thisObj.vScroll(Math.max(vars.curContentTop + sign * thisObj.options.keydownStep, scrollTarget));
                }
              }
              if(sign > 0){
                if(vars.curContentTop >= scrollTarget){
                  clearInterval(vars.holdInterval);
                }else{
                  thisObj.vScroll(Math.min(vars.curContentTop + sign * thisObj.options.keydownStep, scrollTarget));
                }
              }
            }, thisObj.options.holdInterval);
          });
        }
        if(thisObj.horizontal){
          thisObj.hScrollBar.bind('mousedown' + thisObj.nameSpace, function(e){
            if(e.target.tagName.toLowerCase() === 'a'){
              return;
            }

            var scrollTarget = (thisObj.hScrollBar.offset().left - e.pageX) * vars.maxContentLeft / vars.maxScrollerLeft;
            var sign = (scrollTarget < vars.curContentLeft)?-1:1;
            $.fn[pluginName].draggingSMScroll = thisObj;
            vars.holdInterval = setInterval(function(){
              if(sign < 0){
                if(vars.curContentLeft <= scrollTarget){
                  clearInterval(vars.holdInterval);
                }else{
                  thisObj.hScroll(Math.max(vars.curContentLeft + sign * thisObj.options.keydownStep, scrollTarget));
                }
              }
              if(sign > 0){
                if(vars.curContentLeft >= scrollTarget){
                  clearInterval(vars.holdInterval);
                }else{
                  thisObj.hScroll(Math.min(vars.curContentLeft + sign * thisObj.options.keydownStep, scrollTarget));
                }
              }
            }, thisObj.options.holdInterval);
          });
        }
      }

      var startIscroll = function(dir){
        clearTimeout(vars.runMoreTimeout);
        vars.startTime = (new Date()).getTime();
        if(dir === 'y'){
          vars.moveY = vars.startY;
          vars.yMoving = true;
        }
        if(dir === 'x'){
          vars.moveX = vars.startX;
          vars.xMoving = true;
        }
      };

      var vMovingIscroll = function(e){
        if(vars.yDirection * (e.touches[0].pageY - vars.moveY) < 0){
          vars.yDirection *= -1;

          vars.startY = e.touches[0].pageY;
          vars.curContentTop += vars.movedY;
          vars.startTime = (new Date()).getTime();
        }
        vars.moveY = e.touches[0].pageY;

        vars.movedY = e.touches[0].pageY - vars.startY;

        thisObj.vScroll(vars.curContentTop + vars.movedY, {
          temp: true,
          contentEaseDuration: 0,
          contentEase: 'linear',
          scrollerEaseDuration: 0,
          scrollerEase: 'linear'
        });
        clearTimeout(vars.yScrollTimeout);
        vars.yScrollMore = true;
        vars.yScrollTimeout = setTimeout(function(){
          vars.yScrollMore = false;
        }, thisObj.options.touchDelay);
      };
      var hMovingIscroll = function(e){
        if(vars.xDirection * (e.touches[0].pageX - vars.moveX) < 0){
          vars.xDirection *= -1;

          vars.startX = e.touches[0].pageX;
          vars.curContentLeft += vars.movedX;
          vars.startTime = (new Date()).getTime();
        }
        vars.moveX = e.touches[0].pageX;

        vars.movedX = e.touches[0].pageX - vars.startX;
        thisObj.hScroll(vars.curContentLeft + vars.movedX, {
          temp: true,
          contentEaseDuration: 0,
          contentEase: 'linear',
          scrollerEaseDuration: 0,
          scrollerEase: 'linear'
        });
        clearTimeout(vars.xScrollTimeout);
        vars.xScrollMore = true;
        vars.xScrollTimeout = setTimeout(function(){
          vars.xScrollMore = false;
        }, thisObj.options.touchDelay);
      };
      var vRun = function(vt, f){
        if(vt <= 0 || vars.curContentTop >= 0 || vars.curContentTop <= -vars.maxContentTop){
          return;
        }
        vars.curContentTop += vars.yDirection * vt * thisObj.options.iscrollInterval;

        thisObj.vScroll(vars.curContentTop + vars.movedY, {
          temp: true,
          contentEaseDuration: 0,
          contentEase: 'linear',
          scrollerEaseDuration: 0,
          scrollerEase: 'linear'
        });
        vars.runMoreTimeout = setTimeout(function(){
          vt -= f;
          vRun(vt, f);
        }, thisObj.options.iscrollInterval);
      };
      var vEndIscroll = function(){
        vars.yMoving = false;
        var spendTime = (new Date()).getTime() - vars.startTime;
        var v = vars.movedY / spendTime;
        vars.curContentTop = Math.max(Math.min(0, vars.curContentTop + vars.movedY), -vars.maxContentTop);

        vars.movedY = 0;

        vRun(Math.abs(v), thisObj.options.friction/100 * Math.abs(v));
      };
      var hRun = function(vt, f){
        if(vt <= 0 || vars.curContentLeft >= 0 || vars.curContentLeft <= -vars.maxContentLeft){
          return;
        }
        vars.curContentLeft += vars.xDirection * vt * thisObj.options.iscrollInterval;

        thisObj.hScroll(vars.curContentLeft + vars.movedX, {
          temp: true,
          contentEaseDuration: 0,
          contentEase: 'linear',
          scrollerEaseDuration: 0,
          scrollerEase: 'linear'
        });
        vars.runMoreTimeout = setTimeout(function(){
          vt -= f;
          hRun(vt, f);
        }, thisObj.options.iscrollInterval);
      };
      var hEndIscroll = function(){
        vars.xMoving = false;
        var spendTime = (new Date()).getTime() - vars.startTime;
        var v = vars.movedX / spendTime;
        vars.curContentLeft = Math.max(Math.min(0, vars.curContentLeft + vars.movedX), -vars.maxContentLeft);

        vars.movedX = 0;

        hRun(Math.abs(v), thisObj.options.friction/100 * Math.abs(v));
      };

      this.scrollContent.bind('touchstart' + this.nameSpace, function(){
        event.preventDefault();
        vars.startY = event.touches[0].pageY;
        vars.startX = event.touches[0].pageX;
        if(thisObj.vertical){
          vTouching = true;
          prevContentTop = vars.curContentTop;
          if(isIscroll){
            startIscroll('y');
          }
        }
        if(thisObj.horizontal){
          hTouching = true;
          prevContentLeft = vars.curContentLeft;
          if(isIscroll){
            startIscroll('x');
          }
        }
      });

      $(document).bind('touchmove' + this.nameSpace, function(){
        if(vTouching && hTouching){
          if(!vTouch && !hTouch){
            if(Math.abs(event.touches[0].pageY - vars.startY) > Math.abs(event.touches[0].pageX - vars.startX)){
              vTouch = true;
            }else{
              hTouch = true;
            }
          }
          if(vTouch){
            if(isIscroll && vars.yMoving){
              vMovingIscroll(event);
            }else{
              vars.curContentTop = prevContentTop + event.touches[0].pageY - vars.startY;
              thisObj.vScroll(vars.curContentTop);
            }
          }else{
            if(isIscroll && vars.xMoving){
              hMovingIscroll(event);
            }else{
              vars.curContentLeft = prevContentLeft + event.touches[0].pageX - vars.startX;
              thisObj.hScroll(vars.curContentLeft);
            }
          }
          return;
        }
        else{
          if(vTouching){
            if(isIscroll && vars.yMoving){
              vMovingIscroll(event);
            }else{
              vars.curContentTop = prevContentTop + event.touches[0].pageY - vars.startY;
              thisObj.vScroll(vars.curContentTop);
            }
          }
          if(hTouching){
            if(isIscroll && vars.xMoving){
              hMovingIscroll(event);
            }else{
              vars.curContentLeft = prevContentLeft + event.touches[0].pageX - vars.startX;
              thisObj.hScroll(vars.curContentLeft);
            }
          }
        }
      }).bind('touchend' + this.nameSpace, function(){
        if(isIscroll){
          if(!vTouching || !hTouching){
            vTouch = vTouching;
            hTouch = hTouching;
          }
          if(vTouch){
            if(vars.yScrollMore){
              vEndIscroll();
            }else{
              vars.curContentTop = vars.curTempContentTop;
              vars.curScrollerTop = vars.curTempScrollerTop;
            }
          }
          if(hTouch){
            if(vars.xScrollMore){
              hEndIscroll();
            }else{
              vars.curContentLeft = vars.curTempContentLeft;
              vars.curScrollerLeft = vars.curTempScrollerLeft;
            }
          }
        }

        vTouching = false;
        hTouching = false;
        vTouch = false;
        hTouch = false;
      });
    },
    vScroll: function(contentTop, scrollOptions){
      var thisObj = this;
      var vars = this.vars;
      var contentDuration = '';
      var contentEase = '';
      var scrollerDuration = '';
      var scrollerEase = '';

      vars.curTempContentTop = Math.max(Math.min(0, contentTop), -vars.maxContentTop);
      vars.curTempScrollerTop = -vars.curTempContentTop / vars.maxContentTop * vars.maxScrollerTop;

      if(!scrollOptions || (scrollOptions && !scrollOptions.temp)){
        vars.curContentTop = vars.curTempContentTop;
        vars.curScrollerTop = vars.curTempScrollerTop;
      }

      if(scrollOptions){
        contentDuration = scrollOptions.contentEaseDuration;
        contentEase = scrollOptions.contentEase;
        scrollerDuration = scrollOptions.scrollerEaseDuration;
        scrollerEase = scrollOptions.scrollerEase;
      }else{
        contentDuration = this.options.contentEaseDuration;
        contentEase = this.options.contentEase;
        scrollerDuration = this.options.scrollerEaseDuration;
        scrollerEase = this.options.scrollerEase;
      }

      clearTimeout(vars.hideScroller);

      if(this.options.autoHide){
        thisObj.vScroller.css({
          'opacity': 1,
          'display': ''
        });
      }

      this.scrollContent.stop().animate({
        'margin-top': vars.curTempContentTop
      }, contentDuration, contentEase);

      this.vScroller && this.vScroller.stop().animate({
        'margin-top': vars.curTempScrollerTop
      }, scrollerDuration, scrollerEase, function(){
        if(thisObj.options.autoHide){
          vars.hideScroller = setTimeout(function(){
            thisObj.vScroller.fadeOut();
          }, thisObj.options.hideScrollTime);
        }
      });
      if(thisObj.options.onScroll){
        thisObj.options.onScroll(this.element, {top: vars.curTempContentTop || 0, left: vars.curTempContentLeft || 0});
      }
    },
    hScroll: function(contentLeft, scrollOptions){
      var thisObj = this;
      var vars = this.vars;
      vars.curTempContentLeft = Math.max(Math.min(0, contentLeft), -vars.maxContentLeft);
      vars.curTempScrollerLeft = -vars.curTempContentLeft / vars.maxContentLeft * vars.maxScrollerLeft;

      if(!scrollOptions || (scrollOptions && !scrollOptions.temp)){
        vars.curContentLeft = vars.curTempContentLeft;
        vars.curScrollerLeft = vars.curTempScrollerLeft;
      }

      var contentDuration = this.options.contentEaseDuration;
      var contentEase = this.options.contentEase;
      var scrollerDuration = this.options.scrollerEaseDuration;
      var scrollerEase = this.options.scrollerEase;

      if(scrollOptions){
        contentDuration = scrollOptions.contentEaseDuration;
        contentEase = scrollOptions.contentEase;
        scrollerDuration = scrollOptions.scrollerEaseDuration;
        scrollerEase = scrollOptions.scrollerEase;
      }

      clearTimeout(vars.hideHScroller);
      if(this.options.scrollerAutoHide){
        thisObj.hScroller.css({
          'opacity': 1,
          'display': ''
        });
      }
      this.scrollContent.stop().animate({
        'margin-left': vars.curTempContentLeft
      }, contentDuration, contentEase);
      this.hScroller && this.hScroller.stop().animate({
        'margin-left': vars.curTempScrollerLeft
      }, scrollerDuration, scrollerEase, function(){
        if(thisObj.options.scrollerAutoHide){
          vars.hideHScroller = setTimeout(function(){
            thisObj.hScroller.fadeOut();
          }, thisObj.options.hideScrollTime);
        }
      });
      if(thisObj.options.onScroll){
        thisObj.options.onScroll(thisObj.element, {top: vars.curTempContentTop || 0, left: vars.curTempContentLeft || 0});
      }
    },
    refresh: function(){
      var vars = this.vars;
      var hideElement = function(elem){
        elem.css('visibility', 'hidden');
      },
      showElement = function(elem){
        elem.css('visibility', 'visible');
      };
      vars.disable = false;

      this.scrollContent = $(this.options.scrollContent, this.element);
      this.contentContainer = this.options.contentContainer || this.scrollContent.parent();

      if(this.options.autoHide){
        this.vScroller && this.vScroller.fadeOut();
        this.hScroller && this.hScroller.fadeOut();
      }

      if(this.vertical){
        this.vScrollBar = this.vScroller.parent();
        vars.vScrollBarHeight = this.vScrollBar.innerHeight();
        // vars.contentHeight = this.scrollContent.outerHeight();
        if(!this.options.ulContent){
          vars.contentHeight = this.scrollContent.outerHeight();
        }else{
          vars.contentHeight = this.scrollContent.children().length * this.scrollContent.children().outerHeight(true);
        }
        vars.viewportHeight = this.contentContainer.innerHeight();
        vars.maxContentTop = vars.contentHeight - vars.viewportHeight;

        if(this.options.scrollerAutoHeight){
          this.vScroller && this.vScroller.css({
            height: vars.viewportHeight / vars.contentHeight * vars.vScrollBarHeight
          });
        }
        vars.maxScrollerTop = vars.vScrollBarHeight - this.vScroller.outerHeight();
        if(vars.maxContentTop <= 0){
          vars.maxContentTop = 0;
          this.inited && this.vScroll(0);
          hideElement(this.vScrollBar);
          hideElement(this.upButton);
          hideElement(this.downButton);
          vars.disable = true;
        }
        else{
          this.inited && this.vScroll(vars.curContentTop);
          showElement(this.vScrollBar);
          showElement(this.upButton);
          showElement(this.downButton);
        }
      }

      if(this.horizontal){
        this.hScrollBar = this.hScroller.parent();
        vars.hScrollBarHeight = this.hScroller.parent().innerWidth();
        if(!this.options.ulContent){
          vars.contentWidth = this.scrollContent.outerWidth();
        }else{
          vars.contentWidth = this.scrollContent.children().length * this.scrollContent.children().outerWidth(true);
        }
        vars.viewportWidth = this.contentContainer.innerWidth();
        vars.maxContentLeft = vars.contentWidth - vars.viewportWidth;

        if(this.options.scrollerAutoHeight){
          this.hScroller && this.hScroller.css({
            width: vars.viewportWidth / vars.contentWidth * vars.hScrollBarHeight
          });
        }
        vars.maxScrollerLeft = vars.hScrollBarHeight - this.hScroller.outerWidth();
        if(vars.maxContentLeft <= 0){
          vars.maxContentLeft = 0;
          this.inited && this.hScroll(0);
          hideElement(this.hScrollBar);
          hideElement(this.prevButton);
          hideElement(this.nextButton);
          vars.disable = true;
        }
        else{
          this.inited && this.hScroll(this.curContentLeft);
          showElement(this.hScrollBar);
          showElement(this.prevButton);
          showElement(this.nextButton);
        }
      }
    },
    destroy: function(){
      this.element.removeData(pluginName);
      this.element.unbind(this.nameSpace);
      if(this.vertical){
        this.vScroller && this.vScroller.unbind(this.nameSpace);
        this.upButton.unbind(this.nameSpace);
        this.downButton.unbind(this.nameSpace);
      }
      if(this.hType){
        this.hScroller && this.hScroller.unbind(this.nameSpace);
        this.prevButton.unbind(this.nameSpace);
        this.nextButton.unbind(this.nameSpace);
      }
      $(document).unbind('.' + pluginName).unbind(this.nameSpace);
      $.removeData(this.element[0], pluginName);
    }
  };

  $.fn[pluginName] = function(options, params){
    return this.each(function(){
      var instance = $.data(this, pluginName);
      if(!instance){
        $.data(this, pluginName, new Plugin(this, options));
      }else if(instance[options]){
        if($.isArray(params)){
          instance[options].apply(instance, params);
        }else{
          instance[options](params);
        }
      }else{
        console.warn(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    scrollType: 'vertical',
    scrollContent: '.scroll-cont',
    contentContainer: '',
    ulContent: false,

    upButton: '',
    downButton: '',
    vScroller: '',

    prevButton: '',
    nextButton: '',
    hScroller: '',

    autoHide: false,
    textSelect: false,
    clickToScroll: false,
    scrollerAutoHeight: false,

    scrollerGenerate: false,
    vSrollbarClass: 'v-scrollBar',
    vScrollerClass: 'v-scroller',
    hSrollbarClass: 'h-scrollBar',
    hScrollerClass: 'h-scroller',

    iScrollTouch: false,
    friction: 2,
    touchDelay: 100,
    iscrollInterval: 20,

    wheelStep: 20,
    keydownStep: 10,
    holdDelay: 700,
    holdInterval: 33,
    hideScrollTime: 1000,

    contentEase: 'linear',
    contentEaseDuration: 0,
    scrollerEase: 'linear',
    scrollerEaseDuration: 0,

    onScroll: function(){}
  };
})(jQuery, window);


/**
 *  @name subMenu
 *  @description description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;(function($, window, undefined) {
  var pluginName = 'subMenu';

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this;
        that.handlers = that.element.find('> li'),
        activeHandler = that.handlers.filter('.current_page_item')[0];

        that.handlers.unbind('mouseenter.' + pluginName).bind('mouseenter.' + pluginName, function(){
          var handler = $(this),
              sub = handler.find('.sub-menu');
          handler.addClass('current_page_item');
          sub.slideDown(that.options.duration);
        }).unbind('mouseleave.' + pluginName).bind('mouseleave.' + pluginName, function(){
          var handler = $(this),
              sub = handler.find('.sub-menu');
          sub.stop();
          sub.slideUp(that.options.duration);
          if(activeHandler !== handler[0]){
            handler.removeClass('current_page_item');
          }
        });
    },
    publicMethod: function(params) {

    },
    destroy: function() {
      $.removeData(this.element[0], pluginName);
    }
  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      } else {
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    duration: 200
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));


/**
 * @name smLayer
 * @description jQuery plugin for showing and hidding layer.
 * @options
 *    position
 *    animation
 *    autoOpen
 *    removeOnClose
 *    closeClass
 *    overlay
 *    opacity
 *    duration
 *    easing
 *    zIndex
 * @events
 *    beforeOpen
 *    open
 *    beforeClose
 *    close
 * @methods
 *    init
 *    open
 *    reposition
 *    close
 *    destroy
 *
 **/
;(function($, window, undefined) {
  var pluginName = 'smLayer';
  var document = window.document;
  var $window = $(window);
  
  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
        options = this.options;
      
      if (that.element.find(options.closeButtons).length) {
        that.element.css({
          'display': 'none',
          'zIndex': options.zIndex
        });
        that.element.delegate('.' + options.closeButtons, 'click.' + pluginName, function() {
          that.close();
          return false;
        });
      }

      if (options.repositionOnResize) {
        that.reposition();
      }

      if (options.autoOpen) {
        that.open();
      }
    },
    open: function(callback) {
      if (this.isOpen) {
        return;
      }

      var that = this;
      var options = this.options;
      options.duration = !options.animation ? 0 : options.duration;

      that.reposition();

      if (options.overlay) {
        that.overlay = $('<div>').addClass(options.overlay).css('zIndex', options.zIndex - 1).appendTo('body').fadeOut(0);
        that.overlay.bind('click.' + pluginName, function() {
          that.close();
          return false;
        });
      }

      options.overlay && this.overlay.fadeIn(options.duration, options.easing);

      this.element.fadeIn(options.duration, options.easing, function() {
        $.isFunction(options.open) && options.open.call(that.element);
        $.isFunction(callback) && callback.call(that.element);
        that.isOpen = true;
      });
    },
    reposition: function(pos) {
      var that = this;
      var options = this.options;
      var center = {
        top: Math.max(0, ($window.height() - that.element.outerHeight(true)) / 2),
        left: Math.max(0, ($window.width() - that.element.outerWidth(true)) / 2)
      };
      var position = pos || options.position;
      var left = (options.position !== 'center' && $.isArray(position)) ? position[0] : center.left;
      var top = (options.position !== 'center' && $.isArray(position) && position.length > 1) ? position[1] : center.top;

      that.element.css({
        'top': top,
        'left': left
      });
    },
    close: function(callback) {
      if (!this.isOpen) {
        return;
      }
      var that = this;
      var options = this.options;
      options.duration = !options.animation ? 0 : options.duration;

      options.overlay && this.overlay.fadeOut(options.duration, options.easing, function() {
        $(this).remove();
      });

      this.element.fadeOut(options.duration, options.easing, function() {
        $.isFunction(options.close) && options.close.call(that.element);
        $.isFunction(callback) && callback.call(that.element);
        that.isOpen = false;
      });
    },
    destroy: function() {
      if (this.isOpen) {
        this.close(this.destroy);
      }
      this.overlay.remove();
      if (this.element.find(this.options.closeButtons).length) {
        this.element.undelegate(this.options.closeButtons, 'click.' + pluginName);
      }
      $.removeData(this.element, pluginName);
    }
  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      } else {
        console.warn(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    animation: true,
    autoOpen: true,
    repositionOnResize: true,
    removeOnClose: false,
    closeButtons: 'close',
    overlay: 'sm-overlay',
    position: 'center',
    duration: 400,
    easing: 'linear',
    zIndex: 1000,
    open: function() {},
    close: function() {}
  };
}(jQuery, window));




/**
 *  @name infiniteScroll
 *  @description description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;(function($, window, undefined) {
  var pluginName = 'infiniteScroll';

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this;
      this.isAjaxLoad = false;
      this.inner = this.element.find(that.options.inner);
      $(window).unbind('scroll.infiniteScroll').bind('scroll.infiniteScroll', function(){
        var windowEl = $(this),
            scrollTop = windowEl.scrollTop(),
            contentHeight = $(document).height(),
            windowHeight = windowEl.height();
        if(contentHeight > windowHeight){
          if(contentHeight === scrollTop + windowHeight){
            that.loadNext();
          }
        }
      }).trigger('scroll.infiniteScroll');
    },
    loadNext: function(){
      var that = this;
          alink = that.element.find('.next-page');
      if(alink.length && !that.isAjaxLoad){
        var url = alink.attr('href');
        var timer = new Date().getTime();
        
        $.ajax({
          'url': url,
          'beforeSend': function(){
            that.isAjaxLoad = true;
            that.showLoading();
          },
          'success': function(respone){
            var resultTime = new Date().getTime();
            var timeout = 1000;
            if(resultTime - timer < 1000){
              timeout = 1000 - (resultTime - timer);
            }
            setTimeout(function(){
              that.isAjaxLoad = false;
              alink.remove();
              that.inner.append(respone);
              that.hideLoading();
              $.isFunction(that.options.callback) && that.options.callback.apply();
            }, timeout);

          }
        });
      }
    },
    showLoading: function(){
      var that = this;
          that.loading = that.element.find('.loading-infinite');
      if(!this.loading.length){
        this.loading = $('<img class="loading-infinite" src="/wp-content/themes/vinaland/images/loading.gif"/>').insertAfter(that.inner);
      }else{
        that.loading.show().before(that.inner);
      }
    },
    hideLoading: function(){
      this.loading.hide();
    },
    destroy: function() {
      $.removeData(this.element[0], pluginName);
    }
  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      } else {
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    option: 'value',
    inner: '.block-red > .list-thumb > ul',
    callback: function(){}
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));



/**
 *  @name autoFadeBanner
 *  @description description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;(function($, window, undefined) {
  var pluginName = 'autoFadeBanner';
  var privateVar = null;
  var privateMethod = function() {

  };

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this;
          that.slideshow = that.element.find('.slideshow .preview'),
          that.title = that.element.find('.title span'),
          that.slides = that.slideshow.find('li'),
          that.activeIndex = 0,
          that.length = that.slides.length,
          that.timer = 0,
          change = function (){
            clearTimeout(that.timer);
            that.timer = setTimeout(function(){
              var activeEl = that.slides.eq(that.activeIndex);
              that.slides.eq(that.activeIndex).animate({
                'opacity': 0
              }, 800);
              that.activeIndex ++;
              if(that.activeIndex === that.length){
                that.activeIndex = 0;
              }
              activeEl = that.slides.eq(that.activeIndex);
              activeEl.animate({
                'opacity': 1
              }, 1000);
              that.title.html(activeEl.attr('rel'));
              change();
            },5000);
          };
      that.slides.css('opacity', 0);
      that.slides.eq(that.activeIndex).css('opacity', 1);
      change();
    },
    destroy: function() {
      $.removeData(this.element[0], pluginName);
    }
  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      } else {
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    option: 'value'
  };

  $(function() {
    $('.header-homepage')[pluginName]();
  });

}(jQuery, window));



/**
 *  @name plugin
 *  @description description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;(function($, window, undefined) {
  var pluginName = 'plugin';
  var privateVar = null;
  var privateMethod = function() {

  };

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {

    },
    publicMethod: function(params) {

    },
    destroy: function() {
      $.removeData(this.element[0], pluginName);
    }
  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      } else {
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    option: 'value'
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));