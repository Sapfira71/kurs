<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$arFilter = Array();

if (isset($arParams["FILTER"]["availability"]) || !empty($_GET["availability"])) {
    $arFilter['!PROPERTY_QUANTITY'] = 0;
    $arResult["availability"] = 'on';
}

if (!empty($arParams["FILTER"]["name"])) {
    $arFilter['NAME'] = $arResult["name"] = $arParams["FILTER"]["name"];
} elseif (!empty($_GET["name"])) {
    $arFilter['NAME'] = $arResult["name"] = $_GET["name"];
}

if (!empty($arParams["FILTER"]["vendorCode"])) {
    $arFilter['PROPERTY_ART'] = $arResult["vendorCode"] = $arParams["FILTER"]["vendorCode"];
} elseif (!empty($_GET["vendorCode"])) {
    $arFilter['PROPERTY_ART'] = $arResult["vendorCode"] = $_GET["vendorCode"];
}

if (!empty($arParams["FILTER"]["price1"]) && !empty($arParams["FILTER"]["price2"])) {
    $arFilter['><PROPERTY_PRICE'] = Array(
        $arParams["FILTER"]["price1"],
        $arParams["FILTER"]["price2"]
    );
    $arResult["price1"] = $arParams["FILTER"]["price1"];
    $arResult["price2"] = $arParams["FILTER"]["price2"];
} elseif (!empty($_GET["price1"]) && !empty($_GET["price2"])) {
    $arFilter['><PROPERTY_PRICE'] = Array(
        $_GET["price1"],
        $_GET["price2"]
    );
    $arResult["price1"] = $_GET["price1"];
    $arResult["price2"] = $_GET["price2"];
} else {
    if (!empty($arParams["FILTER"]["price1"])) {
        $arFilter['>PROPERTY_PRICE'] = $arResult["price1"] = $arParams["FILTER"]["price1"];
    } elseif (!empty($_GET["price1"])) {
        $arFilter['>PROPERTY_PRICE'] = $arResult["price1"] = $_GET["price1"];
    }

    if (!empty($arParams["FILTER"]["price2"])) {
        $arFilter['<PROPERTY_PRICE'] = $arResult["price2"] = $arParams["FILTER"]["price2"];
    } elseif (!empty($_GET["price2"])) {
        $arFilter['<PROPERTY_PRICE'] = $arResult["price2"] = $_GET["price2"];
    }
}

$_POST['myFilter'] = $arFilter;
$_POST['filterParams'] = $arResult;

$this->IncludeComponentTemplate();