<?
$arUrlRewrite = array(
    array(
        'CONDITION' => '#^/catalog/([\/\-a-zA-Z]+)/([0-9]+)/#',
        'RULE' => 'SECTION_ID=$2',
        'PATH' => '/index.php'
    ),
    array(
        'CONDITION' => '#^/goods/([\/\-a-zA-Z]+)/([\-a-zA-Z]+).php#',
        'RULE' => 'ELEMENT_CODE=$2',
        'PATH' => '/index.php'
    )
);

?>