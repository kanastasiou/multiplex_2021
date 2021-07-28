
var swidth = 0;
var initial_width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
var plx_map;
var resizze=0;
var google;
var plx_to_latt, plx_to_lngg, plx_start_latt, plx_start_lngg, plx_pointA, plx_pointB, plx_icon, plx_center, map_style, center;
map_style = [{ "featureType": "administrative", "elementType": "labels.text.fill", "stylers": [{ "color": "#444444" }] }, { "featureType": "landscape", "elementType": "all", "stylers": [{ "color": "#f2f2f2" }] }, { "featureType": "poi", "elementType": "all", "stylers": [{ "visibility": "off" }] }, { "featureType": "road", "elementType": "all", "stylers": [{ "saturation": -100 }, { "lightness": 45 }] }, { "featureType": "road.highway", "elementType": "all", "stylers": [{ "visibility": "simplified" }] }, { "featureType": "road.arterial", "elementType": "labels.icon", "stylers": [{ "visibility": "off" }] }, { "featureType": "transit", "elementType": "all", "stylers": [{ "visibility": "off" }] }, { "featureType": "water", "elementType": "all", "stylers": [{ "color": "#46bcec" }, { "visibility": "on" }] }];
var id;
(function($) {
    "use strict";

    $(document).ready(function() {

        $(document).on('click','#mobile-menu li a',function()
            {
            $('#mobile-menu .closebtn').trigger('click'); 
            closeNav();
            })



        myresize();
        Barba.Dispatcher.on('newPageReady', function () {
            swidth =initial_width=0;

            myresize();
        if ($('.mtv_limit_text').length > 0){
            $('.mtv_limit_text').each(function (index) {
                shave_text(this);
            });
        }
            
        if ($('.mtv_partner_slick').length > 0) {
            setTimeout(function(){ 
                slider_slick('.mtv_partner_slick');
            }, 1000);
        }
        
        if ($('.plx_partner_name').length > 0 ){
            var partner_name = $('.plx_partner_name').text();
            $('input#partner').attr('value', partner_name);
        }

    if (jQuery('.plx_map_container').length > 0) {

        var auto = parseInt(jQuery('.plx_map_container').attr('data-direction'));
        plx_to_latt = jQuery('.plx_map_container').attr('data-lat');
        plx_to_lngg = jQuery('.plx_map_container').attr('data-lon');
        plx_start_latt = jQuery('.plx_map_container').attr('data-target_lat');
        plx_start_lngg = jQuery('.plx_map_container').attr('data-target_lon');
        plx_icon = jQuery('.plx_map_container').attr('data-icon');
        if (auto == 1) {
            plx_initMap(plx_to_latt, plx_to_lngg, plx_start_latt, plx_start_lngg, 1);
        } else {
            plx_initMap(plx_to_latt, plx_to_lngg, plx_start_latt, plx_start_lngg, 0);
        }

        google.maps.event.addDomListener(window, 'resize', function() {
            plx_map.setCenter(center);
        });
    }

    $(function() {
        $('.scroll_4_more a[href*=#]').on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top}, 1200, 'linear');
        });
    });



        $(window).resize(function() {
            clearTimeout(id);
            id = setTimeout(myresize, 500);
        });

    });

    /*initialize barba*/
        Barba.Pjax.start();
        Barba.Prefetch.init();


        var FadeTransition = Barba.BaseTransition.extend({
            start: function () {
                /**
                 * This function is automatically called as soon the Transition starts
                 * this.newContainerLoading is a Promise for the loading of the new container
                 * (Barba.js also comes with an handy Promise polyfill!)
                 */

                // As soon the loading is finished and the old page is faded out, let's fade the new page
                Promise
                    .all([this.newContainerLoading, this.fadeOut()])
                    .then(this.fadeIn.bind(this));
            },

            fadeOut: function () {
                return $(this.oldContainer).animate({ opacity: 0.8},100).promise();
            },

            fadeIn: function () {
                /**
                 * this.newContainer is the HTMLElement of the new Container
                 * At this stage newContainer is on the DOM (inside our #barba-container and with visibility: hidden)
                 * Please note, newContainer is available just after newContainerLoading is resolved!
                 */

                $(window).scrollTop(0);
                var _this = this;
                var $el = $(this.newContainer);

                $(this.oldContainer).hide();

                $el.css({
                    visibility: 'visible',
                    opacity: 0.8
                });

                $el.animate({ opacity: 1}, 200, function () {
                    /**
                     * Do not forget to call .done() as soon your transition is finished!
                     * .done() will automatically remove from the DOM the old Container
                     */

                    _this.done();
                });
            }
        });

        /**
         * Next step, you have to tell Barba to use the new Transition
         */

        Barba.Pjax.getTransition = function () {
            /**
             * Here you can use your own logic!
             * For example you can use different Transition based on the current page or link...
             */

            return FadeTransition;
        };



    });

    function myresize() {
            var current_width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);

            if (initial_width !== current_width) {
                if (current_width<=768)
                {
                    $('a').addClass('no-barba');
                }
                else{
                    $('a.no-barba').removeClass('no-barba');
                }
                if ($('.mtv_limit_text .read_more').length > 0){
                    $('.mtv_limit_text').each(function (index) {
                        $(this).find('.read_more').remove();
                        $(this).addClass('removed');
                    });
                }
                setTimeout(function () {
                            if ($('.mtv_limit_text').length > 0) {
                                $('.mtv_limit_text').each(function (index) {
                                    shave_text(this);
                                });
                            }
                }, 250);
            }
            initial_width = current_width;
        }

    function shave_text(element) {
        var current_width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
        var original_text = $(element).attr('data-original_text');
        var elements = [{
            elem: 'mtv_limit_text',
            minwidth: 1,
            maxwidth: 3000,
            original_text: original_text
        }];


        if (current_width !== swidth) {            
            $.each(elements, function (i, clss) {
                if ($('.' + clss.elem).length) {
                    var cld = '.'+ clss.elem + '.shaved';
                    var clnd = '.'+ clss.elem + ':not(.shaved)';
                    var hh = 80;
                    if ($(cld).length) {                        
                        shave(cld, hh );
                        $(cld).removeClass('shaved');
                    }
                    if (current_width >= clss.minwidth && ((clss.maxwidth > current_width && clss.maxwidth > 0) || clss.maxwidth == 0)) {
                        $(clnd).each(function () {
                            
                          //  if (current_width < 768) {
                            //    hh += 20;
                           // } else {
                                if ($(this).attr('data-height')) {
                                    hh = parseInt($(this).attr('data-height'));
                                }
                           // }
                            //$(this).text(clss.original_text);
                            shave(this, hh, {
                                classname: clss.elem
                            });
                            $(this).addClass('shaved');

                            if($(this).attr('data-link')) {
                                setTimeout(function () {
                                    $('.mtv_limit_text.removed[data-link]').each(function (index) {
                                        $('<a href="' + $(this).attr('data-link') + '" class="read_more">  ' + $(this).attr('data-more_txt') + '</a>').appendTo(this);
                                        $(this).removeClass('removed');

                                    });
                                }, 600);
                            }
                        });
                    }
                }
            });
            swidth = current_width;
        }
    }

    function slider_slick(element) {
        if ($(element).length > 0) {
            var display = $(element).data('display');
            var columns = $(element).data('columns');
            var mcolumns = $(element).data('mcolumns');
            var scolumns = $(element).data('scolumns');
            var total = $(element).data('total');
            var mode = $(element).data('mode');
            var slide_width = $(element).data('slide_width');

            if (!(typeof(slide_width) != "undefined" && slide_width !== null)) {
                slide_width = false;
            }
            if (!(typeof(mode) != "undefined" && mode !== null)) {
                mode = false;
            }
            switch (display) {
                case 'carousel':
                    //alert(columns);
                    $(element).not('.slick-initialized').slick({
                        nextArrow: '<i class="dsc_slick_next fa fa-angle-right slick-left" ></i>',
                        prevArrow: '<i class="dsc_slick_prev fa fa-angle-left slick-right"></i>',
                        //autoplay: true,
                        autoplaySpeed: 3000,
                        // fade: true,
                        slidesToShow: columns,
                        dots: false,
                        speed: 400,
                        infinite: true,
                        swipeToSlide: true,
                        variableWidth: slide_width,
                        centerMode: mode,
                        centerPadding: '30px',
                        responsive: [{
                            breakpoint: 1100,
                            settings: {
                                slidesToShow: mcolumns,
                                slidesToScroll: 1,
                            }
                        }, {
                            breakpoint: 750,
                            settings: {
                                slidesToShow: scolumns,
                                slidesToScroll: 1,
                                dots: true,
                                //centerMode: true
                            }
                        }, {
                            breakpoint: 550,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerMode: true,
                                dots:true
                            }
                        }]
                    });
                    break;
                case 'grid':
                    $(element).not('.slick-initialized').slick({
                        slidesToShow: total,
                        slidesToScroll: 1,
                        zIndex: 100000,
                        centerMode: true,
                        centerPadding: '0px',
                        responsive: [{
                            breakpoint: 767,
                            settings: {
                                nextArrow: '<i class="dsc_slick_next fa fa-angle-right slick-left" ></i>',
                                prevArrow: '<i class="dsc_slick_prev fa fa-angle-left slick-right"></i>',
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            }
                        }]
                    });

                    break;
            }

        }
    }

})(jQuery);


