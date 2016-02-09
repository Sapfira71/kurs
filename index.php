<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>

<?
include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';
CModule::IncludeModule('iblock');
if (($handle = fopen("products.csv", "r")) !== FALSE) {
    $counter = 0;
    $datarr = array();
    $keys = array("ART", "NAME", "QUANTITY", "PRICE", "SYMB");
    while (($data = fgetcsv($handle)) !== FALSE) {
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

        print_r($PROP);
        echo "<br/>";
        echo "<br/>";
        $arFields = Array(
            "ACTIVE" => 'Y',
            "IBLOCK_ID" => 1,
            "PROPERTY_VALUES"=> $PROP,
        );
        if($ID = $ibe->Add($arFields)){
            echo 'New ID: '.$ID.'<br>';
        }
        else{
            echo 'Error: '.$ibe->LAST_ERROR.'<br>';
        }
    }
    fclose($handle);
}
?>

</body>
</html>