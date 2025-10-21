<!DOCTYPE html>
<html lang="en">
<head>
    <title>Demo Variabel 3</title>
</head>
<body>
    <?php
    $bil = 59;
    var_dump($bil);
    //output : int(59)
    //pada angka 59 diatas muncul keterangan int karena pada variabel bernilaikan tanpa tanda petik
    echo "<br>";
    $var ="hallo";
    var_dump($var);
    //output :string (5) "hallo"
    // pada program di atas mengahsilkan tipe data string karena isi pada variabel $var diapit 2 tanda petik
    echo "<br>";
   
    $var = null;
    var_dump($var);
    //outpput: null
    ?>
</body>
</html>