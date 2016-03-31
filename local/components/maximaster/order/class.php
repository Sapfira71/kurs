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
     * @return bool Результат проверки соответствия значений формы (телефон и email) паттернам
     */
    private function saveInfo()
    {
        $emailPattern = "/[A-Za-z0-9\.]{1,}@[A-Za-z]{1,}\.[A-Za-z]{2,}/";

        $this->fio = $_POST['name'];

        $resultEmail = preg_match($emailPattern, $_POST['mail']);
        if (!$resultEmail) {
            $this->arResult['WRONG_EMAIL'] = GetMessage('WRONG_EMAIL');
            return false;
        } else {
            $this->email = $_POST['mail'];
        }

        $this->elementId = $_POST['hiddenElID'];

        \CBitrixComponent::includeComponentClass('maximaster:showelement');
        $ob = new \Maximaster\Components\ShowElement();
        $this->elementInfo = $ob->readElementInfo($this->elementId);

        $this->elementUrl = $_SERVER['SERVER_NAME'] . $this->elementInfo['DETAIL_URL'];

        return true;
    }

    /**
     * Сохранение заказа
     * @return bool Успешность/неуспешность добавления заказа в инфоблок
     */
    public function saveOrder()
    {
        if (!$this->saveInfo()) {
            return false;
        }

        \CModule::IncludeModule('iblock');
        $ibe = new \CIBlockElement;

        $PROP = Array(
            'FIO' => $this->fio,
            'EMAIL' => $this->email,
            'TELEPHONE' => $this->tel,
            'LINK' => $this->elementUrl,
            'INFO' => GetMessage('BRAND') . ': ' . $this->elementInfo['BRAND'] . '. ' . GetMessage('COUNTRY') . ': ' . $this->elementInfo['COUNTRY'],
            'COST' => $this->elementInfo['PRICE']
        );

        $arFields = Array(
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => IBLOCK_ORDER_ID,
            'NAME' => $this->elementInfo['NAME'],
            'PROPERTY_VALUES' => $PROP
        );

        if (!($ID = $ibe->Add($arFields))) {
            $this->arResult['ERROR_ADD_ORDER'] = GetMessage('ERROR_ADD_ORDER') . '. Error: ' . $ibe->LAST_ERROR;
            return false;
        }
        return true;
    }

    /**
     * Функция, отправляющая письмо с информацией о заказе
     * @return bool|int Успешность/неуспешность отправки письма
     */
    private function sendMail()
    {
        $to = $this->email;

        $arEventFields = array(
            'FROM_EMAIL' => htmlspecialcharsEx('a.morozova@maximaster.ru'),
            'TO_EMAIL' => htmlspecialcharsEx($to),
            'FIO' => htmlspecialcharsEx(GetMessage('FIO') . ': ' . $this->fio),
            'PHONE_NUMBER' => htmlspecialcharsEx(GetMessage('PHONE_NUMBER') . ': ' . $this->tel),
            'GOODS_NAME' => htmlspecialcharsEx(GetMessage('GOODS_NAME') . ': ' . $this->elementInfo['NAME']),
            'PRICE' => htmlspecialcharsEx(GetMessage('PRICE') . ': ' . $this->elementInfo['PRICE']),
            'BRAND' => htmlspecialcharsEx(GetMessage('BRAND') . ': ' . $this->elementInfo['BRAND']),
            'COUNTRY' => htmlspecialcharsEx(GetMessage('COUNTRY') . ': ' . $this->elementInfo['COUNTRY']),
            'LINK' => htmlspecialcharsEx(GetMessage('LINK') . ': ' . $this->elementUrl)
        );

        return \CEvent::Send('ORDER_INFO', 's1', $arEventFields);
    }

    /**
     * Выполнение компонента
     */
    public function executeComponent()
    {
        $this->IncludeComponentLang('class.php');
        if ($this->saveOrder()) {
            $this->arResult['SUCCESS'] = $this->sendMail() ? true : false;
        }

        $this->includeComponentTemplate();
    }
}