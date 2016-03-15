jQuery("document").ready(function () {

    //Прикрепление меню к верху экрана при скролле страницы вниз
    var nav = $('menu');
    $(window).scroll(function () {
        if ($(this).scrollTop() > 80) {
            nav.addClass("menu-fixed");
        } else {
            nav.removeClass("menu-fixed");
        }
    });

    //Плагин "лупа" для детального изображения товара
    $('.js-img-el').loupe();

    //Плагин "галерея" для списка изображений товара
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