<?
namespace Maximaster\Components;

/**
 * ����������� ���������, ����������� ��������� ������ ������ � �� ���������� �
 * ��������� ������ ���������� �� ����� ��������
 * Class ComplexShowSectionsAndElements
 * @package Maximaster\Components
 */
class ComplexShowSectionsAndElements extends \CBitrixComponent
{
    /**
     * ��������� ��������������� �������
     * @param array $arVariables ������ � ���������������� �� ������������ ���� �����������
     */
    public function setArResult($arVariables)
    {
        if (isset($arVariables['SECTION_ID'])) {
            $this->arResult['SECTION_ID'] = $arVariables['SECTION_ID'];
            $this->arResult['SECTION_PATH'] = $arVariables['SECTION_PATH'];
        } elseif (isset($arVariables['CODE'])) {
            $this->arResult['CODE'] = $arVariables['CODE'];
        } elseif (isset($arVariables['BRAND_CODE'])) {
            $this->arResult['BRAND_CODE'] = $arVariables['BRAND_CODE'];
        }
    }

    /**
     * �������� ��� ������� �������
     * @return string
     */
    private function getPage()
    {
        $arDefaultUrlTemplates404 = array(
            'sections' => 'catalog/section/#SECTION_CODE_PATH#/#SECTION_ID#/',
            'element' => 'catalog/detail/#CODE#.php',
            'brand' => 'catalog/brands/#BRAND_CODE#/'
        );

        $engine = new \CComponentEngine($this);
        $engine->addGreedyPart('#SECTION_CODE_PATH#');

        $arVariables = array();
        $page = $engine->guessComponentPath('/', $arDefaultUrlTemplates404, $arVariables);
        $this->setArResult($arVariables);

        return $page;
    }

    /**
     * ���������� ����������
     */
    public function executeComponent()
    {
        $page = $this->getPage();

        if($page) {
            $this->IncludeComponentTemplate($page);
        }
    }

}