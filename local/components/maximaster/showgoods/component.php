<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

CModule::IncludeModule('iblock');
$arFilter = array_merge(Array("IBLOCK_ID" => $arParams["IBLOCK_ID"]), $arParams["FILTER"]);
$arSelect = Array(
    'NAME',
    'CODE',
    'PROPERTY_ART',
    'PROPERTY_QUANTITY',
    'PROPERTY_PRICE'
);

$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 20), $arSelect);

while ($arFields = $res->Fetch()) {
    $arProduct = array(
        'ART' => $arFields["PROPERTY_ART_VALUE"],
        'NAME' => $arFields["NAME"],
        'QUANTITY' => $arFields["PROPERTY_QUANTITY_VALUE"],
        'PRICE' => $arFields["PROPERTY_PRICE_VALUE"],
        'SYMB' => $arFields["CODE"],
    );
    $arResult["ELEMENTS"][] = $arProduct;
}

if (!empty($arResult)) {
    $arResult["NAV_STRING"] = $res->GetPageNavStringEx($navComponentObject, '', '', 'Y');
}

$this->IncludeComponentTemplate();