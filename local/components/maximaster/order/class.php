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
        $telPattern = "/\+7\([0-9]{3}\)[0-9]{3}-[0-9]{2}-[0-9]{2}/";

        $this->fio = $_POST['name'];

        $resultTel = preg_match($telPattern, $_POST['number']);
        if (!$resultTel) {
            $this->arResult['WRONG_PHONE_NUMBER'] = GetMessage('WRONG_PHONE_NUMBER');
            return false;
        } else {
            $this->tel = $_POST['number'];
        }

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
        $message = GetMessage('FIO') . ': ' . $this->fio . '. ' . GetMessage('PHONE_NUMBER') . ': ' . $this->tel;
        $message .= '. ' . GetMessage('EMAIL') . ': ' . $this->email . '. ';
        $message .= GetMessage('GOODS_NAME') . ': ' . $this->elementInfo['NAME'];
        $message .= '. ' . GetMessage('PRICE') . ': ' . $this->elementInfo['PRICE'];
        $message .= '. ' . GetMessage('BRAND') . ': ' . $this->elementInfo['BRAND'] . '. ';
        $message .= GetMessage('COUNTRY') . ': ' . $this->elementInfo['COUNTRY'];
        $message .= '. ' . GetMessage('LINK') . ': ' . $this->elementUrl . '.';

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
        $this->IncludeComponentLang('class.php');
        if ($this->saveOrder()) {
            $this->arResult['SUCCESS'] = $this->sendMail() ? true : false;
        }

        $this->includeComponentTemplate();
    }
}