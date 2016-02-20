<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

if (($handle = fopen("goods.csv", "r")) !== FALSE) {
    $counterKeys = 0;
    $counterElements = 0;
    $datarr = array();
    $keys = array("SYMB", "NAME", "QUANTITY", "PRICE", "COUNTRY", "BRAND");


    CModule::IncludeModule('iblock');
    $res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>2));
    $arraySC = Array();
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $arProperties = $ob->GetProperties();

        echo "<pre>";
        print_r($arFields);
        print_r($arProperties);
        echo "</pre>";
        $arraySC[] = Array("CODE" => $arFields["CODE"],"ID" => $arFields["ID"]);
    }

    while (($data = fgetcsv($handle, 0, "\n")) !== FALSE) {
        if($counterElements!==0) {
            foreach ($data as $value) {
                $elements = explode(";", $value);
                echo "<pre>";
                print_r($value);
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
            'IBLOCK_ID' => 2,
            'NAME' => $elem['NAME'],
            'CODE' => $elem['SYMB'],
            'PROPERTY_VALUES' => $PROP
        );

        $flag = true;
        foreach($arraySC as $value) {
            if($value["CODE"] == $elem['SYMB']) {
                $ID = $ibe->Update($value["ID"], $arFields);
                $flag = false;
                break;
            }
        }
        if($flag) {
            if ($ID = $ibe->Add($arFields)) {
            } else {
                echo 'Error: ' . $ibe->LAST_ERROR . '<br>';
            }
        }
    }
    fclose($handle);
}
?>