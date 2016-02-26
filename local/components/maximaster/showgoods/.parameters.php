<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$arComponentParameters = array(
    "GROUPS" => array(),
    "PARAMETERS" => array(
        "FILTER" => array(
            "PARENT" => ADDITIONAL_SETTINGS,
            "NAME" => "Фильтрующий массив",
            "TYPE" => "ARRAY",
            "MULTIPLE" => "N",
            "DEFAULT" => $_POST['myFilter'],
            "REFRESH" => "Y"
        ),
        "IBLOCK_ID" => array(
            "PARENT" => ADDITIONAL_SETTINGS,
            "NAME" => "ID инфоблока",
            "TYPE" => "INT",
            "MULTIPLE" => "N",
            "DEFAULT" => 1,
            "REFRESH" => "Y"
        ),
        "FILTER_PARAMS" => array(
            "PARENT" => ADDITIONAL_SETTINGS,
            "NAME" => "Массив со значениями из формы фильтра",
            "TYPE" => "ARRAY",
            "MULTIPLE" => "N",
            "DEFAULT" => $_POST['filterParams'],
            "REFRESH" => "Y"
        ),
    )
);