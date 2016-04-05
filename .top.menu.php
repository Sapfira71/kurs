<?
$aMenuLinks = Array(
    Array(
        'Главная страница',
        'index.php',
        Array(),
        Array(),
        '$_SERVER["REQUEST_URI"] !== "/" ? (!strripos($_SERVER["REQUEST_URI"], "index.php") ? ((!isset($_SERVER["REAL_FILE_PATH"]) || !strripos($_SERVER["REAL_FILE_PATH"], "index.php")) ? true : false) : false) : false'
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