<form name="filter" method="get">
    <table>
        <tr>
            <td>Артикул:</td>
            <td><input type="text" name="vendorCode"
                       value="<? if (isset($arResult["vendorCode"])) {
                           echo $arResult["vendorCode"];
                       } ?>">
            </td>
        </tr>
        <tr>
            <td>Название:</td>
            <td><input type="text" name="name"
                       value="<? if (isset($arResult["name"])) {
                           echo $arResult["name"];
                       } ?>">
            </td>
        </tr>
        <tr>
            <td>Цена:</td>
            <td>от <input type="text" name="price1"
                          value="<? if (isset($arResult["price1"])) {
                              echo $arResult["price1"];
                          } ?>">
                до <input type="text" name="price2"
                          value="<? if (isset($arResult["price2"])) {
                              echo $arResult["price2"];
                          } ?>">
            </td>
        </tr>
        <tr>
            <td>Только в наличии:</td>
            <td><input type="checkbox" name="availability"
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