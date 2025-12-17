<?php
session_start();
include "0koneksi.php";

$token = $_GET['token'] ?? '';

if ($token == '') {
    die("Token tidak valid");
}

$q = $koneksi->prepare(
    "SELECT * FROM tb_user WHERE verify_token=?"
);
$q->bind_param("s", $token);
$q->execute();
$r = $q->get_result();

if ($r->num_rows == 0) {
    die("Token salah");
}

$user = $r->fetch_assoc();

// === update verifikasi ===
$upd = $koneksi->prepare(
    "UPDATE tb_user SET is_verified=1, verify_token=NULL WHERE id_user=?"
);
$upd->bind_param("i", $user['id_user']);
$upd->execute();

// === login otomatis ===
$_SESSION['id_user'] = $user['id_user'];
$_SESSION['nama']    = $user['nama'];
$_SESSION['role']    = $user['role'];

// === redirect ===
if ($user['role'] == 'admin') {
    header("Location: 4dashboard_admin.php");
} elseif ($user['role'] == 'mahasiswa') {
    header("Location: dashboard_mahasiswa.php");
} else {
    header("Location: dashboard_dosen.php");
}
exit;
