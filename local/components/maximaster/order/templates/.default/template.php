<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<? if ($arResult['success'] === true): ?>
    <p><? echo GetMessage('SUCCESSFUL_ORDER') ?></p>
<? else: ?>
    <p><? echo GetMessage('UNSUCCESSFUL_ORDER') ?></p>
<? endif; ?>
