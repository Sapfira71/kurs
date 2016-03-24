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
    public $productUrl = "";
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
    function __construct($fio, $email, $tel, $elementId, $productUrl)
    {
        $this->fio = $fio;
        $this->email = $email;
        $this->tel = $tel;
        $this->elementId = $elementId;
        $this->productUrl = $productUrl;

        \CBitrixComponent::includeComponentClass('maximaster:showelement');
        $ob = new \Maximaster\Components\ShowElement();
        $this->elementInfo = $ob->readElementInfo($this->elementId);
    }

    /**
     * Сохранить заказ в инфоблоке
     */
    public function SaveOrder()
    {
        \CModule::IncludeModule('iblock');
        $ibe = new \CIBlockElement;

        $PROP = Array(
            'FIO' => $this->fio,
            'EMAIL' => $this->email,
            'TELEPHONE' => $this->tel,
            'LINK' => $this->productUrl,
            'INFO' => 'Бренд: ' . $this->elementInfo['BRAND'] . '. Страна-производитель: ' . $this->elementInfo['COUNTRY'],
            'COST' => $this->elementInfo['PRICE']
        );

        $arFields = Array(
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => IBLOCK_ORDER_ID,
            'NAME' => $this->elementInfo['NAME'],
            'PROPERTY_VALUES' => $PROP
        );

        if (!($ID = $ibe->Add($arFields))) {
            echo 'Error: ' . $ibe->LAST_ERROR . '<br>';
        }

    }
}