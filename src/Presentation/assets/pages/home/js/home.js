$(document).ready(() => {
    $('.slider-coaches-feedbacks').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        dots: false,
        prevArrow: false,
        nextArrow: false
    });

    (function stickMenu() {
        $(window).bind('scroll', function () {
            if ($(window).scrollTop() > 200) {
                $('header').addClass('sticky');
            } else {
                $('header').removeClass('sticky');
            }
        });
    })();

    (function checkIfLogin() {
        if ($('#wpadminbar').length > 0) {
            $('body').addClass('logged-in');
        }
    })()
});