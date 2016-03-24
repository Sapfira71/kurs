<?
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
?>
<?

CModule::RequireAutoloadClass('Order');
CModule::RequireAutoloadClass('SendMail');

$order = new \Maximaster\Classes\Order($_POST['name'], $_POST['mail'], $_POST['number'], $_POST['hiddenElID'],
    $_POST['url']);
$order->SaveOrder();
if (\Maximaster\Classes\SendMail::sendMail($order)) {
    echo 'Заказ завершен!';
} else {
    echo 'Заказ завершить не удалось!';
}

?>
<?
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';