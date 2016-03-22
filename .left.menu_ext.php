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
        'IS_SEF' => 'Y',
        'SEF_BASE_URL' => '#SITE_DIR#',
        'SECTION_PAGE_URL' => 'catalog/#SECTION_CODE_PATH#/index.php?SECTION_ID=#SECTION_ID#'
    )
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>