<?
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
?>
    <p>Рабочий телефон: 8-915-***-23-71</p>
    <a id="2gis_mini_biglink" title="Организации Тулы"
       href="http://maps.2gis.ru/#/?history=project/tula/center/37.613707,54.19409/zoom/17/">
        Перейти к большой карте
    </a>
    <noscript id="dg-widget-minigis-place-023946f1" style="color:#c00;font-size:16px;font-weight:bold;">
        Код для вставки виджета на сайт
    </noscript>
    <script src="http://mini.api.2gis.ru/js/ver_b7c1829/loader.js"></script>
    <script type="text/javascript">
        new DG.Widget.Components.Loader({
            wid: '023946f1',
            params: {
                'projectSelector': {
                    'id': 36,
                    'code': 'tula',
                    'name': 'Тула',
                    'centroid': 'POINT(37.616347 54.195143)'
                },
                'search': {
                    'rubrics': {'list': []},
                    '_searchFirmBasePoint': {'lon': 37.613707, 'lat': 54.19409},
                    'searchBasePointName': 'Тула, Советская, 31'
                },
                'customBalloon': {'content': 'Тула, Советская, 31'},
                'Map': {
                    'zoom': 17,
                    'lon': 37.613707,
                    'lat': 54.19409,
                    'customBalloon': true,
                    'customBallonHidden': false
                },
                'resize': {'w': 620, 'h': 500}
            }
        });
    </script>
<?
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
