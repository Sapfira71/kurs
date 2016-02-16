<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

    if (($handle = fopen("products.csv", "r")) !== FALSE) {
        $counterKeys = 0;
        $counterElements = 0;
        $datarr = array();
        $keys = array("ART", "NAME", "QUANTITY", "PRICE", "SYMB");


        CModule::IncludeModule('iblock');
        $res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>1));
        $arraySC = Array();
        while($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            $arraySC[] = Array("CODE" => $arFields["CODE"],"ID" => $arFields["ID"]);
        }

       while (($data = fgetcsv($handle, 0, "\n")) !== FALSE) {
           if($counterElements!==0) {
               foreach ($data as $value) {
                   $elements = explode(";", $value);
                   $el = array();
                   foreach ($elements as $it) {
                       if($counterKeys==3) {
                           $el[$keys[$counterKeys]] = (int)str_replace(" ","",$it);
                       }else {
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
                    "IBLOCK_ID" => 1,
                    'NAME' => $elem['NAME'],
                    'CODE' => $elem['SYMB'],
                    "PROPERTY_VALUES" => $PROP
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