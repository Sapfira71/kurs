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

function setCookies()
{
    global $APPLICATION;
    $APPLICATION->set_cookie("name", $_POST['name'], time() + 60 * 5);
    $APPLICATION->set_cookie("number", $_POST['number'], time() + 60 * 5);
    $APPLICATION->set_cookie("mail", $_POST['mail'], time() + 60 * 5);
}

function sendMessage($id)
{
    setCookies();

    CBitrixComponent::includeComponentClass("maximaster:showelement");
    $ob = new CShowElement();
    $arEl = $ob->readElementInfo($id);

    $to = $_POST['mail'];
    $message = "Ваше имя: " . $_POST['name'] . ". Телефон: " . $_POST['number'] . ". Почта: " . $_POST['mail'] . ". ";
    $message .= $arEl['NAME'] . ". " . $arEl['PRICE'] . ". " . $arEl['BRAND'] . ". " . $arEl['COUNTRY'];
    /*$message = wordwrap($message, 70, "\r\n");*/
    echo $message;
    if (mail($to, "Your order", $message)) {
        echo "<br>" . "Письмо отправлено успешно!" . "<br>";
    }
}