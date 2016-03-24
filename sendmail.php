<?
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
?>
<?

$order = new \Maximaster\Classes\Order($_POST['name'], $_POST['name'], $_POST['name'], $_POST['hiddenElID']);
$order->SaveOrder();
if (\Maximaster\Classes\SendMail::sendMail($order)) {
    echo 'Заказ завершен!';
} else {
    echo 'Заказ завершить не удалось!';
}

?>
<?
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';