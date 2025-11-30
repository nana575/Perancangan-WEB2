<?php
$host     = "localhost";
$user     = "root";
$password = "";
$database = "dbabsensi_mahasiswa_berbasis_qrcode";

$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
