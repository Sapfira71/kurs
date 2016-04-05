<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->IncludeComponent('maximaster:showsections', '.default', array(
        'BRAND_NAME' => $arResult['BRAND_NAME']
    )
);
?>