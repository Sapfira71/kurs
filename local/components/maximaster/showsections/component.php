<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
if (empty($_REQUEST["SECTION_ID"])) {
    return;
}

CModule::IncludeModule('iblock');

$arFilter = Array("IBLOCK_ID" => IBLOCK_CATALOG_ID, "ID" => $_REQUEST["SECTION_ID"]);
$sec_list = CIBlockSection::GetList(Array(), $arFilter, true);

while ($ar_result = $sec_list->GetNext()) {
    $arResult = Array(
        'NAME' => $ar_result['NAME'],
        'ELEMENT_CNT' => $ar_result['ELEMENT_CNT'],
        'DESCRIPTION' => $ar_result['DESCRIPTION'],
        'IMAGE' => CFile::GetPath($ar_result["PICTURE"])
    );
}

$arFilter = Array(
    "IBLOCK_ID" => 2,
    "SECTION_ID" => $_REQUEST["SECTION_ID"],
    "INCLUDE_SUBSECTIONS" => 'Y'
);
$res = CIBlockElement::GetList(Array(), $arFilter);

while ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    $arProperties = $ob->GetProperties();

    $arProduct = array(
        'NAME' => $arFields["NAME"],
        'PRICE' => $arProperties["PRICE"]["VALUE"],
        'PREV_D' => $arFields["PREVIEW_TEXT"],
        'PREV_P' => CFile::GetPath($arFields["PREVIEW_PICTURE"])
    );
    $arResult["ELEMENTS"][] = $arProduct;
}

$this->IncludeComponentTemplate();