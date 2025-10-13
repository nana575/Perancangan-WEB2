<html>
<head>
    <title>Buku Tamu</title>
</head>
<body>
    <?php
    $nama=$_POST ["nama"];
    $email=$_POST ["email"];
    $komentar=$_POST ["komentar"];
    ?>
    <h1>Data buku Tamu</h1>
    <hr>
    Nama anda     : <?php echo $nama?>
    <br>
    Email address : <?php echo $email?>
    <br>
    Komentar      : <?php echo $komentar?>   
    <br>
</body>
</html>