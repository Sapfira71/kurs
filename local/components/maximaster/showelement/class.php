<?
namespace Maximaster\Components;

use Bitrix\Highloadblock as HL;

class ShowElement extends \CBitrixComponent
{
    private function getPrice($id)
    {
        $res = 0;

        $price = \CPrice::GetList(Array(), Array(
            'PRODUCT_ID' => $id,
            'CATALOG_GROUP_ID' => TYPE_PRICE_BASE_ID
        ), false, false, Array('PRICE'));

        if ($arPrice = $price->Fetch()) {
            $res = $arPrice['PRICE'];
        }

        return $res;
    }

    private function getQuantity($id)
    {
        $res = 0;

        $quantity = \CCatalogProduct::GetList(Array(), Array(
            'PRODUCT_ID' => $id,
        ), false, false, Array('QUANTITY'));

        if ($arQuantity = $quantity->Fetch()) {
            $res = $arQuantity['QUANTITY'];
        }

        return $res;
    }

    private function getBrandName($xml_id)
    {
        \CModule::IncludeModule("highloadblock");

        $namebrand = "";

        $hlblock = HL\HighloadBlockTable::getById(HIGHLOADBLOCK_BRAND_ID)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entityDataClass = $entity->getDataClass();
        $entityTableName = $hlblock['Brand'];

        $rsData = $entityDataClass::getList(array(
            "select" => array('UF_NAME', 'UF_XML_ID'),
            "filter" => array('=UF_XML_ID' => $xml_id)
        ));
        $rsData = new \CDBResult($rsData, $entityTableName);
        if ($arRes = $rsData->Fetch()) {
            $namebrand = $arRes['UF_NAME'];
        }
        return $namebrand;
    }

    public function readElementInfo($elementID)
    {
        \CModule::IncludeModule('iblock');
        $arElement = Array();

        $arFilter = Array(
            "IBLOCK_ID" => IBLOCK_WEAR_ID
        );

        if (!empty($elementID)) {
            $arFilter['ID'] = $elementID;
        }

        $res = \CIBlockElement::GetList(Array(), $arFilter, false, false, Array());

        while ($ob = $res->GetNextElement())
        {
            $ar_res = $ob->GetFields();
            $ar_res["PROPERTIES"] = $ob->GetProperties();
            //var_dump($ar_res['PROPERTIES']['GALLERY']);die;
            $arPict = Array();
            $temp = \CIBlockElement::GetProperty(IBLOCK_WEAR_ID, $ar_res['ID'], array(), Array("CODE"=>"GALLERY"));
            foreach ($ar_res['PROPERTIES']['GALLERY']['VALUE'] as $pictureId) {
                $arPict[] = \CFile::GetPath($pictureId);
            }

            $arElement[] = array(
                'ID' => $ar_res["ID"],
                'NAME' => $ar_res["NAME"],
                'PRICE' => $this->getPrice($ar_res['ID']),
                'DETAIL_TEXT' => $ar_res["DETAIL_TEXT"],
                'DETAIL_PICTURE' => \CFile::GetPath($ar_res["DETAIL_PICTURE"]),
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
    }
}