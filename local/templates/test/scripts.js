jQuery("document").ready(function(){
    var nav = $('menu');
    $(window).scroll(function () {
        if ($(this).scrollTop() > 80) {
            nav.addClass("menuFixed");
        } else {
            nav.removeClass("menuFixed");
        }
    });

    if(window.location.href !== "http://morozova.bitrix.develop.maximaster.ru/" && window.location.href.indexOf("index.php")== -1) {
        $("#headMenu").prepend("<a href='/'>Главная страница</a>");
    }

    $('aside').height($('aside').parent().height()-228);
});