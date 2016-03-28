<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<? if ($arResult['success'] == '1'): ?>
    <p>Заказ завершен!</p>
<? else: ?>
    <p>Заказ завершить не удалось!</p>
<? endif; ?>
