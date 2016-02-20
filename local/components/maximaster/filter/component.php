<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    $arFilter = Array();
    if(isset($arParams["FILTER"]["availability"])) $arFilter['!PROPERTY_QUANTITY'] = 0;
    if(!empty($arParams["FILTER"]["name"])) $arFilter['NAME'] = $arParams["FILTER"]["name"];
    if(!empty($arParams["FILTER"]["vendorCode"])) $arFilter['PROPERTY_ART'] = $arParams["FILTER"]["vendorCode"];
    if(!empty($arParams["FILTER"]["price1"])&&!empty($arParams["FILTER"]["price2"]))
        $arFilter['><PROPERTY_PRICE'] = Array($arParams["FILTER"]["price1"], $arParams["FILTER"]["price2"]);
    else {
        if(!empty($arParams["FILTER"]["price1"]))
            $arFilter['>PROPERTY_PRICE'] = $arParams["FILTER"]["price1"];
        if(!empty($arParams["FILTER"]["price2"]))
            $arFilter['<PROPERTY_PRICE'] = $arParams["FILTER"]["price2"];
    }

    $_POST['myFilter'] = $arFilter;
    $this->IncludeComponentTemplate();