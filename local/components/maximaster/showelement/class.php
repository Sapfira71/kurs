<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Highloadblock as HL;

class CShowElement extends CBitrixComponent
{
    private function getPrice($id)
    {
        $res = 0;

        $price = CPrice::GetList(Array(), Array(
            'PRODUCT_ID' => $id,
            'CATALOG_GROUP_ID' => ID_TYPE_PRICE_BASE
        ), false, false, Array('PRICE'));

        if ($arPrice = $price->Fetch()) {
            $res = $arPrice['PRICE'];
        }

        return $res;
    }

    private function getQuantity($id)
    {
        $res = 0;

        $quantity = CCatalogProduct::GetList(Array(), Array(
            'PRODUCT_ID' => $id,
        ), false, false, Array('QUANTITY'));

        if ($arQuantity = $quantity->Fetch()) {
            $res = $arQuantity['QUANTITY'];
        }

        return $res;
    }

    private function getBrandName($xml_id)
    {
        CModule::IncludeModule("highloadblock");

        $namebrand = "";

        $hlblock = HL\HighloadBlockTable::getById(ID_BRAND_INFOBLOCK)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entityDataClass = $entity->getDataClass();
        $entityTableName = $hlblock['Brand'];

        $sTableID = 'tbl_' . $entity_table_name;
        $rsData = $entity_data_class::getList(array(
            "select" => array('UF_NAME', 'UF_XML_ID'),
            "filter" => array('=UF_XML_ID' => $xml_id)
        ));
        $rsData = new CDBResult($rsData, $sTableID);
        while ($arRes = $rsData->Fetch()) {
            if ($arRes['UF_XML_ID'] == $xml_id) {
                $namebrand = $arRes['UF_NAME'];
                break;
            }
        }
        return $namebrand;
    }

    public function readElementInfo($elementID, $brandID)
    {
        CModule::IncludeModule('iblock');
        $arElement = Array();

        $arFilter = Array(
            "IBLOCK_ID" => IBLOCK_CATALOG_ID
        );

        if(!empty($elementID)) {
            $arFilter['ID'] = $elementID;
        }
        if(!empty($brandID)) {
            $arFilter['PROPERTY_BRAND'] = $brandID;
        }

        $arSelect = Array(
            'NAME',
            'DETAIL_TEXT',
            'DETAIL_PICTURE',
            'PROPERTY_BRAND',
            'PROPERTY_COUNTRY',
            'ID',
            'GALLERY'
        );

        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while ($ob = $res->Fetch()) {
            $arElement[] = array(
                'NAME' => $ob["NAME"],
                'PRICE' => $this->getPrice($ob['ID']),
                'DET_D' => $ob["DETAIL_TEXT"],
                'DET_P' => CFile::GetPath($ob["DETAIL_PICTURE"]),
                'BRAND' => $this -> getBrandName($ob["PROPERTY_BRAND_VALUE"]),
                'COUNTRY' => $ob["PROPERTY_COUNTRY_VALUE"],
                'QUANTITY' => $this->getQuantity($ob['ID']),
                'GALLERY' => $ob['GALLERY']
            );
        }

        return $arElement;
    }

    public function executeComponent()
    {
        if (!empty($_REQUEST["ELEMENT_ID"]) || !empty($_REQUEST["BRAND_ID"])) {
            $this->arResult['element'] = $this->readElementInfo($_REQUEST["ELEMENT_ID"], $_REQUEST["BRAND_ID"]);
        } else {
            return;
        }
        $this->includeComponentTemplate();
        return $this->arResult["element"];
    }
}