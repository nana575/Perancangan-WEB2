<?php
// konfigurasi database
$host = 'localhost'; //Host
$user = 'root';
$password = '';
$database = 'dblatihan';

//membuat koneksi
$koneksi = new mysqli($host, $user, $password, $database );

//cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

//mengambil data dari form
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

//query untuk menyimpan data ke tebael users
$sql ="INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

if ($koneksi->query($sql) === TRUE){
    echo "Data berhasil disimpan!<br>";
    echo "<a href='form.html'>Tambah user baru</a>";
} else {
    echo "Error: " , $sql , "<br>" , $koneksi->error;
}
//menutup konekssi
$koneksi->close();
?>