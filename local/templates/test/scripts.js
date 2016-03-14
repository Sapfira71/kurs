jQuery("document").ready(function () {
    var nav = $('menu');
    $(window).scroll(function () {
        if ($(this).scrollTop() > 80) {
            nav.addClass("menu-fixed");
        } else {
            nav.removeClass("menu-fixed");
        }
    });

    $('.js-img-el').loupe();
});

$(function () {
    $('#products').slides({
        preload: true,
        preloadImage: 'img/loading.gif',
        effect: 'slide, fade',
        crossfade: true,
        slideSpeed: 200,
        fadeSpeed: 500,
        generateNextPrev: true,
        generatePagination: false
    });
});