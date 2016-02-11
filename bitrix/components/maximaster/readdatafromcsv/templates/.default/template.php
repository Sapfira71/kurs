<table border='1'>
    <?php foreach($arParams as $elem):?>
        <tr>
            <td><?=$elem["ART"]["VALUE"]?></td>
            <td><?=$elem["NAME"]["VALUE"]?></td>
            <td><?=$elem["QUANTITY"]["VALUE"]?></td>
            <td><?=$elem["PRICE"]["VALUE"]?></td>
            <td><?=$elem["SYMB"]["VALUE"]?></td>
        </tr>
    <?php endforeach;?>
</table>