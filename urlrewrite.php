<?
$arUrlRewrite = array(
    array(
        'CONDITION' => '#^/catalog/#',
        'RULE' => 'SECTION_ID=$1',
        'PATH' => '/index.php'
    ),
    array(
        'CONDITION' => '#^/goods/#',
        'RULE' => 'ELEMENT_ID=$1',
        'PATH' => '/index.php'
    )
);

?>