</div>
</td>
<td class="col3">
    <aside>
        <?php
        $APPLICATION->IncludeComponent('maximaster:showbrands', '.default');
        ?>
    </aside>
</td>
</tr>
</table>
<footer class="footer">
    <? $APPLICATION->IncludeFile(
        $APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH . "/include_areas/inc_footer.php"),
        Array(),
        Array("MODE" => "php")
    ); ?>
</footer>
</body>
</html>