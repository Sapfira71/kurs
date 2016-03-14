<?
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

        $rsData = $entityDataClass::getList(array(
            "select" => array('UF_NAME', 'UF_XML_ID'),
            "filter" => array('=UF_XML_ID' => $xml_id)
        ));
        $rsData = new CDBResult($rsData, $entityTableName);
        if ($arRes = $rsData->Fetch()) {
            $namebrand = $arRes['UF_NAME'];
        }
        return $namebrand;
    }

    public function readElementInfo($elementID)
    {
        CModule::IncludeModule('iblock');
        $arElement = Array();

        $arFilter = Array(
            "IBLOCK_ID" => IBLOCK_CATALOG_ID
        );

        if (!empty($elementID)) {
            $arFilter['ID'] = $elementID;
        }

        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, Array());

        while ($ob = $res->GetNextElement())
        {
            $ar_res = $ob->GetFields();
            $ar_res["PROPERTIES"] = $ob->GetProperties();

            $arPict = Array();
            $temp = CIBlockElement::GetProperty(IBLOCK_CATALOG_ID, $ar_res['ID'], array(), Array("CODE"=>"GALLERY"));
            while ($ob_res = $temp->GetNext()) {
                $arPict[] = CFile::GetPath($ob_res['VALUE']);
            }

            $arElement[] = array(
                'NAME' => $ar_res["NAME"],
                'PRICE' => $this->getPrice($ar_res['ID']),
                'DET_D' => $ar_res["DETAIL_TEXT"],
                'DET_P' => CFile::GetPath($ar_res["DETAIL_PICTURE"]),
                'BRAND' => $this->getBrandName($ar_res["PROPERTIES"]["BRAND"]["VALUE"]),
                'COUNTRY' => $ar_res["PROPERTIES"]["COUNTRY"]["VALUE"],
                'QUANTITY' => $this->getQuantity($ar_res['ID']),
                'GALLERY' => $arPict,
                'DET_PAGE' => $ar_res['DETAIL_PAGE_URL']
            );
        }

        return $arElement;
    }

    public function executeComponent()
    {
        if (!empty($_REQUEST["ELEMENT_ID"])) {
            $this->arResult['element'] = $this->readElementInfo($_REQUEST["ELEMENT_ID"]);
        } else {
            return;
        }

        $this->includeComponentTemplate();
        return $this->arResult["element"];
    }
}