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
    public function setResult($arVariables)
    {
        if (isset($arVariables['SECTION_ID'])) {
            $flag = $this->isRightSection($arVariables['SECTION_ID'], $arVariables['SECTION_CODE_PATH']);
            if ($flag) {
                $this->arResult['SECTION_ID'] = $arVariables['SECTION_ID'];
            } else {
                @define('ERROR_404', 'Y');
            }
        } elseif (isset($arVariables['CODE'])) {
            $this->arResult['CODE'] = $arVariables['CODE'];
        } elseif (isset($arVariables['BRAND_CODE'])) {
            $this->arResult['BRAND_CODE'] = $arVariables['BRAND_CODE'];
        }
    }

    /**
     * Определение правильности секции (соответствует ли идентификатор секции по полному пути)
     * @param string $sectionId Идентификатор секции
     * @param string $sectionCodePath Путь из кодов секций
     * @return bool
     */
    public function isRightSection($sectionId, $sectionCodePath)
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
        $this->setResult($arVariables);

        return $page;
    }

    /**
     * Выполнение компонента
     */
    public function executeComponent()
    {
        $page = $this->getPage();

        if ($page) {
            $this->IncludeComponentTemplate($page);
        }
    }

}