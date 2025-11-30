<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "dbabsensi_mahasiswa_berbasis_qrcode";

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("koneksi gagal: " . $conn->connect_error);
}
?>
