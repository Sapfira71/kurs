<!DOCTYPE>
<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?
    Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/styles.css');
    Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/scripts.js');
    Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/zoom/jquery.loupe.js');
    ?>

    <? $APPLICATION->ShowHead() ?>

    <title><? $APPLICATION->ShowTitle() ?></title>
</head>
<body>

<?php
$APPLICATION->ShowPanel();
require('scriptsphp.php');
?>

<header class="header">
    <?$APPLICATION->IncludeFile(
        $APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/include_areas/inc_header.php"),
        Array(),
        Array("MODE"=>"php")
    );?>
</header>
<menu class="menu" type="toolbar">
    <a href="/">Главная страница</a>
    <a href="../about.php">О себе</a>
    <a href="../contacts.php">Контакты</a>
</menu>
<table cellpadding="5" cellspacing="0" class="col">
    <tr>
        <td class="col1">
            <aside>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "tree",
                    Array(
                        "ROOT_MENU_TYPE" => "left",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "Y"
                    )
                ); ?>
            </aside>
        </td>
        <td>
            <div class="content">