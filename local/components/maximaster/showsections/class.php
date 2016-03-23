<?
namespace Maximaster\Components;

/**
 * ��������� ������ ���������� � ������� � ������ ��������� � ���
 * Class ShowSections
 * @package Maximaster\Components
 */
class ShowSections extends \CBitrixComponent
{
    /**
     * �������, ����������� �� ��������� ���������� � �������
     * @param int $sectionId ������������� �������
     * @return array
     */
    private function readSectionInfo($sectionId)
    {
        $res = Array();

        $arFilter = Array('IBLOCK_ID' => IBLOCK_WEAR_ID, 'ID' => $sectionId);
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
     * ��������� ��������� ���������
     * @param array $filter ����������� ������
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
     * ��������� ��������� ��������� �� ��������� ������� SECTION_ID
     * @param int $sectionId ������������� �������
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
     * ��������� ��������� ��������� �� ��������� ������� BRAND_ID
     * @param string $brandId ������� ��� �������� highload-����� '������'
     * @return array
     */
    private function readBrandElementsInfo($brandId)
    {
        $arFilter = Array(
            'IBLOCK_ID' => IBLOCK_WEAR_ID,
            'PROPERTY_BRAND' => $brandId
        );

        return $this->getElements($arFilter);
    }

    /**
     * ���������� ����������
     */
    public function executeComponent()
    {
        if (!empty($_REQUEST['SECTION_ID'])) {
            $this->arResult['section'] = $this->readSectionInfo($_REQUEST['SECTION_ID']);
            $this->arResult['elements'] = $this->readSectionElementsInfo($_REQUEST['SECTION_ID']);
        } elseif (!empty($_REQUEST['BRAND_ID'])) {
            $this->arResult['elements'] = $this->readBrandElementsInfo($_REQUEST['BRAND_ID']);
            if (empty($this->arResult['elements'])) {
                @define('ERROR_404', 'Y');
            }
        } else {
            return;
        }

        $this->includeComponentTemplate();
    }
}