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
    private function readSectionInfo($sectionId)
    {
        $res = Array();

        $arFilter = Array(
            'IBLOCK_ID' => IBLOCK_WEAR_ID,
            'ID' => $sectionId
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
     * Получение элементов инфоблока по параметру фильтра BRAND_CODE
     * @param string $brandCode Код бренда
     * @return array
     */
    private function readBrandElementsInfo($brandCode)
    {
        \CBitrixComponent::includeComponentClass('maximaster:showbrands');
        $arFilter = Array(
            'IBLOCK_ID' => IBLOCK_WEAR_ID,
            'PROPERTY_BRAND' => $brandCode
        );

        return $this->getElements($arFilter);
    }

    /**
     * Выполнение компонента
     */
    public function executeComponent()
    {
        $this->IncludeComponentLang('class.php');

        $issetSectionId = !empty($this->arParams['SECTION_ID']);
        $issetBrandCode = !empty($this->arParams['BRAND_CODE']);

        if ($issetSectionId) {
            $this->arResult['section'] = $this->readSectionInfo($this->arParams['SECTION_ID']);
            $this->arResult['elements'] = $this->readSectionElementsInfo($this->arParams['SECTION_ID']);
        } elseif ($issetBrandCode) {
            $this->arResult['elements'] = $this->readBrandElementsInfo($this->arParams['BRAND_CODE']);
            if (empty($this->arResult['elements'])) {
                @define('ERROR_404', 'Y');
            }
        } else {
            return;
        }

        $this->includeComponentTemplate();
    }
}