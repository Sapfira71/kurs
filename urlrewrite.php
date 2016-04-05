<?
$arUrlRewrite = array(
    array(
        'CONDITION' => '#^/catalog/([\/\-a-zA-Z]+)/([0-9]+)/#',
        'RULE' => 'SECTION_ID=$2',
        'PATH' => '/index.php'
    ),
    array(
        'CONDITION' => '#^/catalog/([\/\-a-zA-Z]+)/([\-_a-zA-Z0-9]+).php#',
        'RULE' => 'CODE=$2',
        'PATH' => '/index.php'
    ),
    array(
        'CONDITION' => '#^/brands/([\-_a-zA-Z]+)/#',
        'RULE' => 'BRAND_NAME=$1',
        'PATH' => '/index.php'
    )
);

?>