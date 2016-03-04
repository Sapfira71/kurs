<?php

require __DIR__ . '/const.php';

function selfURL()
{
    $url = ($_SERVER["HTTPS"] != 'on') ? 'http://' . $_SERVER["SERVER_NAME"] : 'https://'
        . $_SERVER["SERVER_NAME"];
    $url .= ($_SERVER["SERVER_PORT"] != 80) ? ":" . $_SERVER["SERVER_PORT"] : "";
    $url .= $_SERVER["REQUEST_URI"];
    return $url;
}

function sendMessage($elemID)
{

}

function setCookies()
{
    global $APPLICATION;
    $APPLICATION->set_cookie("name", $_POST['name'], time() + 60 * 5);
    $APPLICATION->set_cookie("number", $_POST['number'], time() + 60 * 5);
    $APPLICATION->set_cookie("mail", $_POST['mail'], time() + 60 * 5);

    print_r($_POST);
    print_r($_COOKIE);
}