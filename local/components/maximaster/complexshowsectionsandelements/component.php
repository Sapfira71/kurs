<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arDefaultUrlTemplates404 = array(
    'sections' => 'catalog/#SECTION_CODE_PATH#/index.php?SECTION_ID=#SECTION_ID#',
    'element' => 'goods/#SECTION_CODE_PATH#/index.php?ELEMENT_ID=#ELEMENT_ID#',
    'brand' => 'index.php?BRAND_ID=#BRAND_ID#'
);

$engine = new \CComponentEngine($this);
$engine->addGreedyPart('#SECTION_CODE_PATH#');

$arVariables = array();
$page = $engine->guessComponentPath('/', $arDefaultUrlTemplates404, $arVariables);

$this->IncludeComponentTemplate($page);