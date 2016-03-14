<!DOCTYPE html>
<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?
    $assetManager = Bitrix\Main\Page\Asset::getInstance();
    $assetManager->addCss(SITE_TEMPLATE_PATH . '/styles.css');
    $assetManager->addCss(SITE_TEMPLATE_PATH . '/gallery/css/global.css');
    $assetManager->addJs(SITE_TEMPLATE_PATH . '/scripts.js');
    $assetManager->addJs(SITE_TEMPLATE_PATH . '/zoom/jquery.loupe.js');
    $assetManager->addJs(SITE_TEMPLATE_PATH . '/gallery/js/slides.min.jquery.js');
    ?>

    <? $APPLICATION->ShowHead() ?>

    <title>
        <?
        $APPLICATION->SetTitle("Обучающее задание");
        $APPLICATION->ShowTitle();
        ?>
    </title>
</head>
<body>

<?php
$APPLICATION->ShowPanel();
?>

<header class="header">
    <? $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_SHOW" => "page",
            "AREA_FILE_SUFFIX" => "header",
            "EDIT_TEMPLATE" => ""
        )
    ); ?>
</header>
<menu class="menu" type="toolbar">
    <? $APPLICATION->IncludeComponent(
        "bitrix:menu",
        "grey_tabs",
        Array(
            "ROOT_MENU_TYPE" => "top"
        )
    ); ?>
</menu>
<table class="col">
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