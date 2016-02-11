<table border="1">
    <tr>
        <td>Vendor code</td>
        <td>Name</td>
        <td>Price</td>
        <td>Quantity</td>
        <td>Character code</td>
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
