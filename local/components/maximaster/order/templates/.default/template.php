<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<? if ($arResult['success'] == '1'): ?>
    <p><? echo GetMessage('SUCCESSFUL_ORDER') ?></p>
<? else: ?>
    <p><? echo GetMessage('UNSUCCESSFUL_ORDER') ?></p>
<? endif; ?>
