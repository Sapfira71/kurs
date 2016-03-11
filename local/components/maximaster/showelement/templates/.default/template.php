

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
            <pre>
                <?print_r($elem);?>
            </pre>
        <?php endforeach; ?>
    <?php else: ?>
        <h3>Товар с таким идентификатором отсутствует на складе</h3>
    <?php endif; ?>
</div>