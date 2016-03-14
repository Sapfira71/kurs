<?php

include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

function UpdateGoods($ibe, $elem, $arFields, $value)
{
    $ibe->Update($value["ID"], $arFields);

    CCatalogProduct::update(
        $value["ID"],
        array('QUANTITY' => $elem['QUANTITY'])
    );

    $price = CPrice::GetList(Array(), Array(
        'PRODUCT_ID' => $value["ID"],
        'CATALOG_GROUP_ID' => ID_TYPE_PRICE_BASE
    ), false, false, Array('ID'));

    if ($arPrice = $price->Fetch()) {
        CPrice::Update($arPrice['ID'], array(
            'PRODUCT_ID' => $value["ID"],
            'CATALOG_GROUP_ID' => ID_TYPE_PRICE_BASE,
            'PRICE' => $elem['PRICE'],
            "CURRENCY" => "RUB"
        ));
    }
}

function AddGoodsPriceAndQuantity($ID, $elem)
{
    CCatalogProduct::add(
        Array('ID' => $ID, 'QUANTITY' => $elem['QUANTITY']),
        false
    );
    CPrice::Add(array(
        'PRODUCT_ID' => $ID,
        'CATALOG_GROUP_ID' => ID_TYPE_PRICE_BASE,
        'PRICE' => $elem['PRICE'],
        "CURRENCY" => "RUB"
    ));
}

function getIdOfCountry($elem)
{
    $countryID = 0;
    $property_enums = CIBlockPropertyEnum::GetList(Array(), Array(
            "IBLOCK_ID" => IBLOCK_CATALOG_ID,
            "CODE" => "COUNTRY"
        )
    );
    while ($enum_fields = $property_enums->GetNext()) {
        if ($enum_fields["VALUE"] == $elem['COUNTRY']) {
            $countryID = $enum_fields["ID"];
            break;
        }
    }
    return $countryID;
}

function getIdOfBrand($elem)
{
    CModule::IncludeModule("highloadblock");

    $idbrand = "";

    $hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById(ID_BRAND_INFOBLOCK)->fetch();
    $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    $entity_table_name = $hlblock['Brand'];

    $sTableID = 'tbl_' . $entity_table_name;
    $rsData = $entity_data_class::getList(array(
        "select" => array('UF_NAME', 'UF_XML_ID'),
        "filter" => array('=UF_NAME' => $elem['BRAND'])
    ));
    $rsData = new CDBResult($rsData, $sTableID);
    if ($arRes = $rsData->Fetch()) {
        $idbrand = $arRes['UF_XML_ID'];
    }
    return $idbrand;
}

function getGalleryImages($elem)
{
    $result = Array();

    $str = $elem['GALLERY'];
    $explodeStr = explode("-", $str);
    foreach ($explodeStr as $el) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/images/' . $el)) {
            $result[] = CFile::MakeFileArray("/local/images/" . $el);
        }
    }

    return $result;
}

function addOrUpdateElement($arraySC, $datarr)
{
    $sectionList = getSectionListFromInfoblock();

    foreach ($datarr as $elem) {
        $ibe = new CIBlockElement;

        $countryID = getIdOfCountry($elem);
        $brandName = getIdOfBrand($elem);
        $galleryArr = getGalleryImages($elem);

        $PROP = Array(
            'COUNTRY' => $countryID,
            'BRAND' => $brandName
        );

        $sectionID = getSectionId($elem['SECTION'], $sectionList);

        $arFields = Array(
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => IBLOCK_CATALOG_ID,
            'NAME' => $elem['NAME'],
            'CODE' => $elem['SYMB'],
            'IBLOCK_SECTION_ID' => $sectionID,
            'PROPERTY_VALUES' => $PROP,
            'PREVIEW_TEXT' => $elem['PREW_T'],
            'PREVIEW_PICTURE' => CFile::MakeFileArray("/local/images/" . $elem['PREW_P']),
            'DETAIL_TEXT' => $elem['DET_T'],
            'DETAIL_PICTURE' => CFile::MakeFileArray("/local/images/" . $elem['DET_P'])
        );

        $flag = true;
        foreach ($arraySC as $value) {
            if ($value["CODE"] == $elem['SYMB']) {
                UpdateGoods($ibe, $elem, $arFields, $value);
                CIBlockElement::SetPropertyValuesEx($value['ID'], IBLOCK_CATALOG_ID, array("GALLERY" => $galleryArr));
                $flag = false;
                break;
            }
        }
        if ($flag) {
            if ($ID = $ibe->Add($arFields)) {
                AddGoodsPriceAndQuantity($ID, $elem);
                CIBlockElement::SetPropertyValuesEx($ID, IBLOCK_CATALOG_ID, array("GALLERY" => $galleryArr));
            } else {
                echo 'Error: ' . $ibe->LAST_ERROR . '<br>';
            }
        }
    }
}

function getSectionListFromInfoblock()
{
    $sectionList = Array();

    $arFilter = Array('IBLOCK_ID' => IBLOCK_CATALOG_ID);
    $arSelect = Array('ID', 'NAME');
    $db_list = CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);
    while ($ar_result = $db_list->Fetch()) {
        $sectionList[] = Array(
            'ID' => $ar_result['ID'],
            'NAME' => $ar_result['NAME']
        );
    }

    return $sectionList;
}

function getSectionId($sec, $sectionList)
{
    $explodeSec = explode("-", $sec);
    $secid = 0;

    $possibleSections = Array();
    foreach ($sectionList as $section) {
        if ($section['NAME'] == $explodeSec[count($explodeSec) - 1]) {
            $possibleSections[] = $section['ID'];
        }
    }

    $arrPath = Array();
    foreach ($possibleSections as $value) {
        $nav = CIBlockSection::GetNavChain(IBLOCK_CATALOG_ID, $value, Array('NAME', 'ID'));
        while ($arSectionPath = $nav->Fetch()) {
            $arrPath[$value][] = $arSectionPath;
        }
    }
    foreach ($arrPath as $path) {
        $flag = true;
        $temp = 0;
        if (count($path) !== count($explodeSec)) {
            continue;
        }
        for ($i = 0; $i < count($explodeSec); $i++) {
            if ($path[$i]['NAME'] !== $explodeSec[$i]) {
                $flag = false;
                break;
            } else {
                $temp = $path[$i]['ID'];
            }
        }
        if ($flag) {
            $secid = $temp;
        }
    }
    return $secid;
}

function readDataFromFile()
{
    $datarr = Array();

    if (($handle = fopen("goods.csv", "r")) !== false) {
        $counterKeys = 0;
        $counterElements = 0;
        $keys = array(
            "SYMB",
            "NAME",
            "SECTION",
            "QUANTITY",
            "PRICE",
            "COUNTRY",
            "BRAND",
            "PREW_T",
            "PREW_P",
            "DET_T",
            "DET_P",
            "GALLERY"
        );

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
        fclose($handle);
    }

    return $datarr;
}

function getElementsCodeAndIdFromInfoblock()
{
    $arraySC = Array();
    $arSelect = Array('CODE', 'ID');
    $res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID" => IBLOCK_CATALOG_ID), false, false, $arSelect);
    while ($ob = $res->Fetch()) {
        $arraySC[] = Array("CODE" => $ob["CODE"], "ID" => $ob["ID"]);
    }
    return $arraySC;
}

function main()
{
    CModule::IncludeModule('iblock');
    $datarr = readDataFromFile();
    $arraySC = getElementsCodeAndIdFromInfoblock();
    addOrUpdateElement($arraySC, $datarr);
}

main();

?>