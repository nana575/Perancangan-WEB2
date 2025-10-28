<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "dblatihan";

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("koneksi gagal: " . $conn->connect_error);
}
?>