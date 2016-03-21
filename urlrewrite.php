<?
$arUrlRewrite = array(
    array(
        'CONDITION' => '#^/([\-a-zA-Z]+)/#',
        'RULE' => 'SECTION_ID=$1',
        'PATH' => '/index.php'
    )
);

?>