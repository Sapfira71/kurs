            </div>
        </td>
        <td class="col3">
            <aside class="asideRight">

            </aside>
        </td>
    </tr>
</table>
<footer class="footer">
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => SITE_TEMPLATE_PATH."/include_areas/inc_footer.php"
        )
    );?>
</footer>
</body>
</html>