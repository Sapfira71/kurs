<!DOCTYPE>
<html>
<head>
    <?$APPLICATION->ShowHead()?>
    <title><?$APPLICATION->ShowTitle()?></title>
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/styles.css"/>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/scripts.js"></script>
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<?php
    include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';
    function selfURL(){
        $url  = ( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
        $url .= ( $_SERVER["SERVER_PORT"] != 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
        $url .= $_SERVER["REQUEST_URI"];
        return $url;
    }
?>
<header><img src="lotus.png" class="imgLotus">Привет! Этот сайт - результат выполнения обучающего задания.</header>
<menu type="toolbar" id="headMenu">
    <a href="../about.php">О себе</a>
    <a href="../contacts.php">Контакты</a>
</menu>
<table cellpadding="5" cellspacing="0" class="col">
    <tr>
        <td class="col1">
            <aside class="asideLeft">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "tree",
                    Array(
                        "ROOT_MENU_TYPE" => "left",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "Y"
                    )
                );?>
            </aside>
        </td>
        <td>
            <div class="content">