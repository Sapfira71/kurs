<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$arResult['element'] = $this->readElementInfo($_REQUEST["ELEMENT_ID"], $_REQUEST["BRAND_ID"]);

$this->includeComponentTemplate();
?>