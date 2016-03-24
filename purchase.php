<?
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
?>
    <form name="order" action="sendmail.php" method="post">
        <input type="hidden" value="<?= $_REQUEST['ELEMENT_ID'] ?>" name="hiddenElID">
        <input type="hidden" value="<?= $_POST['url'] ?>" name="url">
        <table class="order">
            <tbody>
            <tr>
                <td>Ф.И.О.:</td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr>
                <td>Телефон:</td>
                <td><input name="number" type="tel" required pattern="\+7\([0-9]{3}\)[0-9]{3}\-[0-9]{2}\-[0-9]{2}"
                           placeholder="+7(###)###-##-##">
                </td>
            </tr>
            <tr>
                <td>Почта:</td>
                <td><input name="mail" type="email" required pattern="[A-Za-z0-9\.]{1,}@[A-Za-z]{1,}\.[A-Za-z]{2,}"
                           placeholder="[#]@[#].[#]"></td>
            </tr>
            </tbody>
        </table>
        <button class="purchase-button js-order-button" type="submit">Оформить заказ</button>
    </form>
<?
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';