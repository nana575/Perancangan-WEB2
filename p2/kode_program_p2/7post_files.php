<html>
<head>
    <title>Hasil Buku Tamu</title>
</head>
<body>
    <h1>Simpan file yang diupload</h1>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $komentar = $_POST['komentar'];

        echo "<P><b>Nama: </b> $nama</p>";
        echo "<p><b>Email: </b> $email</p>";
        echo "<P><b>Komentar: </b> $komentar</p>";
    } else {
        echo "<p> Tidak ada data yang terkirim!</p>";
    }
    ?>
</body>
</html>