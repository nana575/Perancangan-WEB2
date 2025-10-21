<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cek tipe</title>
</head>
<body>
    <?php
    $bil = 78 ;
    var_dump(is_int($bil));
    // output: bool(true)
    echo "<br>";

    $var = "okeiii";
    var_dump(is_string($var));
    // output: bool(true)
    
    ?>
</body>
</html>