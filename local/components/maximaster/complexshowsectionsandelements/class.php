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
            'sections' => 'catalog/#SECTION_CODE_PATH#/#SECTION_ID#/',
            'element' => 'catalog/#SECTION_CODE_PATH#/#CODE#.php',
            'brand' => 'brands/#BRAND_NAME#/'
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
            $this->arResult['SECTION_PATH'] = $request['SECTION_PATH'];
        }
        else if(isset($request['CODE'])) {
            $this->arResult['CODE'] = $request['CODE'];
            $this->arResult['SECTION_PATH'] = $request['SECTION_PATH'];
        }
        else if(isset($request['BRAND_NAME'])) {
            $this->arResult['BRAND_NAME'] = $request['BRAND_NAME'];
        } else {
            return;
        }

        $this->IncludeComponentTemplate($this->getPage());
    }

}