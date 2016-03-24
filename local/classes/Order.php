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
    private $elementId = 0;
    public $elementInfo = Array();

    /**
     * Конструктор класса сохранения заказа в инфоблок
     * @param string $fio ФИО заказчика
     * @param string $email Адрес электонной почты заказчика
     * @param string $tel Телефон заказчика
     * @param int $elementId Идентификатор заказываемого элемента
     */
    function __construct($fio, $email, $tel, $elementId)
    {
        $this->fio = $fio;
        $this->email = $email;
        $this->tel = $tel;
        $this->elementId = $elementId;

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