<?php

require __DIR__ . '/const.php';

/**
 * Функция возвращает URL страницы
 *
 * @return string
 */
function selfURL()
{
    $url = ($_SERVER['HTTPS'] != 'on') ? 'http://' . $_SERVER['SERVER_NAME'] : 'https://'
        . $_SERVER['SERVER_NAME'];
    $url .= ($_SERVER['SERVER_PORT'] != 80) ? ':' . $_SERVER['SERVER_PORT'] : '';
    $url .= $_SERVER['REQUEST_URI'];
    return $url;
}

/**
 * Установка куки
 */
function setCookies()
{
    global $APPLICATION;
    $APPLICATION->set_cookie('name', $_POST['name'], time() + 60 * 5);
    $APPLICATION->set_cookie('number', $_POST['number'], time() + 60 * 5);
    $APPLICATION->set_cookie('mail', $_POST['mail'], time() + 60 * 5);
}

/**
 * Отправка почтового сообщения
 * @param int $id Идентификатор товара
 * @return bool Успешна или неуспешна отправка
 */
function sendMessage($id)
{
    setCookies();

    CBitrixComponent::includeComponentClass('maximaster:showelement');
    $ob = new Maximaster\Components\ShowElement();
    $arEl = $ob->readElementInfo($id);

    $to = $_POST['mail'];
    $message = 'Ваше имя: ' . $_POST['name'] . '. Телефон: ' . $_POST['number'] . '. Почта: ' . $_POST['mail'] . '. ';
    $message .= $arEl['NAME'] . '. ' . $arEl['PRICE'] . '. ' . $arEl['BRAND'] . '. ' . $arEl['COUNTRY'];

    $arEventFields = array(
        'FROM_EMAIL' => htmlspecialcharsEx('a.morozova@maximaster.ru'),
        'MESSAGE' => htmlspecialcharsEx($message),
        'TO_EMAIL' => htmlspecialcharsEx($to)
    );

    if (\CEvent::Send('ORDER_INFO', 's1', $arEventFields)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Функция возвращает URL страницы покупки товара
 * @param int $id Идентификатор товара
 * @return string
 */
function getBuyElementURL($id)
{
    return '/purchase.php?ELEMENT_ID=' . $id;
}

/**
 * Функция возвращает URL страницы просмотра списка товаров бренда
 * @param string $id Идентификатор бренда
 * @return string
 */
function getBrandsElementsURL($id)
{
    return '/index.php?BRAND_ID=' . $id;
}