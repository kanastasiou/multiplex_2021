var topBarHeight = 10;
var width1 = 0;
var dec=0;
var elTop;
(function($, window, document, undefined) {
    'use strict';

    var elSelector = '.site-header',
        $element = $(elSelector);

    if (!$element.length) return true;
    if ($('.top-widgets').length > 0) {
        if ($('.admin-bar').length)
        {
            topBarHeight=90;
        }
    }
    var elHeight = 0,
        $document = $(document),
        dHeight = 0,
        $window = $(window),
        wHeight = 0,
        wScrollCurrent = 0,
        wScrollBefore = 0,
        wScrollDiff = 0;


    function check_scroll()
    {
           elTop = topBarHeight,
        elHeight = $element.outerHeight();
        dHeight = $document.height();
        wHeight = $window.height();
        wScrollCurrent = $window.scrollTop();
        wScrollDiff = wScrollBefore - wScrollCurrent;
        elTop = parseInt($element.css('top')) + wScrollDiff;

        if (wScrollCurrent <= 0) { // scrolled to the very top; element sticks to the top
            $element.animate({top:topBarHeight}, 300);


            if ($element.hasClass('sticky')) {
                $element.removeClass('sticky');
            }
        } else if (wScrollDiff > 0) { // scrolled up; element slides in
            $element.css('top', elTop > 0 ? 0 : elTop);
            if (!($element.hasClass('sticky'))) {
                $element.addClass('sticky');
            }
        } else if (wScrollDiff < 0) // scrolled down
        {
            if (wScrollCurrent + wHeight >= dHeight - elHeight) // scrolled to the very bottom; element slides in
                $element.css('top', (elTop = wScrollCurrent + wHeight - dHeight) < 0 ? elTop : 0);

            else // scrolled down; element slides out
                $element.css('top', Math.abs(elTop) > elHeight ? -elHeight : elTop);
        }

        wScrollBefore = wScrollCurrent;
    }


    $window.on('scroll', function() {
        check_scroll();
    });


    $document.ready(function() {
        check_scroll();
    });



})(jQuery, window, document);




(function($) {

    /*home page slider slick*/
    var lastScrollTop = 0;
    var blocked = 0;
    post = 0;
    $(document).ready(function() {


        $('body').animate({opacity:1},750);

        var slides_all = $('.dsc_slide').length;


        $(window).resize(function() {
            setTimeout(myresize(),100);

        });

        setTimeout(myresize(),100);
        Barba.Dispatcher.on('newPageReady', function () {
            width1=0;
            myresize();
        });

    });



    function dsc_isScrolledIntoView(elem) {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();

        var elemTop = $(elem).offset().top;
        var elemBottom = elemTop + $(elem).height();

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }

    function myresize() {
        var widthh = viewport().width;
        if (widthh !=width1)
        {
        if (widthh<768)
        {
            if (dec==0)
            {
            topBarHeight-=10;
            dec=1;
            width1=widthh;
            }

        }
        else
        {
            if (dec==1)
            {
               topBarHeight+=10;
               dec=0;
            }
        }

        if ($('#masthead').css('top')=='10px' || $('#masthead').css('top')=='70px')
            {
                if (width1!=0)
                {
                  $('#masthead').animate({top:topBarHeight}, 100);
                }
            }
        width1=widthh;
    }
}


    function disableScrolling() {
        var x = window.scrollX;
        var y = window.scrollY;
        window.onscroll = function() { window.scrollTo(x, y); };
    }

    function enableScrolling() {
        window.onscroll = function() {};
    }
})(jQuery);


function openNav() {
    document.getElementById("site-navigation-mobile").style.width = "100%";
}

/* Close/hide the sidenav */
function closeNav() {
    document.getElementById("site-navigation-mobile").style.width = "0";
}




function viewport() {
    var e = window, a = 'inner';
    if (!('innerWidth' in window )) {
        a = 'client';
        e = document.documentElement || document.body;
    }
    return { width : e[ a+'Width' ] , height : e[ a+'Height' ] };
}




