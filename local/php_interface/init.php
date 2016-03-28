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

//Обработка ошибки 404
AddEventHandler('main', 'OnEpilog', 'OnEpilogHandler');
function OnEpilogHandler()
{
    if(defined('ERROR_404') && ERROR_404 == 'Y')
    {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        CHTTP::SetStatus('404 Not Found');
        include $_SERVER['DOCUMENT_ROOT'].'/404.php';
    }
}

//Подключение своих классов (Order - для сохранения заказа, SendMail - для отправки письма с информацией о заказе)
CModule::AddAutoloadClasses(
    '',
    array(
        'Order' => '/local/classes/Order.php',
        'SendMail' => '/local/classes/SendMail.php',
    )
);