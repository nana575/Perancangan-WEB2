<html>
<head>
    <title>Contoh form dengan POST</title>
</head>
<body>
    <h1>Buku Tamu</h1>
    Komentar dan saran sangat kami butuhkan untuk meningkatkan kualitas status kami.
    <hr>
    <form action="7post_files.php" method="POST">
    <pre>
        Nama Anda : <input type="text" name="nama" size="25" maxlength="50">
        Email Address : <input type="text" name="email" size="25" maxlength="50">
        Komentar : <textarea name="komentar" cols="40" rows="5"></textarea>
        <input type="submit" value="Kirim">
        <input type="reset" value="ulangi">
    </pre>
    </form>
</body>
</html>