<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
if (empty($_REQUEST["SECTION_ID"]) && empty($_REQUEST["BRAND_ID"])) {
    return;
}

CModule::IncludeModule('iblock');

if (!empty($_REQUEST["SECTION_ID"])) {
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
}

$arFilter = Array(
    "IBLOCK_ID" => IBLOCK_CATALOG_ID
);

if(!empty($_REQUEST["SECTION_ID"])) {
    $arFilter["SECTION_ID"] = $_REQUEST["SECTION_ID"];
    $arFilter["INCLUDE_SUBSECTIONS"] = "Y";
}

if(!empty($_REQUEST["BRAND_ID"])) {
    $arFilter["PROPERTY_BRAND"] = $_REQUEST["BRAND_ID"];
}

$arSelect = Array(
    'NAME',
    'PREVIEW_TEXT',
    'PREVIEW_PICTURE',
    'ID',
    'CATALOG_GROUP_' . ID_TYPE_PRICE_BASE,
    'DETAIL_PAGE_URL'
);

$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

while ($ob = $res->GetNext()) {
    $arProduct = array(
        'NAME' => $ob["NAME"],
        'ID' => $ob['ID'],
        'PRICE' => $ob['CATALOG_PRICE_' . ID_TYPE_PRICE_BASE],
        'PREV_D' => $ob["PREVIEW_TEXT"],
        'PREV_P' => CFile::GetPath($ob["PREVIEW_PICTURE"]),
        'DETAIL_URL' => $ob['DETAIL_PAGE_URL']
    );

    $arResult["ELEMENTS"][] = $arProduct;
}

$this->IncludeComponentTemplate();