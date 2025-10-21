<!DOCTYPE html>
<html lang="en">
<head>
    <title>Casting Tipe</title>
</head>
<body>
    <?php
    $str = '23 februari 2007';

    //casting nilai variabel $str ke integer
    $bil = (int) $str; //$bil = 123

    echo gettype($str);
    //output : string
    echo "<br>";
    echo gettype($bil);
    //output: integer
    ?>
</body>
</html>