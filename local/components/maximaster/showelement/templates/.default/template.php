<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<div class="section-elems">
    <?php if (!empty($arResult["element"])): ?>
        <?php foreach ($arResult['element'] as $elem): ?>
            <p class="section-element">
                <?= $elem["NAME"] ?>. Цена: <?= $elem["PRICE"] ?> руб.<br>
                <img class="section-image js-img-el" src="<?= $elem['DET_P'] ?>">
                <?= $elem['DET_D'] ?><br><br>
                Бренд: <?= $elem['BRAND'] ?><br>
                Количество на складе: <?= $elem['QUANTITY'] ?><br>
                Страна-производитель: <?= $elem['COUNTRY'] ?><br>
            </p>
            <div id="container">
                <div id="products_example">
                    <div id="products">
                        <div class="slides_container">
                            <?php foreach ($elem['GALLERY'] as $pict): ?>
                                <a target="_blank"><img src="<?=$pict?>" width="350"></a>
                            <?php endforeach; ?>
                        </div>
                        <ul class="pagination">
                            <?php foreach ($elem['GALLERY'] as $pict): ?>
                                <li><a href="#"><img src="<?=$pict?>" width="55"></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <h3>Товар с таким идентификатором отсутствует на складе</h3>
    <?php endif; ?>
</div>