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
    private $arVariables = array();
    private $page;

    /**
     * �������, ��������������� �������� ����� $arVariables � $page ������ ComplexShowSectionsAndElements
     */
    private function Construct()
    {
        $arDefaultUrlTemplates404 = array(
            'sections' => 'catalog/section/#SECTION_CODE_PATH#/#SECTION_ID#/',
            'element' => 'catalog/detail/#CODE#.php',
            'brand' => 'catalog/brands/#BRAND_CODE#/'
        );

        $engine = new \CComponentEngine($this);
        $engine->addGreedyPart('#SECTION_CODE_PATH#');

        $this->page = $engine->guessComponentPath('/', $arDefaultUrlTemplates404, $this->arVariables);
        $this->setResult($this->arVariables);
    }

    /**
     * �������� ������ �������� �� �������
     * @return array
     */
    public function getVariables()
    {
        $this->Construct();
        return $this->arVariables;
    }

    /**
     * ��������� ��������������� �������
     * @param array $arVariables ������ � ���������������� �� ������������ ���� �����������
     */
    private function setResult($arVariables)
    {
        if (isset($arVariables['SECTION_ID'])) {
            $flag = $this->isRightSection($arVariables['SECTION_ID'], $arVariables['SECTION_CODE_PATH']);
            if ($flag) {
                $this->arResult['SECTION_ID'] = $arVariables['SECTION_ID'];
            } else {
                define('ERROR_404', 'Y');
            }
        } elseif (isset($arVariables['CODE'])) {
            $this->arResult['CODE'] = $arVariables['CODE'];
        } elseif (isset($arVariables['BRAND_CODE'])) {
            $this->arResult['BRAND_CODE'] = $arVariables['BRAND_CODE'];
        }
    }

    /**
     * ����������� ������������ ������ (������������� �� ������������� ������ �� ������� ����)
     * @param string $sectionId ������������� ������
     * @param string $sectionCodePath ���� �� ����� ������
     * @return bool
     */
    private function isRightSection($sectionId, $sectionCodePath)
    {
        $sectArr = explode('/', $sectionCodePath);
        $nav = \CIBlockSection::GetNavChain(IBLOCK_WEAR_ID, $sectionId, Array('CODE'));

        $navRes = array();
        foreach ($nav->arResult as $section) {
            $navRes[] = $section['CODE'];
        }

        if ($sectArr === $navRes) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * �������� ��� ������� �������
     * @return string
     */
    private function getPage()
    {
        return $this->page;
    }

    /**
     * ���������� ����������
     */
    public function executeComponent()
    {
        $this->Construct();
        $page = $this->getPage();

        if ($page) {
            $this->IncludeComponentTemplate($page);
        }
    }

}