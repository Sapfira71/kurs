<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>
        <?php
        include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';
        CModule::IncludeModule('iblock');
        echo "<pre>";
        if (($handle = fopen("products.csv", "r")) !== FALSE) {
            $counter = 0;
            $datarr = array();
            $keys = array("ART", "NAME", "QUANTITY", "PRICE", "SYMB");
            while (($data = fgetcsv($handle,1000,"\n")) !== FALSE) {
                foreach ($data as $value) {
                    $elements = explode(";", $value);
                    $el = array();
                    foreach ($elements as $it){
                        $el[$keys[$counter]] = $it;
                        $counter++;
                    }
                    $counter = 0;
                    $datarr[] = $el;
                }
            }
            foreach ($datarr as $elem) {
                $ibe = new CIBlockElement;
                $PROP = array();
                $PROP['ART'] = $elem['ART'];
                $PROP['NAME'] = $elem['NAME'];
                $PROP['QUANTITY'] = $elem['QUANTITY'];
                $PROP['PRICE'] = $elem['PRICE'];
                $PROP['SYMB'] = $elem['SYMB'];

                $arFields = Array(
                    "ACTIVE" => 'Y',
                    "IBLOCK_ID" => 1,
                    'NAME' =>  $elem['NAME'],
                    "PROPERTY_VALUES"=> $PROP,
                );
                if($ID = $ibe->Add($arFields)){
                }
                else {
                    echo 'Error: '.$ibe->LAST_ERROR.'<br>';
                }
            }

            echo "<table border='1'>";
            $arFilter = Array("IBLOCK_ID"=>1);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, Array());
            $count = true;
            while($ob = $res->GetNextElement())
            {
                $arField = $ob->GetProperties();

                echo "<tr>";
                echo "<td>".$arField["ART"]["VALUE"]."</td>";
                echo "<td>". $arField["NAME"]["VALUE"] ."</td>";
                echo "<td>". $arField["QUANTITY"]["VALUE"] ."</td>";
                echo "<td>". $arField["PRICE"]["VALUE"] ."</td>";
                echo "<td>". $arField["SYMB"]["VALUE"] ."</td>";
                echo "</tr>";
            }
            echo "</table>";

            fclose($handle);
        }
        ?>
</body>
</html>