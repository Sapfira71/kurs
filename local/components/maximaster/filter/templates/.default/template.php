<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<form name="filter" method="post"
      action="<?= substr_replace($_SERVER['REQUEST_URI'], '', strpos($_SERVER['REQUEST_URI'], '?')) ?>">
    <table>
        <tr>
            <td>Артикул:</td>

            <td><input type="text" name="myFilter[vendorCode]"
                       value="<?= isset($arResult["vendorCode"]) ? $arResult["vendorCode"] : '' ?>">
            </td>
        </tr>
        <tr>
            <td>Название:</td>
            <td><input type="text" name="myFilter[name]"
                       value="<?= isset($arResult["name"]) ? $arResult["name"] : '' ?>">
            </td>
        </tr>
        <tr>
            <td>Цена:</td>
            <td>от <input type="text" name="myFilter[price1]"
                          value="<?= isset($arResult["price1"]) ? $arResult["price1"] : '' ?>">
                до <input type="text" name="myFilter[price2]"
                          value="<?= isset($arResult["price2"]) ? $arResult["price2"] : '' ?>">
            </td>
        </tr>
        <tr>
            <td>Только в наличии:</td>
            <td><input type="checkbox" name="myFilter[availability]"
                <?= isset($arResult["availability"]) ? "checked" : '' ?>
            </td>
        </tr>
    </table>
    <input type="submit" value="Найти">
    <input type="reset" value="Сброс">
    <br/>
    <br/>
</form>