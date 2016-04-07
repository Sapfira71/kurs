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
     * Установка результирующего массива
     * @param array $arVariables Массив с восстановленными из запрошенного пути переменными
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
     * Получить имя нужного шаблона
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
     * Выполнение компонента
     */
    public function executeComponent()
    {
        $page = $this->getPage();

        if($page) {
            $this->IncludeComponentTemplate($page);
        }
    }

}