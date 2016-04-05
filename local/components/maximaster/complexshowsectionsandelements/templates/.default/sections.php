<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->IncludeComponent('maximaster:showsections', '.default', array(
    'SECTION_ID' => $arResult['SECTION_ID'],
    'SECTION_PATH' => $arResult['SECTION_PATH'],
    'BRAND_ID' => $arResult['BRAND_ID']
));
?>