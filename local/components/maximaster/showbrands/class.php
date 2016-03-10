<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

class CShowBrands extends CBitrixComponent
{
    public function getBrands()
    {
        $res = Array();

        CModule::IncludeModule("highloadblock");

        $hlblock = HL\HighloadBlockTable::getById(ID_BRAND_INFOBLOCK)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        $entity_table_name = $hlblock['Brand'];

        $sTableID = 'tbl_' . $entity_table_name;
        $rsData = $entity_data_class::getList(array(
            "select" => array('UF_NAME', 'UF_XML_ID')
        ));
        $rsData = new CDBResult($rsData, $sTableID);
        while ($arRes = $rsData->Fetch()) {
            $res[] = Array(
                'NAME' => $arRes['UF_NAME'],
                'XML_ID' => $arRes['UF_XML_ID']
            );
        }

        return $res;
    }
}