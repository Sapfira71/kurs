<?
namespace Maximaster\Components;

/**
 * Класс компонента заказа товара
 * Class Order
 * @package Maximaster\Components
 */
class Order extends \CBitrixComponent
{
    /**
     * @var string ФИО заказчика
     */
    private $fio;
    /**
     * @var string Адрес электронной почты
     */
    private $email;
    /**
     * @var string Телефон
     */
    private $tel;
    /**
     * @var string Идентификатор заказываемого товара
     */
    private $elementId;
    /**
     * @var string Информация о товаре
     */
    private $elementInfo;
    /**
     * @var string Ссылка на страницу просмотра товара
     */
    private $elementUrl;

    /**
     * Считывание необходимой информации из запроса
     */
    private function saveInfo()
    {
        $this->fio = $_POST['name'];
        $this->email = $_POST['mail'];
        $this->tel = $_POST['number'];
        $this->elementId = $_POST['hiddenElID'];

        \CBitrixComponent::includeComponentClass('maximaster:showelement');
        $ob = new \Maximaster\Components\ShowElement();
        $this->elementInfo = $ob->readElementInfo($this->elementId);

        $this->elementUrl = $_SERVER['SERVER_NAME'] . $this->elementInfo['DETAIL_URL'];
    }

    /**
     * Сохранение заказа
     * @return int Успешность/неуспешность добавления заказа в инфоблок
     */
    public function saveOrder()
    {
        $this->saveInfo();

        \CModule::IncludeModule('iblock');
        $ibe = new \CIBlockElement;

        $PROP = Array(
            'FIO' => $this->fio,
            'EMAIL' => $this->email,
            'TELEPHONE' => $this->tel,
            'LINK' => $this->elementUrl,
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
            return 0;
        }
        return 1;
    }

    /**
     * Функция, отправляющая письмо с информацией о заказе
     * @return bool|int Успешность/неуспешность отправки письма
     */
    private function sendMail()
    {
        $to = $this->email;
        $message = 'Ваше имя: ' . $this->fio . '. Телефон: ' . $this->tel . '. Почта: ' . $this->email . '. ';
        $message .= 'Название товара: ' . $this->elementInfo['NAME'] . '. Цена: ' . $this->elementInfo['PRICE'];
        $message .= '. Бренд: ' . $this->elementInfo['BRAND'] . '. Страна: ' . $this->elementInfo['COUNTRY'];
        $message .= '. Ссылка на товар: ' . $this->elementUrl . '.';

        $arEventFields = array(
            'FROM_EMAIL' => htmlspecialcharsEx('a.morozova@maximaster.ru'),
            'MESSAGE' => htmlspecialcharsEx($message),
            'TO_EMAIL' => htmlspecialcharsEx($to)
        );

        return \CEvent::Send('ORDER_INFO', 's1', $arEventFields);
    }

    /**
     * Выполнение компонента
     */
    public function executeComponent()
    {
        if ($this->saveOrder()) {
            $this->arResult['success'] = $this->sendMail() ? '1' : '0';
        }

        $this->includeComponentTemplate();
    }
}