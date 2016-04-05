<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->IncludeComponent('maximaster:showelement', '.default', array(
    'CODE' => $arResult['CODE'],
    'SECTION_PATH' => $arResult['SECTION_PATH']
));
?>