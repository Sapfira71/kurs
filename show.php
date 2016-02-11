<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>
    <?php
    include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';
    $APPLICATION->IncludeComponent('maximaster:showgoods', '.default');
    ?>
</body>
</html>