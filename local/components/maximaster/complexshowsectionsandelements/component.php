<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arDefaultUrlTemplates404 = array(
    'sections' => 'catalog/index.php?SECTION_ID=#SECTION_ID#',
    'element' => 'goods/index.php?ELEMENT_ID=#ELEMENT_ID#',
    'brand' => 'index.php?BRAND_ID=#BRAND_ID#'
);

$arVariables = array();
$page = CComponentEngine::ParseComponentPath('/', $arDefaultUrlTemplates404, $arVariables);

$this->IncludeComponentTemplate($page);