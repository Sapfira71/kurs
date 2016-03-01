<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
if (empty($_REQUEST["SECTION_ID"])) {
    return;
}

CModule::IncludeModule('iblock');

$arFilter = Array("IBLOCK_ID" => IBLOCK_CATALOG_ID, "ID" => $_REQUEST["SECTION_ID"]);
$arSelect = Array(
    'NAME',
    'ELEMENT_CNT',
    'DESCRIPTION',
    'PICTURE'
);
$sec_list = CIBlockSection::GetList(Array(), $arFilter, true, $arSelect);

while ($ar_result = $sec_list->Fetch()) {
    $arResult = Array(
        'NAME' => $ar_result['NAME'],
        'ELEMENT_CNT' => $ar_result['ELEMENT_CNT'],
        'DESCRIPTION' => $ar_result['DESCRIPTION'],
        'IMAGE' => CFile::GetPath($ar_result["PICTURE"])
    );
}

$arFilter = Array(
    "IBLOCK_ID" => IBLOCK_CATALOG_ID,
    "SECTION_ID" => $_REQUEST["SECTION_ID"],
    "INCLUDE_SUBSECTIONS" => 'Y'
);
$arSelect = Array(
    'NAME',
    'PREVIEW_TEXT',
    'PREVIEW_PICTURE',
    'ID'
);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

while ($ob = $res->Fetch()) {
    $price = CPrice::GetList(Array(), Array(
        'PRODUCT_ID' => $ob["ID"],
        'CATALOG_GROUP_ID' => ID_TYPE_PRICE_BASE
    ), false, false, Array('PRICE'));

    $priceEl = 0;
    if ($arPrice = $price->Fetch()) {
        $priceEl = $arPrice['PRICE'];
    }

    $arProduct = array(
        'NAME' => $ob["NAME"],
        'PRICE' => $priceEl,
        'PREV_D' => $ob["PREVIEW_TEXT"],
        'PREV_P' => CFile::GetPath($ob["PREVIEW_PICTURE"])
    );
    $arResult["ELEMENTS"][] = $arProduct;
}

$this->IncludeComponentTemplate();