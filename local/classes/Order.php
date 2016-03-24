<?php

namespace Maximaster\Classes;

/**
 * Класс сохранения заказа в инфоблок
 * Class Order
 * @package Maximaster\Classes
 */
class Order
{
    public $fio = "";
    public $email = "";
    public $tel = "";
    public $url = "";
    private $elementId = 0;
    public $elementInfo = Array();

    /**
     * Конструктор класса сохранения заказа в инфоблок
     * @param string $fio ФИО заказчика
     * @param string $email Адрес электонной почты заказчика
     * @param string $tel Телефон заказчика
     * @param int $elementId Идентификатор заказываемого элемента
     * @param string $url Ссылка на страницу с товаром
     */
    function __construct($fio, $email, $tel, $elementId, $url)
    {
        $this->fio = $fio;
        $this->email = $email;
        $this->tel = $tel;
        $this->elementId = $elementId;
        $this->url = $url;

        \CBitrixComponent::includeComponentClass('maximaster:showelement');
        $ob = new \Maximaster\Components\ShowElement();
        $this->elementInfo = $ob->readElementInfo($this->elementId);
    }

    /**
     * Сохранить заказ в инфоблоке
     */
    public function SaveOrder()
    {

    }
}