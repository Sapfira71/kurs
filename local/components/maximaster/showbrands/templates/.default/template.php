<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<?php foreach ($arResult['brands'] as $el): ?>
    <a href="<?= getBrandsElementsURL($el['XML_ID']) ?>"><?= $el['NAME'] ?></a><br>
<?php endforeach; ?>
