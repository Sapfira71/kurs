<?
$condition = '0';

if ($_SERVER['REQUEST_URI'] == '/') {
    $condition = '0';
} else {
    $condition = strripos($_SERVER['REQUEST_URI'], 'index.php') == false ? '1' : '0';
}

$aMenuLinks = Array(
    Array(
        'Главная страница',
        'index.php',
        Array(),
        Array(),
        $condition
    ),
    Array(
        'О себе',
        'about.php',
        Array(),
        Array(),
        ''
    ),
    Array(
        'Контакты',
        'contacts.php',
        Array(),
        Array(),
        ''
    )
);