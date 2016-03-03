<!DOCTYPE>
<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

    <? $APPLICATION->SetAdditionalCSS("<?= SITE_TEMPLATE_PATH ?>/styles.css"); ?>
    <script type="text/javascript"
            src="<?= CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH . '/scripts.js', true) ?>"></script>
    <? $APPLICATION->ShowHead() ?>
    <title><? $APPLICATION->ShowTitle() ?></title>
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>

<?php
$APPLICATION->ShowPanel();
?>

<header class="header">
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_SHOW" => "page",
            "AREA_FILE_SUFFIX" => "header",
            "EDIT_TEMPLATE" => ""
        )
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
            <aside class="asideLeft">
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