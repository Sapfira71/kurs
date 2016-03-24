<?php

namespace Maximaster\Classes;

/**
 * Класс отправки сообщения о заказе
 * Class SendMail
 * @package Maximaster\Classes
 */
class SendMail
{
    /**
     * Функция отправки сообщения с информацией о заказе
     * @param Order $order Объект класса Order, содержащий необходимую информацию о заказе для отправки
     * @return bool|int Возвращает значение, сигнализирующее об успешности/неуспешности отправки сообщения
     */
    public static function sendMail(Order $order)
    {
        $to = $order->email;
        $message = 'Ваше имя: ' . $order->fio . '. Телефон: ' . $order->tel . '. Почта: ' . $order->email . '. ';
        $message .= 'Название товара: ' . $order->elementInfo['NAME'] . '. Цена: ' . $order->elementInfo['PRICE'];
        $message .= '. Бренд: ' . $order->elementInfo['BRAND'] . '. Страна: ' . $order->elementInfo['COUNTRY'];
        $message .= '. Ссылка на товар: ' . $order->url . '.';

        $arEventFields = array(
            'FROM_EMAIL' => htmlspecialcharsEx('a.morozova@maximaster.ru'),
            'MESSAGE' => htmlspecialcharsEx($message),
            'TO_EMAIL' => htmlspecialcharsEx($to)
        );

        return \CEvent::Send('ORDER_INFO', 's1', $arEventFields);
    }
}