function plx_initMap(to_lat, to_lng, start_lat, start_lng, casee) {
    var s_icon = false;
    resizze=1;
    if (plx_icon != '') {
        s_icon = true;
    }
    pointA = new google.maps.LatLng(start_lat, start_lng),
        pointB = new google.maps.LatLng(to_lat, to_lng),
        myOptions = {
            zoom: 10,
            center: pointA,
            styles: map_style
        },
        plx_map = new google.maps.Map(document.getElementById('plx_map'), myOptions);

    if (casee == 1) {

        plx_directionsService = new google.maps.DirectionsService,
            plx_directionsDisplay = new google.maps.DirectionsRenderer({
                map: plx_map,
                suppressMarkers: s_icon
            });
        plx_calculateAndDisplayRoute(plx_directionsService, plx_directionsDisplay, pointA, pointB);
    } else {
        // Add marker
        var marker = new google.maps.Marker({
            position: pointA,
            title: "0",
            icon: plx_icon,
            styles: map_style
        });
        marker.setMap(plx_map);

    }


}

function plx_calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
    directionsService.route({
        origin: pointA,
        destination: pointB,
        travelMode: google.maps.TravelMode.DRIVING
    }, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
            var leg = response.routes[0].legs[0];
            plx_makeMarker(leg.start_location, plx_icon);
            plx_makeMarker(leg.end_location, '');
        } else {
            var marker = new google.maps.Marker({
                position: pointB,
                map: plx_map
            });
        }
    });
    plx_calculateCenter();
}


function plx_makeMarker(position, iconn) {
    var options = {
        position: position,
        map: plx_map,
        styles: map_style
    }
    if (iconn != '') {
        options.icon = new google.maps.MarkerImage(iconn);
    }
    new google.maps.Marker(options);
}

function plx_calculateCenter() {
    center = plx_map.getCenter();
}
