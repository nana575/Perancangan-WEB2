<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "dbabsensi_mahasiswa_berbasis_qrcode";

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "message" => "Koneksi database gagal"
    ]);
    exit;
}
?>
