<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

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

    public function readElementInfo($elementID)
    {
        CModule::IncludeModule('iblock');
        $arElement = Array();

        $arFilter = Array(
            "IBLOCK_ID" => IBLOCK_CATALOG_ID,
            "ID" => $elementID
        );
        $arSelect = Array(
            'NAME',
            'DETAIL_TEXT',
            'DETAIL_PICTURE',
            'PROPERTY_BRAND',
            'PROPERTY_COUNTRY',
            'ID'
        );

        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while ($ob = $res->Fetch()) {
            $arElement = array(
                'NAME' => $ob["NAME"],
                'PRICE' => $this->getPrice($ob['ID']),
                'DET_D' => $ob["DETAIL_TEXT"],
                'DET_P' => CFile::GetPath($ob["DETAIL_PICTURE"]),
                'BRAND' => $ob["PROPERTY_BRAND_VALUE"],
                'COUNTRY' => $ob["PROPERTY_COUNTRY_VALUE"],
                'QUANTITY' => $this->getQuantity($ob['ID'])
            );
        }

        return $arElement;
    }
}