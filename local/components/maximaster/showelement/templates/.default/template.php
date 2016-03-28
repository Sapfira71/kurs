<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

<? $elem = $arResult['element']; ?>
<div class="section-elems">
    <form method="post" action="<?= $elem['BUY_PAGE']; ?>">
        <p class="section-element">
            <?= $elem['NAME'] ?>. Цена: <?= $elem['PRICE'] ?><br>
            <img class="section-image js-img-el" src="<?= $elem['DETAIL_PICTURE'] ?>" alt="Изображение товара">
            <?= $elem['DETAIL_TEXT'] ?><br><br>
            <? if (!empty($elem['BRAND'])): ?> Бренд: <?= $elem['BRAND'] ?><br><? endif; ?>
            <? if (!empty($elem['QUANTITY'])): ?>
                Количество на складе: <?= $elem['QUANTITY'] ?><br>
            <? else: ?>
                Товар отсутсвует на складе!<br>
            <? endif; ?>
            <? if (!empty($elem['COUNTRY'])): ?> Страна-производитель: <?= $elem['COUNTRY'] ?><br><? endif; ?>

            <button type="submit" class="purchase-button">Купить</button>
        </p>
    </form>

    <div id="container">
        <div id="products_example">
            <div id="products" class="js-gallery">
                <div class="slides_container">
                    <?php foreach ($elem['GALLERY'] as $pict): ?>
                        <a target="_blank"><img class="image-gallery-full" src="<?= $pict ?>" width="350"
                                                alt="Изображение товара"></a>
                    <?php endforeach; ?>
                </div>
                <ul class="pagination">
                    <?php foreach ($elem['GALLERY'] as $pict): ?>
                        <li>
                            <div class="image-gallery"><a href="#"><img src="<?= $pict ?>" width="55"
                                                                        alt="Изображение товара"></a></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>