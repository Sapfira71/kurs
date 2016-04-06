<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->IncludeComponent('maximaster:showsections', '.default', array(
        'BRAND_CODE' => $arResult['BRAND_CODE']
    )
);
?>