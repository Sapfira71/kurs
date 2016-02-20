<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent(
    "bitrix:menu.sections",
    "",
    Array(
        "ID" => $_REQUEST["SECTION_ID"],
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => "2",
        "DEPTH_LEVEL" => "3",
        "SECTION_URL" => "/index.php?SECTION_ID=#ID#",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600"
    )
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>