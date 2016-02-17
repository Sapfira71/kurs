jQuery("document").ready(function(){
    var nav = $('menu');
    $(window).scroll(function () {
        if ($(this).scrollTop() > 80) {
            nav.addClass("menuFixed");
        } else {
            nav.removeClass("menuFixed");
        }
    });

    var linkManepage = $('#mainPageLink');
    if(window.location.href == "http://morozova.bitrix.develop.maximaster.ru/") {
        linkManepage.addClass("mainpageUrlNone");
    } else {
        linkManepage.removeClass("mainpageUrlNone");
    }
});