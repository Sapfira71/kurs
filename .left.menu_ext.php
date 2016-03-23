<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent(
    'bitrix:menu.sections',
    '',
    Array(
        'ID' => $_REQUEST['SECTION_ID'],
        'IBLOCK_TYPE' => 'catalog',
        'IBLOCK_ID' => IBLOCK_WEAR_ID,
        'DEPTH_LEVEL' => '3',
        'CACHE_TYPE' => 'A',
        'CACHE_TIME' => '3600',
        'IS_SEF' => 'Y'
    )
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>