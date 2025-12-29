<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include "koneksi.php";

// ambil body JSON
$input = json_decode(file_get_contents("php://input"), true);

// validasi id_user
if (!isset($input['id_user']) || empty($input['id_user'])) {
    http_response_code(400);
    echo json_encode([
        "status" => false,
        "message" => "id_user wajib diisi"
    ]);
    exit;
}

$id_user = mysqli_real_escape_string($koneksi, $input['id_user']);

// cek apakah user ada
$cek = mysqli_query($koneksi, "SELECT id_user FROM tb_user WHERE id_user='$id_user'");
if (mysqli_num_rows($cek) == 0) {
    http_response_code(404);
    echo json_encode([
        "status" => false,
        "message" => "User tidak ditemukan"
    ]);
    exit;
}

// proses delete
$hapus = mysqli_query(
    $koneksi,
    "DELETE FROM tb_user WHERE id_user='$id_user'"
);

if ($hapus) {
    echo json_encode([
        "status" => true,
        "message" => "User berhasil dihapus"
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "message" => "Gagal menghapus user"
    ]);
}
