<?php if (!empty($arResult)): ?>
    <table border="1" class="tableGoods">
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

<script type="text/javascript">

    $('a').each(function () {
        if(this.href.indexOf('price1')==-1) {
            <? if (isset($_POST['filterParams']['price1'])):?>
            this.href += ('&price1=' + <?=$_POST['filterParams']['price1']?>);
            <? endif;?>
        }
        if(this.href.indexOf('price2')==-1) {
            <? if (isset($_POST['filterParams']['price2'])):?>
            this.href += ('&price2=' + <?=$_POST['filterParams']['price2']?>);
            <? endif;?>
        }
        if(this.href.indexOf('name')==-1) {
            <? if (isset($_POST['filterParams']['name'])):?>
            this.href += ('&name=' + <?=$_POST['filterParams']['name']?>);
            <? endif;?>
        }
        if(this.href.indexOf('vendorCode')==-1) {
            <? if (isset($_POST['filterParams']['vendorCode'])):?>
            this.href += ('&vendorCode=' + <?=$_POST['filterParams']['vendorCode']?>);
            <? endif;?>
        }
        if(this.href.indexOf('availability')==-1) {
            <? if (isset($_POST['filterParams']['availability'])):?>
            this.href += ('&availability=' + <?=$_POST['filterParams']['availability']?>);
            <? endif;?>
        }
    });

</script>
