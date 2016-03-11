<?

$condition = "strripos(\$_SERVER['SCRIPT_FILENAME'], 'index.php')==false";

$aMenuLinks = Array(
    Array(
        "Главная страница",
        "index.php",
        Array(),
        Array(),
        $condition
    ),
    Array(
        "О себе",
        "about.php",
        Array(),
        Array(),
        ""
    ),
    Array(
        "Контакты",
        "contacts.php",
        Array(),
        Array(),
        ""
    )
);