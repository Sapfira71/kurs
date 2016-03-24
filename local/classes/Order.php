<?php

namespace Maximaster\Classes;

/**
 * ����� ���������� ������ � ��������
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
     * ����������� ������ ���������� ������ � ��������
     * @param string $fio ��� ���������
     * @param string $email ����� ���������� ����� ���������
     * @param string $tel ������� ���������
     * @param int $elementId ������������� ������������� ��������
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
     * ��������� ����� � ���������
     */
    public function SaveOrder()
    {

    }
}