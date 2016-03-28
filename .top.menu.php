<?
$aMenuLinks = Array(
    Array(
        'Главная страница',
        'index.php',
        Array(),
        Array(),
        '$_SERVER["REQUEST_URI"]!=="/" ? (strripos($_SERVER["REQUEST_URI"], "index.php") == false ? true : false) : false'
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