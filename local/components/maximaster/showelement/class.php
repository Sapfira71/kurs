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
            "IBLOCK_ID" => IBLOCK_WEAR_ID,
            'ID' => $elementID
        );

        $arSelect = Array(
            'NAME',
            'DETAIL_TEXT',
            'DETAIL_PICTURE',
            'PROPERTY_BRAND',
            'PROPERTY_COUNTRY',
            'ID',
            'PROPERTY_GALLERY'
        );

        $res = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

        if ($ob = $res->Fetch())
        {
            $arPict = Array();
            foreach ($ob['PROPERTY_GALLERY_VALUE'] as $pict) {
                $arPict[] = \CFile::GetPath($pict);
            }

            $arPrice = \CCatalogProduct::GetOptimalPrice($ob['ID']);
            $arResultPrice = $arPrice['RESULT_PRICE'];
            $price = $arResultPrice['DISCOUNT_PRICE'] . " " . $arResultPrice['CURRENCY'];

            $arElement[] = array(
                'NAME' => $ob["NAME"],
                'PRICE' => $price,
                'DET_D' => $ob["DETAIL_TEXT"],
                'DET_P' => \CFile::GetPath($ob["DETAIL_PICTURE"]),
                'BRAND' => $this->getBrandName($ob["PROPERTY_BRAND_VALUE"]),
                'COUNTRY' => $ob["PROPERTY_COUNTRY_VALUE"],
                'QUANTITY' => $this->getQuantity($ob['ID']),
                'GALLERY' => $arPict
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