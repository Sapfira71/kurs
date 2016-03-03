<form name="filter" method="post"
      action="<?= substr_replace($_SERVER['REQUEST_URI'], '', strpos($_SERVER['REQUEST_URI'], '?')) ?>">
    <table>
        <tr>
            <td>Артикул:</td>
            <td><input type="text" name="myFilter[vendorCode]"
                       value="<? if (isset($arResult["vendorCode"])) {
                           echo $arResult["vendorCode"];
                       } ?>">
            </td>
        </tr>
        <tr>
            <td>Название:</td>
            <td><input type="text" name="myFilter[name]"
                       value="<? if (isset($arResult["name"])) {
                           echo $arResult["name"];
                       } ?>">
            </td>
        </tr>
        <tr>
            <td>Цена:</td>
            <td>от <input type="text" name="myFilter[price1]"
                          value="<? if (isset($arResult["price1"])) {
                              echo $arResult["price1"];
                          } ?>">
                до <input type="text" name="myFilter[price2]"
                          value="<? if (isset($arResult["price2"])) {
                              echo $arResult["price2"];
                          } ?>">
            </td>
        </tr>
        <tr>
            <td>Только в наличии:</td>
            <td><input type="checkbox" name="myFilter[availability]"
                    <? if (isset($arResult["availability"])) {
                        echo "checked";
                    } ?>>
            </td>
        </tr>
    </table>
    <input type="submit" value="Найти">
    <input type="reset" value="Сброс">
    <br/>
    <br/>
</form>