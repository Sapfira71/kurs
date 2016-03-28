<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

<? $elem = $arResult['element']; ?>
<div class="section-elems">
    <form method="post" action="<?= $elem['BUY_PAGE']; ?>">
        <p class="section-element">
            <?= $elem['NAME'] ?>. <? echo GetMessage('PRICE') ?>: <?= $elem['PRICE'] ?><br>
            <img class="section-image js-img-el" src="<?= $elem['DETAIL_PICTURE'] ?>"
                 alt="<?= $elem['NAME'] ?>">
            <?= $elem['DETAIL_TEXT'] ?><br><br>
            <? if (!empty($elem['BRAND'])): ?><? echo GetMessage('BRAND') ?>: <?= $elem['BRAND'] ?><br><? endif; ?>
            <? if (!empty($elem['QUANTITY'])): ?>
                <? echo GetMessage('QUANTITY') ?>: <?= $elem['QUANTITY'] ?><br>
            <? else: ?>
                <? echo GetMessage('DEFAULT_GOODS') ?><br>
            <? endif; ?>
            <? if (!empty($elem['COUNTRY'])): ?><? echo GetMessage('COUNTRY') ?>: <?= $elem['COUNTRY'] ?>
                <br><? endif; ?>

            <button type="submit" class="purchase-button"><? echo GetMessage('BUY_BUTTON') ?></button>
        </p>
    </form>

    <div id="container">
        <div id="products_example">
            <div id="products" class="js-gallery">
                <div class="slides_container">
                    <?php foreach ($elem['GALLERY'] as $pict): ?>
                        <a target="_blank"><img class="image-gallery-full" src="<?= $pict ?>" width="350"
                                                alt="<?= $elem['NAME'] ?>"></a>
                    <?php endforeach; ?>
                </div>
                <ul class="pagination">
                    <?php foreach ($elem['GALLERY'] as $pict): ?>
                        <li>
                            <div class="image-gallery"><a href="#"><img src="<?= $pict ?>" width="55"
                                                                        alt="<?= $elem['NAME'] ?>"></a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>