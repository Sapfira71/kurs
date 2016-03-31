<?
namespace Maximaster\Components;

/**
 * Комплексный компонент, обединяющий компонент показа секции с ее элементами и
 * компонент показа информации об одном элементе
 * Class ComplexShowSectionsAndElements
 * @package Maximaster\Components
 */
class ComplexShowSectionsAndElements extends \CBitrixComponent
{
    /**
     * Получить имя нужного шаблона
     * @return string
     */
    private function getPage() {
        $arDefaultUrlTemplates404 = array(
            'sections' => 'catalog/#SECTION_CODE_PATH#/index.php?SECTION_ID=#SECTION_ID#',
            'element' => 'goods/#SECTION_CODE_PATH#/index.php?ELEMENT_ID=#ELEMENT_ID#',
            'brand' => 'index.php?BRAND_ID=#BRAND_ID#'
        );

        $engine = new \CComponentEngine($this);
        $engine->addGreedyPart('#SECTION_CODE_PATH#');

        $arVariables = array();
        $page = $engine->guessComponentPath('/', $arDefaultUrlTemplates404, $arVariables);

        return $page;
    }

    /**
     * Выполнение компонента
     */
    public function executeComponent()
    {
        $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
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