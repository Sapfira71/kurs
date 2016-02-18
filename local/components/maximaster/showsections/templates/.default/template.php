<div class="sectionHead">
    <h3><?=$arResult['NAME']?> (<?=$arResult['ELEMENT_CNT']?>)</h3>
</div>

<div class="section">
    <img class="sectionImage" src="<?=$arResult['IMAGE']?>">
    <div><?=$arResult['DESCRIPTION']?></div>
</div>

<div class="sectionElems">
    <h3>В разделе есть следующие товары:</h3>
    <?php foreach($arResult["ELEMENTS"] as $elem):?>
        <p class="sectionElement">
            <?=$elem["NAME"]?>. Цена: <?=$elem["PRICE"]?> руб.<br>
            <img class="sectionImage" src="<?=$elem['PREV_P']?>">
            <div><?=$elem['PREV_D']?></div>
        </p>
    <?php endforeach;?>
</div>