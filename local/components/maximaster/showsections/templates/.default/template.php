<div class="section-head">
    <h3><?= $arResult['NAME'] ?> (<?= $arResult['ELEMENT_CNT'] ?>)</h3>
</div>

<div class="section">
    <img class="section-image" src="<?= $arResult['IMAGE'] ?>">

    <div><?= $arResult['DESCRIPTION'] ?></div>
</div>

<div class="section-elems">
    <?php if (!empty($arResult["ELEMENTS"])): ?>
        <h3>В разделе есть следующие товары:</h3>
        <?php foreach ($arResult["ELEMENTS"] as $elem): ?>
            <p class="section-element">
                <a href="<?= $elem['DETAIL_URL'] ?>"><?= $elem["NAME"] ?></a>. Цена: <?= $elem["PRICE"] ?> руб.<br>
                <img class="section-image" src="<?= $elem['PREV_P'] ?>">
                <?= $elem['PREV_D'] ?>
            </p>
        <?php endforeach; ?>
    <?php else: ?>
        <h3>Товары отсутствуют в данном разделе</h3>
    <?php endif; ?>
</div>