<?
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
    )
);