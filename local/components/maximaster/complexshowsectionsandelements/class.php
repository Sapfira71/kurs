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
     * �������� ��� ������� �������
     * @return string
     */
    private function getPage() {
        $arDefaultUrlTemplates404 = array(
            'sections' => 'catalog/#SECTION_CODE_PATH#/#SECTION_ID#/',
            'element' => 'goods/#SECTION_CODE_PATH#/#CODE#.php',
            'brand' => 'index.php?BRAND_ID=#BRAND_ID#'
        );

        $engine = new \CComponentEngine($this);
        $engine->addGreedyPart('#SECTION_CODE_PATH#');

        $arVariables = array();
        $page = $engine->guessComponentPath('/', $arDefaultUrlTemplates404, $arVariables);

        return $page;
    }

    /**
     * ���������� ����������
     */
    public function executeComponent()
    {
        $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
        var_dump($request);
        if(isset($request['SECTION_ID'])) {
            $this->arResult['SECTION_ID'] = $request['SECTION_ID'];
        }
        else if(isset($request['ELEMENT_ID'])) {
            $this->arResult['ELEMENT_ID'] = $request['ELEMENT_ID'];
        }
        else if(isset($request['BRAND_ID'])) {
            $this->arResult['BRAND_ID'] = $request['BRAND_ID'];
        } else {
            return;
        }

        $this->IncludeComponentTemplate($this->getPage());
    }

}