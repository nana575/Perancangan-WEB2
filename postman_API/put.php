<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type");

include "koneksi.php"; 

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'PUT') {

    // ambil body JSON
    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true);

    // cek JSON valid atau tidak
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode([
            "status" => false,
            "message" => "JSON tidak valid",
            "error" => json_last_error_msg()
        ]);
        exit;
    }

    // ambil data
    $id_user = trim($data['id_user'] ?? '');
    $nama    = $data['nama'] ?? '';
    $email   = $data['email'] ?? '';
    $role    = $data['role'] ?? '';
    $status  = $data['status'] ?? '';

    // validasi wajib
    if ($id_user === '') {
        echo json_encode([
            "status" => false,
            "message" => "id_user wajib diisi"
        ]);
        exit;
    }

    // query update
    $query = mysqli_query($koneksi, "
        UPDATE tb_user SET
            nama   = '$nama',
            email  = '$email',
            role   = '$role',
            status = '$status'
        WHERE id_user = '$id_user'
    ");

    // response
    if ($query) {
        echo json_encode([
            "status" => true,
            "message" => "User berhasil diupdate"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Gagal update user",
            "error" => mysqli_error($koneksi)
        ]);
    }

    exit;
}

// jika method bukan PUT
echo json_encode([
    "status" => false,
    "message" => "Method tidak diizinkan"
]);
