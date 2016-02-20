<form name="filter" method="post">
    <table>
        <tr>
            <td>Артикул:</td>
            <td><input type="text" name="myFilter[vendorCode]"
                       value="<? if (isset($arParams["FILTER"]["vendorCode"])) {
                           echo $arParams["FILTER"]["vendorCode"];
                       } ?>">
            </td>
        </tr>
        <tr>
            <td>Название:</td>
            <td><input type="text" name="myFilter[name]"
                       value="<? if (isset($arParams["FILTER"]["name"])) {
                           echo $arParams["FILTER"]["name"];
                       } ?>">
            </td>
        </tr>
        <tr>
            <td>Цена:</td>
            <td>от <input type="text" name="myFilter[price1]"
                          value="<? if (isset($arParams["FILTER"]["price1"])) {
                              echo $arParams["FILTER"]["price1"];
                          } ?>">
                до <input type="text" name="myFilter[price2]"
                          value="<? if (isset($arParams["FILTER"]["price2"])) {
                              echo $arParams["FILTER"]["price2"];
                          } ?>">
            </td>
        </tr>
        <tr>
            <td>Только в наличии:</td>
            <td><input type="checkbox" name="myFilter[availability]"
                       <? if (isset($arParams["FILTER"]["availability"])) {
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