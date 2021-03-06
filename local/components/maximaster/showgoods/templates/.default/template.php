<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}?>

<?php if (!empty($arResult)): ?>
    <table border="1" class="table-goods">
        <tr>
            <td>Артикул/цена</td>
            <td>Название</td>
            <td>Цена</td>
            <td>Количество на складе</td>
            <td>Символьный код</td>
        </tr>
        <?php foreach ($arResult["ELEMENTS"] as $elem): ?>
            <tr>
                <td><?= $elem["ART"] ?></td>
                <td><?= $elem["NAME"] ?></td>
                <td><?= $elem["PRICE"] ?></td>
                <td><?= $elem["QUANTITY"] ?></td>
                <td><?= $elem["SYMB"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?= $arResult["NAV_STRING"] ?>
<?php else: ?>
    <h3>Товары отсутствуют в инфоблоке</h3>
<?php endif; ?>
