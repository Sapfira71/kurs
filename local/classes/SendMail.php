<?php

namespace Maximaster\Classes;

/**
 * ����� �������� ��������� � ������
 * Class SendMail
 * @package Maximaster\Classes
 */
class SendMail
{
    /**
     * ������� �������� ��������� � ����������� � ������
     * @param Order $order ������ ������ Order, ���������� ����������� ���������� � ������ ��� ��������
     * @return bool|int ���������� ��������, ��������������� �� ����������/������������ �������� ���������
     */
    public static function sendMail(Order $order)
    {
        $to = $order->email;
        $message = '���� ���: ' . $order->fio . '. �������: ' . $order->tel . '. �����: ' . $order->email . '. ';
        $message .= '�������� ������: ' . $order->elementInfo['NAME'] . '. ����: ' . $order->elementInfo['PRICE'];
        $message .= '. �����: ' . $order->elementInfo['BRAND'] . '. ������: ' . $order->elementInfo['COUNTRY'];
        $message .= '. ������ �� �����: ' . $order->elementInfo['DETAIL_PAGE_URL'] . '.';

        $arEventFields = array(
            'FROM_EMAIL' => htmlspecialcharsEx('a.morozova@maximaster.ru'),
            'MESSAGE' => htmlspecialcharsEx($message),
            'TO_EMAIL' => htmlspecialcharsEx($to)
        );

        return \CEvent::Send('ORDER_INFO', 's1', $arEventFields);
    }
}