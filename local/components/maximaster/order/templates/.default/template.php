<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<? if (isset($arResult['WRONG_PHONE_NUMBER'])): ?>
    <p><?=$arResult['WRONG_PHONE_NUMBER']?></p>
<? endif; ?>
<? if (isset($arResult['WRONG_EMAIL'])): ?>
    <p><?=$arResult['WRONG_EMAIL']?></p>
<? endif; ?>
<? if (isset($arResult['ERROR_ADD_ORDER'])): ?>
    <p><?=$arResult['ERROR_ADD_ORDER']?></p>
<? endif; ?>

<? if ($arResult['SUCCESS'] === true): ?>
    <p><? echo GetMessage('SUCCESSFUL_SEND_MAIL') ?></p>
<? else: ?>
    <p><? echo GetMessage('UNSUCCESSFUL_SEND_MAIL') ?></p>
<? endif; ?>
