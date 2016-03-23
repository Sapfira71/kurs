<?php

include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

/**
 * Обновить элемент инфоблока
 * @param CIBlockElement $ibe Элемент инфоблока
 * @param array $elem Массив, содержащий поля и свойства элемента из файла
 * @param array $arFields Массив, содержащий новые значения свойств элемента
 * @param array $value Массив с информацией об элементе уже существующем в инфоблоке
 */
function UpdateGoods($ibe, $elem, $arFields, $value)
{
    $ibe->Update($value['ID'], $arFields);

    \CCatalogProduct::update(
        $value['ID'],
        array('QUANTITY' => $elem['QUANTITY'])
    );

    $price = \CPrice::GetList(Array(), Array(
        'PRODUCT_ID' => $value['ID'],
        'CATALOG_GROUP_ID' => PRICE_TYPE_BASE_ID
    ), false, false, Array('ID'));

    if ($arPrice = $price->Fetch()) {
        \CPrice::Update($arPrice['ID'], array(
            'PRODUCT_ID' => $value['ID'],
            'CATALOG_GROUP_ID' => PRICE_TYPE_BASE_ID,
            'PRICE' => $elem['PRICE'],
            'CURRENCY' => 'RUB'
        ));
    }
}

/**
 * Добавить значения цены и количества товара в инфоблок
 * @param int $ID элемента инфоблока
 * @param array $elem Массив, содержащий поля и свойства элемента из файла
 */
function AddGoodsPriceAndQuantity($ID, $elem)
{
    \CCatalogProduct::add(
        Array('ID' => $ID, 'QUANTITY' => $elem['QUANTITY']),
        false
    );
    \CPrice::Add(array(
        'PRODUCT_ID' => $ID,
        'CATALOG_GROUP_ID' => PRICE_TYPE_BASE_ID,
        'PRICE' => $elem['PRICE'],
        'CURRENCY' => 'RUB'
    ));
}

/**
 * Получить ID страны-производителя товара из списка
 * @param array $elem Массив, содержащий поля и свойства элемента из файла
 * @return int
 */
function getIdOfCountry($elem)
{
    $countryID = 0;
    $propertyEnums = \CIBlockPropertyEnum::GetList(Array(), Array(
            'IBLOCK_ID' => IBLOCK_WEAR_ID,
            'CODE' => 'COUNTRY'
        )
    );
    while ($enumFields = $propertyEnums->GetNext()) {
        if ($enumFields['VALUE'] == $elem['COUNTRY']) {
            $countryID = $enumFields['ID'];
            break;
        }
    }
    return $countryID;
}

/**
 * Получить XML_ID бренда товара из highload-блока
 * @param array $elem Массив, содержащий поля и свойства элемента из файла
 * @return string
 */
function getIdOfBrand($elem)
{
    CModule::IncludeModule('highloadblock');

    $idbrand = '';

    $hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById(HIGHLOADBLOCK_BRAND_ID)->fetch();
    $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    $entityDataClass = $entity->getDataClass();
    $entityTableName = $hlblock['Brand'];

    $rsData = $entityDataClass::getList(array(
        'select' => array('UF_NAME', 'UF_XML_ID'),
        'filter' => array('=UF_NAME' => $elem['BRAND'])
    ));
    $rsData = new \CDBResult($rsData, $entityTableName);
    if ($arRes = $rsData->Fetch()) {
        $idbrand = $arRes['UF_XML_ID'];
    }
    return $idbrand;
}

/**
 * Получить массив изображений для галереи товара
 * @param array $elem Массив, содержащий поля и свойства элемента из файла
 * @return array
 */
function getGalleryImages($elem)
{
    $result = Array();

    $str = $elem['GALLERY'];
    $explodeStr = explode('-', $str);
    foreach ($explodeStr as $el) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/images/' . $el)) {
            $result[] = \CFile::MakeFileArray('/local/images/' . $el);
        }
    }

    return $result;
}

/**
 * Функция обновляющая или добавляющая элемент в инфоблоке
 * @param array $arraySC Массив символьных кодов и ID товаров, уже существующих в инфоблоке
 * @param array $datarr Массив с данными из файла
 */
