jQuery("document").ready(function () {
    var nav = $('menu');
    $(window).scroll(function () {
        if ($(this).scrollTop() > 80) {
            nav.addClass("menuFixed");
        } else {
            nav.removeClass("menuFixed");
        }
    });
});