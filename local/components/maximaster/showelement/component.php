<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

if (empty($_REQUEST["ELEMENT_ID"])) {
    return;
}

$arResult['element'] = $this->readElementInfo($_REQUEST["ELEMENT_ID"]);

$this->includeComponentTemplate();
?>