<?php
include "koneksi.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
    echo json_encode([
        "status" => false,
        "message" => "Hanya menerima POST"
    ]);
    exit;
}

// Ambil RAW JSON
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

// Validasi JSON
if (!$data) {
    echo json_encode([
        "status" => false,
        "message" => "JSON tidak valid"
    ]);
    exit;
}

// Ambil data
$id_user  = $data['id_user']?? '';
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';
$nama     = $data['nama'] ?? '';
$email    = $data['email'] ?? '';
$role     = $data['role'] ?? 'mahasiswa';

// Validasi wajib
if ($username == '' || $password == '' || $nama == '') {
    echo json_encode([
        "status" => false,
        "message" => "Field username, password, dan nama wajib diisi"
    ]);
    exit;
}

// Hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

// Insert ke database
$query = mysqli_query($koneksi, "
    INSERT INTO tb_user
    (id_user, username, password, nama, email, role, status, is_verified)
    VALUES
    ('$id_user','$username','$hash','$nama','$email','$role','aktif',1)
");

echo json_encode([
    "status" => $query,
    "message" => $query ? "User berhasil ditambahkan" : "Gagal menambahkan user"
]);
