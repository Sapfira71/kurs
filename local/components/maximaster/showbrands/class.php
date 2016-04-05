<?
namespace Maximaster\Components;

use Bitrix\Highloadblock as HL;

/**
 * Класс показа списка бредов
 * Class ShowBrands
 * @package Maximaster\Components
 */
class ShowBrands extends \CBitrixComponent
{
    /**
     * Функция, получающая список значений свойства 'Бренд' элементов инфоблока
     * @return array
     */
    private function getListCurrentBrands()
    {
        $result = Array();

        \CModule::IncludeModule('iblock');

        $arFilter = Array(
            'IBLOCK_ID' => IBLOCK_WEAR_ID
        );

        if (!empty($_REQUEST['CODE'])) {
            $arFilter['CODE'] = $_REQUEST['CODE'];
        } elseif (!empty($_REQUEST['SECTION_ID'])) {
            $arFilter = Array(
                'SECTION_ID' => $_REQUEST['SECTION_ID'],
                'INCLUDE_SUBSECTIONS' => 'Y'
            );
        } elseif (!empty($_REQUEST['BRAND_NAME'])) {
            $arFilter['PROPERTY_BRAND'] = $this->getBrandId($_REQUEST['BRAND_NAME']);
        }

        $res = \CIBlockElement::GetList(Array(), $arFilter, array('PROPERTY_BRAND'), false, Array());
        while ($ob = $res->Fetch()) {
            $result[] = $ob['PROPERTY_BRAND_VALUE'];
        }

        return $result;
    }

    /**
     * Получить id бренда по имени
     * @param string $brandName Имя бренда
     * @return string
     */
    public static function getBrandId($brandName)
    {
        \CModule::IncludeModule('highloadblock');

        $idbrand = '';

        $hlblock = HL\HighloadBlockTable::getById(HIGHLOADBLOCK_BRAND_ID)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entityDataClass = $entity->getDataClass();
        $entityTableName = $hlblock['Brand'];

        $rsData = $entityDataClass::getList(array(
            'select' => array('UF_NAME', 'UF_XML_ID'),
            'filter' => array('=UF_NAME' => $brandName)
        ));
        $rsData = new \CDBResult($rsData, $entityTableName);
        if ($arRes = $rsData->Fetch()) {
            $idbrand = $arRes['UF_XML_ID'];
        }
        return $idbrand;
    }

    /**
     * Функция, возвращающая массив, содержащий NAME брендов, товары которых должны отображаться в данный момент
     * @return array
     */
    public function getBrands()
    {
        $res = Array();
        $listCurrentBr = $this->getListCurrentBrands();

        \CModule::IncludeModule('highloadblock');

        $hlblock = HL\HighloadBlockTable::getById(HIGHLOADBLOCK_BRAND_ID)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entityDataClass = $entity->getDataClass();
        $entityTableName = $hlblock['Brand'];

        $rsData = $entityDataClass::getList(array(
            'select' => array('UF_NAME', 'UF_XML_ID'),
            'filter' => array('UF_XML_ID' => $listCurrentBr)
        ));
        $rsData = new \CDBResult($rsData, $entityTableName);

        while ($arRes = $rsData->Fetch()) {
            $res[] = Array(
                'NAME' => $arRes['UF_NAME']
            );
        }

        return $res;
    }

    /**
     * Выполнение компонента
     */
    public function executeComponent()
    {
        $this->arResult['brands'] = $this->getBrands();
        $this->includeComponentTemplate();
    }
}