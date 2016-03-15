jQuery("document").ready(function () {

    //Меню
    var nav = $('menu');
    $(window).scroll(function () {
        if ($(this).scrollTop() > 80) {
            nav.addClass("menu-fixed");
        } else {
            nav.removeClass("menu-fixed");
        }
    });

    //Зум
    $('.js-img-el').loupe();

    //ГАлерея
    $('.js-gallery').slides({
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