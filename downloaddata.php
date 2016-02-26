<?php
/*if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}*/
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

if (($handle = fopen("goods.csv", "r")) !== false) {
    $counterKeys = 0;
    $counterElements = 0;
    $datarr = array();
    $keys = array("ID", "SYMB", "NAME", "SECTION", "QUANTITY", "PRICE", "COUNTRY", "BRAND", "PREW_T", "PREW_P");


    CModule::IncludeModule('iblock');

    $arraySC = Array();
    $arSelect = Array('CODE', 'ID');

    $res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID" => IBLOCK_CATALOG_ID), false, false, $arSelect);
    while ($ob = $res->Fetch()) {
        $arraySC[] = Array("CODE" => $ob["CODE"], "ID" => $ob["ID"]);
    }

    while (($data = fgetcsv($handle, 0, "\n")) !== false) {
        if ($counterElements !== 0) {
            foreach ($data as $value) {
                $elements = explode(";", $value);
                $el = array();
                foreach ($elements as $it) {
                    $el[$keys[$counterKeys]] = $it;
                    $counterKeys++;
                }
                $datarr[] = $el;
                $counterKeys = 0;
            }
        }
        $counterElements++;
    }

    $arFilter = Array('IBLOCK_ID' => IBLOCK_CATALOG_ID);
    $arSelect = Array('ID', 'NAME');
    $db_list = CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);
    $selectedSection = Array();
    while ($ar_result = $db_list->Fetch()) {
        $selectedSection[] = Array(
            'ID' => $ar_result['ID'],
            'NAME' => $ar_result['NAME']
        );
    }

    foreach ($datarr as $elem) {
        $ibe = new CIBlockElement;

        $PROP = Array(
            'PRICE' => $elem['PRICE'],
            'QUANTITY' => $elem['QUANTITY'],
            'COUNTRY' => $elem['COUNTRY'],
            'BRAND' => $elem['BRAND']
        );

        $arFields = Array(
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => IBLOCK_CATALOG_ID,
            'NAME' => $elem['NAME'],
            'CODE' => $elem['SYMB'],
            'ID' => $elem['ID'],
            'PROPERTY_VALUES' => $PROP,
            'PREVIEW_TEXT' => $elem['PREW_T']
        );

        $explodeSec = explode("-", $elem['SECTION']);
        $cat = $explodeSec[count($explodeSec)-1];

        foreach ($selectedSection as $value) {
            if ($value['NAME'] == $cat) {
                $arFields['IBLOCK_SECTION_ID'] = $value['ID'];
                break;
            }
        }

        echo "<pre>";
        print_r($arFields);

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