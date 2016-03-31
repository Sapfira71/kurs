<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->IncludeComponent('maximaster:showsections', '.default', array(
        'SECTION_ID' => $arResult['SECTION_ID'],
        'BRAND_ID' => $arResult['BRAND_ID']
    )
);
?>