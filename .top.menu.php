<?
$aMenuLinks = Array(
    Array(
        'Главная страница',
        'index.php',
        Array(),
        Array(),
        '!strripos($APPLICATION->GetCurUri("", true), "index.php") ? (!strripos($_SERVER["REAL_FILE_PATH"], "index.php") ? "1" : "0") : "0"'
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