<?
$arUrlRewrite = array(
    array(
        'CONDITION' => '#^/catalog/([\-a-zA-Z]+)/#',
        'RULE' => 'SECTION_ID=$1',
        'PATH' => '/index.php'
    ),
    array(
        'CONDITION' => '#^/goods/([\-a-zA-Z]+)/#',
        'RULE' => 'ELEMENT_ID=$1',
        'PATH' => '/index.php'
    )
);

?>