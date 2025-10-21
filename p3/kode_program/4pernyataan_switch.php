<!DOCTYPE html>
<html lang="en">
<head>
    <title>Seleksi switch</title>
</head>
<body>
    <?php
        $i = 0;
        if ($i == 0) {
            echo "i equals 0";
            echo "<br>";
        } elseif ($i == 1) {
            echo "i equals 1";
            echo "<br>";
        } elseif ($i == 2) {
            echo "i equals 2";
            echo "<br>";
        }
        // ekuivalen, dengan pendekatan switch
        switch ($i) {
        case 0:
            echo "i equals 0";
        break;
        case 1:
            echo "i equals 1";
        break;
        case 2:
            echo "i equals 2";
        break;
        }
    ?>
</body>
</html>