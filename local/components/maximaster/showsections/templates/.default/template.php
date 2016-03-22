<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<? if (!empty($arResult['section'])) : ?>
    <div class='section-head'>
        <h3><?= $arResult['section']['NAME'] ?> (<?= $arResult['section']['ELEMENT_CNT'] ?>)</h3>
    </div>

    <div class='section'>
        <img class='section-image' src='<?= $arResult['section']['IMAGE'] ?>' alt='Изображение секции'>

        <div><?= $arResult['section']['DESCRIPTION'] ?></div>
    </div>

    <? if (empty($arResult['elements'])): ?>
        <h3>Товары отсутствуют в данном разделе</h3>
    <? endif; ?>
<? endif; ?>

<?php if (!empty($arResult['elements'])): ?>
    <div class='section-elems'>
        <h3>В разделе есть следующие товары:</h3>
        <?php foreach ($arResult['elements'] as $elem): ?>
            <p class='section-element'>
                <a href='<?= $elem['DETAIL_URL'] ?>'><?= $elem['NAME'] ?></a>. Цена: <?= $elem['PRICE'] ?><br>
                <img class='section-image' src='<?= $elem['PREVIEW_PICTURE'] ?>' alt='Изображение товара'>
                <?= $elem['PREVIEW_TEXT'] ?>
            </p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>