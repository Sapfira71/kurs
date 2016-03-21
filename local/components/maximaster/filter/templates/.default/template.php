<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<form name="filter" method="get">
    <table>
        <tr>
            <td>Артикул:</td>

            <td><input type="text" name="vendorCode"
                       value="<?=isset($arResult["vendorCode"]) ? $arResult["vendorCode"] : ''?>">
            </td>
        </tr>
        <tr>
            <td>Название:</td>
            <td><input type="text" name="name"
                       value="<?= isset($arResult["name"]) ? $arResult["name"] : '' ?>">
            </td>
        </tr>
        <tr>
            <td>Цена:</td>
            <td>от <input type="text" name="price1"
                          value="<?= isset($arResult["price1"]) ? $arResult["price1"] : '' ?>">
                до <input type="text" name="price2"
                          value="<?= isset($arResult["price2"]) ? $arResult["price2"] : '' ?>">
            </td>
        </tr>
        <tr>
            <td>Только в наличии:</td>
            <td><input type="checkbox" name="availability"
                <?= isset($arResult["availability"]) ? "checked" : '' ?>
            </td>
        </tr>
    </table>
    <input type="submit" value="Найти">
    <input type="reset" value="Сброс">
    <br/>
    <br/>
</form>