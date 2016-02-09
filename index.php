<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>
    <?php
    echo "<table border='1'>";
    if (($handle = fopen("products.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle)) !== FALSE) {
            foreach ($data as $value) {
                $elements = explode(";", $value);
                $num = count($elements);

                echo "<tr>";
                for ($i = 0; $i < $num; $i++) {
                    echo "<td>" . $elements[$i] . "</td>";
                }
                echo "</tr>";
            }
        }
        fclose($handle);
    }
    echo "</table>";
    ?>
</body>
</html>