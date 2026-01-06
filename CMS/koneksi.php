<?php
$conn = mysqli_connect(
    "localhost",
    "usn yg punya database",
    "PASSWORD_DB_KAMU",
    "nama database"
);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}