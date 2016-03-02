            </div>
        </td>
        <td class="col3">
            <aside>

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
            "PATH" => "local/templates/test/include_areas/inc_footer.php"
        )
    );?>
</footer>
</body>
</html>