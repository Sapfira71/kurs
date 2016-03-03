<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="local/templates/test/styles.css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script>
        function loadData() {
            $.ajax({
                url: 'downloaddata1.php'
            });
        }
    </script>
</head>
<body>
<input type="submit" name="create" value="Загрузить данные из файла" onclick="loadData()">

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
$APPLICATION->IncludeComponent('maximaster:filter', '.default', array('FILTER' => $_POST['myFilter']));
$APPLICATION->IncludeComponent('maximaster:showgoods', '.default',
    array(
        'FILTER' => $_POST['myFilter'],
        "IBLOCK_ID" => IBLOCK_CATALOG_TASK1_ID,
        'FILTER_PARAMS' => $_POST['filterParams']
    ));
?>
</body>
</html>