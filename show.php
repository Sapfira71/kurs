<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>
    <form name="filter" method="post" action="show.php">
        <?php
            include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';
            $APPLICATION->IncludeComponent('maximaster:filter', '.default');
            $APPLICATION->IncludeComponent('maximaster:showgoods', '.default');
        ?>
    </form>
    <?php
    /*session_start();
    $_SESSION["vendorCode"] = $_POST["vendorCode"];
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["price1"] = $_POST["price1"];
    $_SESSION["price2"] = $_POST["price2"];
    $_SESSION["quantity"] = $_POST["quantity"];
    exit;*/
    ?>
</body>
</html>