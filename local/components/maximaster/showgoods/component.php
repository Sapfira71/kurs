<?php
    CModule::IncludeModule('iblock');
    $arFilter = Array("IBLOCK_ID"=>1);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>20), Array());
    $arResult["NAV_STRING"]  = $res->GetPageNavStringEx($navComponentObject, '', '', 'Y');
    $number = 0;
    while($ob = $res->GetNextElement())
    {
        if($number!==0) {
            $arField = $ob->GetProperties();

            $arResult["ELEMENTS"][$number]["ART"] = $arField["ART"]["VALUE"];
            $arResult["ELEMENTS"][$number]["NAME"] = $arField["NAME"]["VALUE"];
            $arResult["ELEMENTS"][$number]["QUANTITY"] = $arField["QUANTITY"]["VALUE"];
            $arResult["ELEMENTS"][$number]["PRICE"] = $arField["PRICE"]["VALUE"];
            $arResult["ELEMENTS"][$number]["SYMB"] = $arField["SYMB"]["VALUE"];
        }

        $number++;
    }
    $this->IncludeComponentTemplate();