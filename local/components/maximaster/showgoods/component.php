<?php
    CModule::IncludeModule('iblock');
    $arFilter = array_merge(Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"]), $arParams["FILTER"]);

    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>20), Array());

    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $arProperties = $ob->GetProperties();

        $arProduct = array(
            'ART' => $arProperties["ART"]["VALUE"],
            'NAME' => $arFields["NAME"],
            'QUANTITY' => $arProperties["QUANTITY"]["VALUE"],
            'PRICE' => $arProperties["PRICE"]["VALUE"],
            'SYMB' => $arFields["CODE"],
        );
        $arResult["ELEMENTS"][] = $arProduct;
    }

    if(!empty($arResult)) $arResult["NAV_STRING"]  = $res->GetPageNavStringEx($navComponentObject, '', '', 'Y');

    $this->IncludeComponentTemplate();