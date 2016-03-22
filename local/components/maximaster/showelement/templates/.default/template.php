<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
if (empty($arResult['element'])) {
    ShowError('Таких элементов не существует!');
    return;
}
?>

<div class='section-elems'>
    <?php foreach ($arResult['element'] as $elem): ?>
        <p class='section-element'>
            <?= $elem['NAME'] ?>. <? if (!empty($elem['PRICE'])): ?>Цена: <?= $elem['PRICE'] ?><br><? endif; ?>
            <img class='section-image js-img-el' src='<?= $elem['DETAIL_PICTURE'] ?>' alt='Изображение товара'>
            <?= $elem['DETAIL_TEXT'] ?><br><br>
            <? if (!empty($elem['BRAND'])): ?> Бренд: <?= $elem['BRAND'] ?><br><? endif; ?>
            <? if (!empty($elem['QUANTITY'])): ?> Количество на складе: <?= $elem['QUANTITY'] ?><br><? endif; ?>
            <? if (!empty($elem['COUNTRY'])): ?> Страна-производитель: <?= $elem['COUNTRY'] ?><br><? endif; ?>
            <a class='purchase-button' href='<?= $elem['BUY_PAGE']; ?>'>Купить</a>
        </p>

        <div id='container'>
            <div id='products_example'>
                <div id='products' class='js-gallery'>
                    <div class='slides_container'>
                        <?php foreach ($elem['GALLERY'] as $pict): ?>
                            <a target='_blank'><img class='image-gallery-full' src='<?= $pict ?>' width='350'
                                                    alt='Изображение товара'></a>
                        <?php endforeach; ?>
                    </div>
                    <ul class='pagination'>
                        <?php foreach ($elem['GALLERY'] as $pict): ?>
                            <li>
                                <div class='image-gallery'><a href='#'><img src='<?= $pict ?>' width='55'
                                                                            alt='Изображение товара'></a></div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>