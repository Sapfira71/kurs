<?
$arUrlRewrite = array(
    array(
        'CONDITION' => '#^/catalog/([\/\-a-zA-Z]+)/([0-9]+)/#',
        'RULE' => 'SECTION_ID=$2',
        'PATH' => '/index.php'
    ),
    array(
        'CONDITION' => '#^/goods/([\/\-a-zA-Z]+)/([\-_a-zA-Z0-9]+).php#',
        'RULE' => 'CODE=$2',
        'PATH' => '/index.php'
    )
);

?>