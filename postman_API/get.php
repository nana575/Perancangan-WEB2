<?php
header("Content-Type: application/json");
include "koneksi.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'GET') {
    echo json_encode([
        "status" => false,
        "message" => "Hanya menerima GET"
    ]);
    exit;
}

// GET semua user
$query = mysqli_query($koneksi, "SELECT * FROM tb_user ORDER BY nama ASC");

$data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode([
    "status" => true,
    "total" => count($data),
    "data" => $data
]);
