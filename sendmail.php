<?
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
?>
<?
\CBitrixComponent::includeComponentClass('maximaster:showelement');
$ob = new Maximaster\Components\ShowElement();
$arEl = $ob->readElementInfo($_POST['hiddenElID']);
$arEl = $arEl[0];

$to = $_POST['mail'];
$message = 'Ваше имя: ' . $_POST['name'] . '. Телефон: ' . $_POST['number'] . '. Почта: ' . $_POST['mail'] . '. ';
$message .= $arEl['NAME'] . '. ' . $arEl['PRICE'] . '. ' . $arEl['BRAND'] . '. ' . $arEl['COUNTRY'];

$arEventFields = array(
    'FROM_EMAIL' => htmlspecialcharsEx('a.morozova@maximaster.ru'),
    'MESSAGE' => htmlspecialcharsEx($message),
    'TO_EMAIL' => htmlspecialcharsEx($to)
);

if (\CEvent::Send('ORDER_INFO', 's1', $arEventFields)) {
    echo 'Заказ завершен!';
} else {
    echo 'Заказ завершить не удалось!';
}
?>
<?
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';