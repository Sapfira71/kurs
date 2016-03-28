<?
namespace Maximaster\Components;

use Bitrix\Highloadblock as HL;

/**
 * Компонент показа информации о товаре
 * Class ShowElement
 * @package Maximaster\Components
 */
class ShowElement extends \CBitrixComponent
{
    /**
     * Получить имя бренда по внешнему коду
     * @param string $xmlId Значение свойства 'Бренд' (тип справочник) элемента инфоблока
     * @return string
     */
    private function getBrandName($xmlId)
    {
        \CModule::IncludeModule('highloadblock');

        $namebrand = '';

        $hlblock = HL\HighloadBlockTable::getById(HIGHLOADBLOCK_BRAND_ID)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entityDataClass = $entity->getDataClass();
        $entityTableName = $hlblock['Brand'];

        $rsData = $entityDataClass::getList(array(
            'select' => array('UF_NAME', 'UF_XML_ID'),
            'filter' => array('=UF_XML_ID' => $xmlId)
        ));
        $rsData = new \CDBResult($rsData, $entityTableName);
        if ($arRes = $rsData->Fetch()) {
            $namebrand = $arRes['UF_NAME'];
        }
        return $namebrand;
    }

    /**
     * Функция, формирующая массив с информацией об элементе инфоблока
     * @param int $elementID ID элемента, информацию о котором необходимо считать из инфоблока
     * @return array
     */
    public function readElementInfo($elementID)
    {
        \CModule::IncludeModule('iblock');
        $arElement = Array();

        $arFilter = Array(
            'IBLOCK_ID' => IBLOCK_WEAR_ID,
            'ID' => $elementID
        );

        $arSelect = Array(
            'NAME',
            'DETAIL_TEXT',
            'DETAIL_PICTURE',
            'PROPERTY_BRAND',
            'PROPERTY_COUNTRY',
            'ID',
            'PROPERTY_GALLERY',
            'CATALOG_QUANTITY',
            'DETAIL_PAGE_URL'
        );

        $res = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

        if ($ob = $res->GetNext()) {
            $arPict = Array();
            foreach ($ob['PROPERTY_GALLERY_VALUE'] as $pict) {
                $arPict[] = \CFile::GetPath($pict);
            }

            $arPrice = \CCatalogProduct::GetOptimalPrice($ob['ID']);
            $arResultPrice = $arPrice['RESULT_PRICE'];
            $price = \CCurrencyLang::CurrencyFormat($arResultPrice['DISCOUNT_PRICE'], $arResultPrice['CURRENCY']);

            $arElement = array(
                'NAME' => $ob['NAME'],
                'PRICE' => $price,
                'DETAIL_TEXT' => $ob['DETAIL_TEXT'],
                'DETAIL_PICTURE' => \CFile::GetPath($ob['DETAIL_PICTURE']),
                'BRAND' => $this->getBrandName($ob['PROPERTY_BRAND_VALUE']),
                'COUNTRY' => $ob['PROPERTY_COUNTRY_VALUE'],
                'QUANTITY' => $ob['CATALOG_QUANTITY'],
                'GALLERY' => $arPict,
                'BUY_PAGE' => getBuyElementURL($ob['ID']),
                'DETAIL_URL' => $ob['DETAIL_PAGE_URL']
            );
        } else {
            @define('ERROR_404', 'Y');
        }

        return $arElement;
    }

    /**
     * Выполнение компонента
     */
    public function executeComponent()
    {
        $this->IncludeComponentLang('template.php', 'ru');
        if (!empty($_REQUEST['ELEMENT_ID'])) {
            $this->arResult['element'] = $this->readElementInfo($_REQUEST['ELEMENT_ID']);
        } else {
            return;
        }

        $this->includeComponentTemplate();
    }
}