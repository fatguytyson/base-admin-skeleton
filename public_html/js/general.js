$(function($) {

    'use strict';

    /*-----------------------------------------------------------------
     * Variables
     *-----------------------------------------------------------------*/

    var $body_html = $('body, html'),
        $html = $('html'),
        $body = $('body'),

        $navigation = $('#navigation'),
        navigation_height = $navigation.height() - 20,

        $scroll_to_top = $('#scroll-to-top'),

        $preloader = $('#preloader'),
        $loader = $preloader.find('.loader');

    if (navigation_height <= 0) navigation_height = 60;

    /*-----------------------------------------------------------------
     * Is mobile
     *-----------------------------------------------------------------*/

    var ua_test = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i,
        is_mobile = ua_test.test(navigator.userAgent);

    $html.addClass(is_mobile ? 'mobile' : 'no-mobile');

    /*-----------------------------------------------------------------
     * Background Parallax
     *-----------------------------------------------------------------*/

    $.stellar({
        responsive: true,
        horizontalOffset: 0,
        verticalOffset: 0,
        horizontalScrolling: false,
        hideDistantElements: false
    });

    /*-----------------------------------------------------------------
     * ScrollSpy
     *-----------------------------------------------------------------*/

    $body.scrollspy({
        offset:  51,
        target: '#navigation'
    });

    /*-----------------------------------------------------------------
     * Affixed Navbar
     *-----------------------------------------------------------------*/

    $navigation.affix({
        offset: {
            top: navigation_height
        }
    });

    /*-----------------------------------------------------------------
     * Scroll To Top
     *-----------------------------------------------------------------*/

    $(window).scroll(function () {

        var $scroll_top = $(this).scrollTop();

        if ($scroll_top > navigation_height) {
            $scroll_to_top.addClass('scroll-showed').removeClass('scroll-hided');
        } else {
            $scroll_to_top.addClass('scroll-hided').removeClass('scroll-showed');
        }
    });

    $scroll_to_top.click(function() {
        $.scrollWindow(0);
    });

    /*-----------------------------------------------------------------
     * Smooth Scrolling
     *-----------------------------------------------------------------*/

    $('a[href^="#"]').click(function(event) {

        event.preventDefault();

        var target = $(this).attr('href');
        if (target == '#') return;

        var offset = $(target).offset().top - navigation_height;

        $.scrollWindow(offset);

    });

    $.scrollWindow = function(offset) {

        $preloader.fadeIn();
        //$body.addClass('blur');

        $body_html.animate({
            scrollTop: offset
        }, 1500, 'swing', function() {
            //$body.removeClass('blur');
            $preloader.fadeOut();
        });
    };

    /*-----------------------------------------------------------------
     * WOW Effects
     *-----------------------------------------------------------------*/

    new WOW().init({
        mobile: false
    });

    /*-----------------------------------------------------------------
     * Magnific
     *-----------------------------------------------------------------*/

    $('.image-popup').magnificPopup({
        type           : 'image',
        closeBtnInside : true,
        mainClass      : 'mfp-with-zoom'
    });

    $('.iframe-popup').magnificPopup({
        type      : 'iframe',
        mainClass : 'mfp-fade'
    });

    /*-----------------------------------------------------------------
     * Carousels
     *-----------------------------------------------------------------*/

    $("#carousel-testimonials").owlCarousel({
        pagination      : true,
        navigation      : false,
        singleItem      : true,
        responsive      : true,
        autoPlay        : false,

        paginationSpeed : 400,
        slideSpeed      : 300,

        items           : 1
    });

    $("#how-it-works-carousel").owlCarousel({
        navigation: true,
        pagination:false,
        responsive: true,
        responsiveRefreshRate : 200,
        responsiveBaseWidth: window,
        items:1
    });
    $("#app-screenshots-carousel").owlCarousel({
        pagination      : true,
        navigation      : false,
        singleItem      : false,
        responsive      : true,
        autoPlay        : false,

        paginationSpeed : 400,
        slideSpeed      : 300,

        items           : 5
    });

    /*-----------------------------------------------------------------
     * Ajax forms
     *-----------------------------------------------------------------*/

    $('.form-ajax').each(function(){

        $(this).validate({
            submitHandler: function(form) {

                var $submit_button = $(form).find('[type=submit]'),
                    submit_button_text = $submit_button.html();

                $submit_button.attr('disabled', true);
                $submit_button.html('Please wait...');

                $.ajax({

                    type   : 'post',
                    url    : 'contact',
                    data   : $(form).serialize(),

                    success: function() {

                        $('.modal-result').html('We will contact you when the service goes live :)');
                        $('#result').modal('show');

                        $submit_button.attr('disabled', false);
                        $submit_button.html(submit_button_text);
                    },

                    error: function(){

                        $('.modal-result').html('Error sending message :(');
                        $('#result').modal('show');

                        $submit_button.attr('disabled', false);
                        $submit_button.html(submit_button_text);
                    }
                });
            }
        });
    });

    /*-----------------------------------------------------------------
     * Finish loading
     *-----------------------------------------------------------------*/

    $(function() {

        /* Remove preloader */

        $loader.delay(1500).fadeOut();
        $preloader.delay(500).fadeOut('slow');
        $("#phone_truck").delay(4000).fadeIn();
        $("#couch_truck").delay(4000).fadeOut();
        // $("#text2").delay(4300).fadeIn().delay(2800).fadeOut(200);
        // $("#text1").delay(4300).fadeOut();
        // $("#text3").delay(7100).fadeIn();

        $body.addClass('loaded');

    });

});