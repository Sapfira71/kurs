<?
include $_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php';
?>
    <!--<script>
        function loadData() {
            $.ajax({
                url: 'downloaddata.php'
            });
        }
    </script>
    <input type="submit" name="create" value="Загрузить данные из файла" onclick="loadData()">-->

    <?php
    include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';
    $APPLICATION->IncludeComponent('maximaster:showsections', '.default');
    ?>
<?
include $_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php';
