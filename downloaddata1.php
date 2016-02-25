<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

if (($handle = fopen("products.csv", "r")) !== false) {
    $counterKeys = 0;
    $counterElements = 0;
    $datarr = array();
    $keys = array("ART", "NAME", "QUANTITY", "PRICE", "SYMB");


    CModule::IncludeModule('iblock');

    $arraySC = Array();
    $arSelect = Array('CODE', 'ID');

    $res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID" => IBLOCK_CATALOG_TASK1_ID), false, false, $arSelect);
    while ($ob = $res->Fetch()) {
        $arraySC[] = Array("CODE" => $ob["CODE"], "ID" => $ob["ID"]);
    }

    while (($data = fgetcsv($handle, 0, "\n")) !== false) {
        if ($counterElements !== 0) {
            foreach ($data as $value) {
                $elements = explode(";", $value);
                $el = array();
                foreach ($elements as $it) {
                    if ($counterKeys == 3) {
                        $el[$keys[$counterKeys]] = (int)str_replace(" ", "", $it);
                    } else {
                        $el[$keys[$counterKeys]] = $it;
                    }
                    $counterKeys++;
                }
                $datarr[] = $el;
                $counterKeys = 0;
            }
        }
        $counterElements++;
    }

    foreach ($datarr as $elem) {
        $ibe = new CIBlockElement;

        $PROP = array();
        $PROP['ART'] = $elem['ART'];
        $PROP['QUANTITY'] = $elem['QUANTITY'];
        $PROP['PRICE'] = $elem['PRICE'];

        $arFields = Array(
            "ACTIVE" => 'Y',
            "IBLOCK_ID" => IBLOCK_CATALOG_TASK1_ID,
            'NAME' => $elem['NAME'],
            'CODE' => $elem['SYMB'],
            "PROPERTY_VALUES" => $PROP
        );

        $flag = true;
        foreach ($arraySC as $value) {
            if ($value["CODE"] == $elem['SYMB']) {
                $ID = $ibe->Update($value["ID"], $arFields);
                $flag = false;
                break;
            }
        }
        if ($flag) {
            if ($ID = $ibe->Add($arFields)) {
            } else {
                echo 'Error: ' . $ibe->LAST_ERROR . '<br>';
            }
        }
    }
    fclose($handle);
}
?>