jQuery('document').ready(function () {

    //Прикрепление меню к верху экрана при скролле страницы вниз
    var nav = $('menu');
    $(window).scroll(function () {
        if ($(this).scrollTop() > 80) {
            nav.addClass('menu-fixed');
        } else {
            nav.removeClass('menu-fixed');
        }
    });

    //Плагин 'лупа' для детального изображения товара
    $('.js-img-el').loupe();

    //Плагин 'галерея' для списка изображений товара
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

    //Установка куки по нажатию кнопки 'Оформить заказ'
    $('.js-order-button').click(function() {
        setCookie('name', $("input[name='name']").val());
        setCookie('number', $("input[name='number']").val());
        setCookie('mail', $("input[name='mail']").val());
    });

    //Установка значений формы из куки
    $("input[name='name']").val(getCookie('name'));
    $("input[name='number']").val(getCookie('number'))
    $("input[name='mail']").val(getCookie('mail'))

    //Установка маски для поля ввода телефона
    $("input[name='number']").mask("+7(999)999-99-99");
});