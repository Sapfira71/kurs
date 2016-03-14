<?
use Bitrix\Highloadblock as HL;

class CShowBrands extends CBitrixComponent
{
    private function getListCurrentBrands()
    {
        $result = Array();

        CModule::IncludeModule('iblock');

        $arFilter = Array(
            "IBLOCK_ID" => IBLOCK_CATALOG_ID
        );
        if (!empty($_REQUEST['SECTION_ID'])) {
            $arFilter = Array(
                'SECTION_ID' => $_REQUEST['SECTION_ID'],
                'INCLUDE_SUBSECTIONS' => 'Y'
            );
        }
        if (!empty($_REQUEST['ELEMENT_ID'])) {
            $arFilter['ID'] = $_REQUEST['ELEMENT_ID'];
        }
        if (!empty($_REQUEST['BRAND_ID'])) {
            $arFilter['PROPERTY_BRAND'] = $_REQUEST['BRAND_ID'];
        }
        $arSelect = Array(
            'PROPERTY_BRAND'
        );

        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while ($ob = $res->Fetch()) {
            $result[] = $ob['PROPERTY_BRAND_VALUE'];
        }

        return $result;
    }

    public function getBrands()
    {
        $res = Array();
        $listCurrentBr = $this->getListCurrentBrands();

        CModule::IncludeModule("highloadblock");

        $hlblock = HL\HighloadBlockTable::getById(ID_BRAND_INFOBLOCK)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entityDataClass = $entity->getDataClass();
        $entityTableName = $hlblock['Brand'];

        $rsData = $entityDataClass::getList(array(
            "select" => array('UF_NAME', 'UF_XML_ID')
        ));
        $rsData = new CDBResult($rsData, $entityTableName);

        while ($arRes = $rsData->Fetch()) {
            if (empty($_REQUEST['BRAND_ID']) && empty($_REQUEST['SECTION_ID']) && empty($_REQUEST['ELEMENT_ID'])) {
                $res[] = Array(
                    'NAME' => $arRes['UF_NAME'],
                    'XML_ID' => $arRes['UF_XML_ID']
                );
            } else {
                foreach ($listCurrentBr as $br) {
                    if ($arRes['UF_XML_ID'] == $br) {
                        $res[] = Array(
                            'NAME' => $arRes['UF_NAME'],
                            'XML_ID' => $arRes['UF_XML_ID']
                        );
                        break;
                    }
                }
            }
        }

        return $res;
    }

    public function executeComponent()
    {
        $this->arResult["brands"] = $this->getBrands();
        $this->includeComponentTemplate();

        return $this->arResult["brands"];
    }
}