function addOrUpdateElement($arraySC, $datarr)
{
    $sectionList = getSectionListFromInfoblock();

    foreach ($datarr as $elem) {
        $ibe = new \CIBlockElement;

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
            'IBLOCK_ID' => IBLOCK_WEAR_ID,
            'NAME' => $elem['NAME'],
            'CODE' => $elem['SYMB'],
            'IBLOCK_SECTION_ID' => $sectionID,
            'PROPERTY_VALUES' => $PROP,
            'PREVIEW_TEXT' => $elem['PREVIEW_TEXT'],
            'PREVIEW_PICTURE' => \CFile::MakeFileArray('/local/images/' . $elem['PREVIEW_PICTURE']),
            'DETAIL_TEXT' => $elem['DETAIL_TEXT'],
            'DETAIL_PICTURE' => \CFile::MakeFileArray('/local/images/' . $elem['DETAIL_PICTURE'])
        );

        $flag = true;
        foreach ($arraySC as $value) {
            if ($value['CODE'] == $elem['SYMB']) {
                UpdateGoods($ibe, $elem, $arFields, $value);
                \CIBlockElement::SetPropertyValuesEx($value['ID'], IBLOCK_WEAR_ID, array('GALLERY' => $galleryArr));
                $flag = false;
                break;
            }
        }
        if ($flag) {
            if ($ID = $ibe->Add($arFields)) {
                AddGoodsPriceAndQuantity($ID, $elem);
                \CIBlockElement::SetPropertyValuesEx($ID, IBLOCK_WEAR_ID, array('GALLERY' => $galleryArr));
            } else {
                echo 'Error: ' . $ibe->LAST_ERROR . '<br>';
            }
        }
    }
}

/**
 * Получить массив имен и идентификаторов разделов инфоблока
 * @return array
 */
function getSectionListFromInfoblock()
{
    $sectionList = Array();

    $arFilter = Array('IBLOCK_ID' => IBLOCK_WEAR_ID);
    $arSelect = Array('ID', 'NAME');
    $dbList = \CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);
    while ($arResult = $dbList->Fetch()) {
        $sectionList[] = Array(
            'ID' => $arResult['ID'],
            'NAME' => $arResult['NAME']
        );
    }

    return $sectionList;
}

/**
 * Получить ID раздела товара
 * @param string $sec Строка с иерархией разделов товара (разделены '-')
 * @param array $sectionList Массив имен и ID разделов инфоблока
 * @return int
 */
function getSectionId($sec, $sectionList)
{
    $explodeSec = explode('-', $sec);
    $secid = 0;

    $possibleSections = Array();
    foreach ($sectionList as $section) {
        if ($section['NAME'] == $explodeSec[count($explodeSec) - 1]) {
            $possibleSections[] = $section['ID'];
        }
    }

    $arrPath = Array();
    foreach ($possibleSections as $value) {
        $nav = \CIBlockSection::GetNavChain(IBLOCK_WEAR_ID, $value, Array('NAME', 'ID'));
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

/**
 * Получить массив данных из файла для дальнейшего импорта
 * @return array
 */
function readDataFromFile()
{
    $datarr = Array();

    if (($handle = fopen('goods.csv', 'r')) !== false) {
        $counterKeys = 0;
        $counterElements = 0;
        $keys = array(
            'SYMB',
            'NAME',
            'SECTION',
            'QUANTITY',
            'PRICE',
            'COUNTRY',
            'BRAND',
            'PREVIEW_TEXT',
            'PREVIEW_PICTURE',
            'DETAIL_TEXT',
            'DETAIL_PICTURE',
            'GALLERY'
        );

        while (($data = fgetcsv($handle, 0, '\n')) !== false) {
            if ($counterElements !== 0) {
                foreach ($data as $value) {
                    $elements = explode(';', $value);
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

/**
 * Получить массив с кодами и id товаров из инфоблока
 * @return array
 */
function getElementsCodeAndIdFromInfoblock()
{
    $arraySC = Array();
    $arSelect = Array('CODE', 'ID');
    $res = \CIBlockElement::GetList(Array(), Array('IBLOCK_ID' => IBLOCK_WEAR_ID), false, false, $arSelect);
    while ($ob = $res->Fetch()) {
        $arraySC[] = Array('CODE' => $ob['CODE'], 'ID' => $ob['ID']);
    }
    return $arraySC;
}

function main()
{
    \CModule::IncludeModule('iblock');
    $datarr = readDataFromFile();
    $arraySC = getElementsCodeAndIdFromInfoblock();
    addOrUpdateElement($arraySC, $datarr);
}

main();

?>