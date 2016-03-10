<?
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
?>
    <form name="order" method="post" action="">
        <pre>
            <? sendMessage($_GET['ELEMENT_ID']); ?>
            <? print_r($_POST);
            print_r($_COOKIE); ?>
        </pre>
        <?php if (empty($_POST)) : ?>
            <table class="order">
                <tbody>
                <tr>
                    <td>Ф.И.О.:</td>
                    <td><input type="text" name="name" value="<? echo $APPLICATION->get_cookie("name") ?>"></td>
                </tr>
                <tr>
                    <td>Телефон:</td>
                    <td><input name='number' type="tel" required pattern="\+7\([0-9]{3}\)[0-9]{3}\-[0-9]{2}\-[0-9]{2}"
                               value="<? echo $APPLICATION->get_cookie("number") ?>" placeholder="+7(###)###-##-##">
                    </td>
                </tr>
                <tr>
                    <td>Почта:</td>
                    <td><input name='mail' type="email" required pattern="[A-Za-z0-9\.]{1,}@[A-Za-z]{1,}\.[A-Za-z]{2,}"
                               value="<? echo $APPLICATION->get_cookie("mail") ?>" placeholder="[#]@[#].[#]"></td>
                </tr>
                </tbody>
            </table>
            <button class="purchaseButton" type="submit">Оформить заказ</button>
        <?php else: ?>
            Заказ сделан!
        <?php endif; ?>
    </form>
<?
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';