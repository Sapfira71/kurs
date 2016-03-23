</div>
</td>
<td class='col3'>
    <aside>
        <?php
        $APPLICATION->IncludeComponent('maximaster:showbrands', '.default');
        ?>
    </aside>
</td>
</tr>
</table>
<footer class='footer'>
    <? $APPLICATION->IncludeComponent(
        'bitrix:main.include',
        '',
        Array(
            'AREA_FILE_SHOW' => 'sect',
            'AREA_FILE_SUFFIX' => 'footer',
            "AREA_FILE_RECURSIVE" => 'Y'
        )
    ); ?>
</footer>
</body>
</html>