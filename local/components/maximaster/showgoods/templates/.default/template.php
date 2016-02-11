<table border="1">
    <tr>
        <td>Артикул/цена</td>
        <td>Название</td>
        <td>Цена</td>
        <td>Количество на складе</td>
        <td>Симольный код</td>
    </tr>
<?php foreach($arResult["ELEMENTS"] as $elem):?>
    <tr>
        <td><?=$elem["ART"]?></td>
        <td><?=$elem["NAME"]?></td>
        <td><?=$elem["PRICE"]?></td>
        <td><?=$elem["QUANTITY"]?></td>
        <td><?=$elem["SYMB"]?></td>
    </tr>
<?php endforeach;?>
</table>
<?=$arResult["NAV_STRING"]?>
