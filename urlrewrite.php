<?
$arUrlRewrite = array(
    array(
        'CONDITION' => '#^/catalog/([\/\-a-zA-Z]+)/([0-9]+)/#',
        'RULE' => 'SECTION_PATH=$1&SECTION_ID=$2',
        'PATH' => '/index.php'
    ),
    array(
        'CONDITION' => '#^/catalog/([\/\-a-zA-Z]+)/([\-_a-zA-Z0-9]+).php#',
        'RULE' => 'SECTION_PATH=$1&CODE=$2',
        'PATH' => '/index.php'
    ),
    array(
        'CONDITION' => '#^/brands/([\-_a-zA-Z]+)/#',
        'RULE' => 'BRAND_CODE=$1',
        'PATH' => '/index.php'
    )
);

?>