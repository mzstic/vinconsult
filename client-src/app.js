var $ = require('jquery');
var slick = require('slick-carousel');
var ligtbox = require('lightbox2');


$(document).ready(function() {
    console.log("VinConsult startup");

    /**
     * Open main menu
     */
    $(".toggle-menu .fa-navicon").click(function() {
        $(".mainmenu").addClass("opened");
        var $toggleMenu = $(".toggle-menu");
        $toggleMenu.removeClass("toggle-menu--closed");
        $toggleMenu.addClass("toggle-menu--opened");
    });

    /**
     * Close main menu
     */
    $(".toggle-menu .fa-close").click(function() {
        $(".mainmenu").removeClass("opened");
        var $toggleMenu = $(".toggle-menu");
        $toggleMenu.removeClass("toggle-menu--opened");
        $toggleMenu.addClass("toggle-menu--closed");
    });

    $(".projects-select").click(function() {
        if ($(this).hasClass("closed")) {
            $(this).removeClass("closed").addClass("opened");
        } else {
            $(this).removeClass("opened").addClass("closed");
        }
    });

    $jsSlick = $('.js-slick');
    $jsSlick.slick({
        autoplay: true,
        autoplaySpeed: 5000,
        dots: true,
        draggable: false,
        speed: 1000,
        fade: true
        //centerMode: true,
        //infinite: true
        //slidesToShow: 2
    });
    $jsSlick.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
        $(slick.$slides).find('.photo').removeClass('is-animating');
    });
    $jsSlick.on('afterChange', function(event, slick, currentSlide, nextSlide) {
        $(slick.$slides.get(currentSlide)).find('.photo').addClass('is-animating');
    });

    $jsSlickSmall = $('.js-slick-small');
    $jsSlickSmall.slick({
//        autoplay: true,
        //autoplaySpeed: 5000,
        dots: true,
        draggable: false,
        speed: 1000,
        centerMode: true,
        infinite: true,
        slidesToShow: 2
    });

    $('.references select').change(function(ev) {
        window.location.replace($(this).find(":selected").data("redirect"));
        //console.log($(this).find(":selected").data("redirect"));
    });

    var iScrollPos = 0;
    var scrolled = false;
    $(window).scroll(function (ev) {
        var iCurScrollPos = $(this).scrollTop();

        if (iCurScrollPos < 5) {
            $(".header").removeClass("header--down").removeClass("header--up").addClass("header--top");
        } else if (iScrollPos <= iCurScrollPos) {
            $(".header").removeClass("header--top").removeClass("header--up").addClass("header--down");
        } else {
            $(".header").removeClass("header--top").removeClass("header--down").addClass("header--up");
        }

        if (scrolled) {
            iScrollPos = iCurScrollPos;
            return;
        }

        $target = $(".content .text.down");
        if ($target && $target.length > 0 && (iScrollPos < 400)) {
            if (iCurScrollPos > iScrollPos) {
                scrolled = true;
                iCurScrollPos = $target.offset().top;
                $('html, body').animate({
                    scrollTop: $target.offset().top
                }, 2000);
            } else {

            }
        }

        $target2 = $(".content-home");
        if ($target2 && $target2.length > 0 && (iScrollPos < 400)) {
            if (iCurScrollPos > iScrollPos) {
                scrolled = true;
                iCurScrollPos = $target2.offset().top;
                $('html, body').animate({
                    scrollTop: $target2.offset().top
                }, 2000);
            } else {

            }
        }
        iScrollPos = iCurScrollPos;
    });


    $( window ).resize(function() {
        $( "#detail-gallery" ).css(
            {
                'left': (($("body").width() - $( ".content.no-photo" ).width()) / -2)
            }
        );

    });

    $( "#detail-gallery" ).css(
        {
            'left': (($("body").width() - $( ".content.no-photo" ).width()) / -2)
        }
    );

});

