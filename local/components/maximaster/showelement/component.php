<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!empty($_REQUEST["ELEMENT_ID"]) || !empty($_REQUEST["BRAND_ID"])) {
    $arResult['element'] = $this->readElementInfo($_REQUEST["ELEMENT_ID"], $_REQUEST["BRAND_ID"]);
} else {
    return;
}

$this->includeComponentTemplate();
?>