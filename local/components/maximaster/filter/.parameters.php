<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arComponentParameters = array(
    "GROUPS" => array(),
    "PARAMETERS" => array(
        "FILTER" => array(
            "PARENT" => ADDITIONAL_SETTINGS,
            "NAME" => "����������� ������",
            "TYPE" => "ARRAY",
            "MULTIPLE" => "N",
            "DEFAULT" => $_POST['myFilter'],
            "REFRESH" => "Y"
        ),
    )
);