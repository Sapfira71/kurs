<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    CModule::IncludeModule('iblock');
    $arFilter = array_merge(Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"]), $arParams["FILTER"]);

    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>20),
        Array('NAME', 'CODE', /*'IBLOCK_ID', 'ID',*/ 'PROPERTY_ART', 'PROPERTY_QUANTITY')
    );

    while($arFields = $res->Fetch())
    {
        $arProduct = array(
            'ART' => $arFields['PROPERTY_ART_VALUE'],
            'NAME' => $arFields["NAME"],
            'QUANTITY' => $arFields["QUANTITY"]["VALUE"],
            'PRICE' => $arProperties["PRICE"]["VALUE"],
            'SYMB' => $arFields["CODE"],
        );
        $arResult["ELEMENTS"][] = $arProduct;
    }

    if(!empty($arResult)) $arResult["NAV_STRING"]  = $res->GetPageNavStringEx($navComponentObject, '', '', 'Y');

    $this->IncludeComponentTemplate();