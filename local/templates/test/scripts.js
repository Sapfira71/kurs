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