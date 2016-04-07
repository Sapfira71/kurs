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
     * Получить параметры из запроса
     * @return array Параметры
     */
    private function getParameters()
    {
        $arDefaultUrlTemplates404 = array(
            'sections' => 'catalog/section/#SECTION_CODE_PATH#/#SECTION_ID#/',
            'element' => 'catalog/detail/#CODE#.php',
            'brand' => 'catalog/brands/#BRAND_CODE#/'
        );
        $engine = new \CComponentEngine();
        $engine->addGreedyPart('#SECTION_CODE_PATH#');

        $arVariables = array();
        $engine->guessComponentPath('/', $arDefaultUrlTemplates404, $arVariables);
        return $arVariables;
    }

    /**
     * Функция, получающая список значений свойства 'Бренд' элементов инфоблока
     * @return array
     */
    private function getListCurrentBrands()
    {
        $arVariables = $this->getParameters();
        $result = Array();

        \CModule::IncludeModule('iblock');

        $arFilter = Array(
            'IBLOCK_ID' => IBLOCK_WEAR_ID
        );

        if (!empty($arVariables['CODE'])) {
            $arFilter['CODE'] = $arVariables['CODE'];
        } elseif (!empty($arVariables['SECTION_ID'])) {
            $arFilter = Array(
                'SECTION_ID' => $arVariables['SECTION_ID'],
                'INCLUDE_SUBSECTIONS' => 'Y'
            );
        } elseif (!empty($arVariables['BRAND_CODE'])) {
            $arFilter['PROPERTY_BRAND'] = $arVariables['BRAND_CODE'];
        }

        $res = \CIBlockElement::GetList(Array(), $arFilter, array('PROPERTY_BRAND'), false, Array());
        while ($ob = $res->Fetch()) {
            $result[] = $ob['PROPERTY_BRAND_VALUE'];
        }

        return $result;
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
                'NAME' => $arRes['UF_NAME'],
                'CODE' => $arRes['UF_XML_ID']
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