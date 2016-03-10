<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$arResult['brands'] = $this->getBrands();

$this->includeComponentTemplate();
?>