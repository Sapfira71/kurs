<?
namespace Maximaster\Components;

use Bitrix\Highloadblock as HL;

/**
 * Компонент показа информации о разделе и списка элементов в нем
 * Class ShowSections
 * @package Maximaster\Components
 */
class ShowSections extends \CBitrixComponent
{
    /**
     * Функция, считывающая из инфоблока информацию о разделе
     * @param int $sectionId Идентификатор раздела
     * @return array
     */
    private function readSectionInfo($sectionId, $sectionPath)
    {
        $res = Array();
        $sectionCode = explode('/', $sectionPath);

        $arFilter = Array(
            'IBLOCK_ID' => IBLOCK_WEAR_ID,
            'ID' => $sectionId,
            'CODE' => $sectionCode[count($sectionCode) - 1]
        );
        $arSelect = Array(
            'NAME',
            'ELEMENT_CNT',
            'DESCRIPTION',
            'PICTURE'
        );
        $secList = \CIBlockSection::GetList(Array(), $arFilter, true, $arSelect);

        if ($sec = $secList->Fetch()) {
            $res = Array(
                'NAME' => $sec['NAME'],
                'ELEMENT_CNT' => $sec['ELEMENT_CNT'],
                'DESCRIPTION' => $sec['DESCRIPTION'],
                'IMAGE' => \CFile::GetPath($sec['PICTURE'])
            );
        } else {
            @define('ERROR_404', 'Y');
        }

        return $res;
    }

    /**
     * Получение элементов инфоблока
     * @param array $filter Фильтрующий массив
     * @return array
     */
    public function getElements($filter)
    {
        $res = Array();

        $arSelect = Array(
            'NAME',
            'PREVIEW_TEXT',
            'PREVIEW_PICTURE',
            'ID',
            'CATALOG_GROUP_' . PRICE_TYPE_BASE_ID,
            'DETAIL_PAGE_URL'
        );

        $listElements = \CIBlockElement::GetList(Array(), $filter, false, false, $arSelect);

        while ($ob = $listElements->GetNext()) {
            $price = \CCurrencyLang::CurrencyFormat($ob['CATALOG_PRICE_' . PRICE_TYPE_BASE_ID],
                $ob['CATALOG_CURRENCY_' . PRICE_TYPE_BASE_ID]);

            $arProduct = array(
                'NAME' => $ob['NAME'],
                'ID' => $ob['ID'],
                'PRICE' => $price,
                'PREVIEW_TEXT' => $ob['PREVIEW_TEXT'],
                'PREVIEW_PICTURE' => \CFile::GetPath($ob['PREVIEW_PICTURE']),
                'DETAIL_URL' => $ob['DETAIL_PAGE_URL']
            );

            $res[] = $arProduct;
        }

        return $res;
    }

    /**
     * Получение элементов инфоблока по параметру фильтра SECTION_ID
     * @param int $sectionId Идентификатор раздела
     * @return array
     */
    private function readSectionElementsInfo($sectionId)
    {
        $arFilter = Array(
            'IBLOCK_ID' => IBLOCK_WEAR_ID,
            'SECTION_ID' => $sectionId,
            'INCLUDE_SUBSECTIONS' => 'Y'
        );

        return $this->getElements($arFilter);
    }

    /**
     * Получение элементов инфоблока по параметру фильтра BRAND_ID
     * @param string $brandName Имя бренда
     * @return array
     */
    private function readBrandElementsInfo($brandName)
    {
        $arFilter = Array(
            'IBLOCK_ID' => IBLOCK_WEAR_ID,
            'PROPERTY_BRAND' => $this->getBrandId($brandName)
        );

        return $this->getElements($arFilter);
    }

    /**
     * Получить id бренда по имени
     * @param string $brandName Имя бренда
     * @return string
     */
    private function getBrandId($brandName)
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
     * Выполнение компонента
     */
    public function executeComponent()
    {
        if (!empty($this->arParams['SECTION_ID'])) {
            $this->arResult['section'] = $this->readSectionInfo(
                $this->arParams['SECTION_ID'],
                $this->arParams['SECTION_PATH']
            );
            $this->arResult['elements'] = $this->readSectionElementsInfo($this->arParams['SECTION_ID']);
        } elseif (!empty($this->arParams['BRAND_NAME'])) {
            $this->arResult['elements'] = $this->readBrandElementsInfo($this->arParams['BRAND_NAME']);
            if (empty($this->arResult['elements'])) {
                @define('ERROR_404', 'Y');
            }
        } else {
            return;
        }

        $this->includeComponentTemplate();
    }
}