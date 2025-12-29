<?php
include "../0koneksi.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: 4dashboard_admin.php");
    exit;
}

// ===============================
// DATA USER
// ===============================
$id_user   = $_POST['id_user'];
$nama      = $_POST['nama'];
$email     = $_POST['email'];
$role      = $_POST['role'];
$username  = $_POST['username'];
$password  = password_hash($_POST['password'], PASSWORD_DEFAULT);
$status    = $_POST['status'];

// ===============================
// INSERT TB_USER
// ===============================
$sqlUser = "INSERT INTO tb_user 
(id_user, username, password, role, nama, email, status)
VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmtUser = $koneksi->prepare($sqlUser);
$stmtUser->bind_param(
    "ssssssi",
    $id_user,
    $username,
    $password,
    $role,
    $nama,
    $email,
    $status
);

if (!$stmtUser->execute()) {
    die("Gagal simpan user: " . $stmtUser->error);
}

// ===============================
// INSERT BERDASARKAN ROLE
// ===============================
$infoTambahan = "";

if ($role == "mahasiswa") {

    $sql = "INSERT INTO tb_mahasiswa
    (id_mahasiswa, id_user, id_prodi, nama, nim, angkatan, kelas, email)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param(
        "ssssssss",
        $_POST['id_mahasiswa'],
        $id_user,
        $_POST['id_prodi'],
        $nama,
        $_POST['nim'],
        $_POST['angkatan'],
        $_POST['kelas'],
        $email
    );

    $stmt->execute();
    $infoTambahan = "Mahasiswa (NIM: {$_POST['nim']})";

} elseif ($role == "dosen") {

    $id_mk = $_POST['id_mk'] ?? NULL;

    $sql = "INSERT INTO tb_dosen
    (id_dosen, id_user, id_mk, id_prodi, nidn, nama_dosen, email)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param(
        "sssssss",
        $_POST['id_dosen'],
        $id_user,
        $id_mk,
        $_POST['id_prodi'],
        $_POST['nidn'],
        $nama,
        $email
    );

    $stmt->execute();
    $infoTambahan = "Dosen (NIDN: {$_POST['nidn']})";

} elseif ($role == "admin") {

    $sql = "INSERT INTO tb_admin
    (id_admin, id_user, id_prodi, nama, email)
    VALUES (?, ?, ?, ?, ?)";

    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param(
        "sssss",
        $_POST['id_admin'],
        $id_user,
        $_POST['id_prodi'],
        $nama,
        $email
    );

    $stmt->execute();
    $infoTambahan = "Admin Sistem";
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pendaftaran Berhasil</title>
<style>
body{
    background:#f4f6f9;
    font-family:Segoe UI;
}
.box{
    max-width:600px;
    margin:80px auto;
    background:#fff;
    padding:40px;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,.1);
    text-align:center;
}
.check{
    font-size:80px;
    color:#27ae60;
}
.info{
    text-align:left;
    margin-top:30px;
}
.info p{
    margin:8px 0;
}
.btn{
    display:inline-block;
    margin-top:30px;
    padding:12px 25px;
    background:#4e73df;
    color:#fff;
    border-radius:8px;
    text-decoration:none;
}
</style>
</head>

<body>
<div class="box">
    <div class="check">✓</div>
    <h2>Pendaftaran Berhasil</h2>
    <p>Data berhasil disimpan ke database</p>

    <div class="info">
        <p><b>Nama</b> : <?= $nama ?></p>
        <p><b>Email</b> : <?= $email ?></p>
        <p><b>Username</b> : <?= $username ?></p>
        <p><b>Role</b> : <?= ucfirst($role) ?></p>
        <p><b>Info</b> : <?= $infoTambahan ?></p>
    </div>

    <a href="4dashboard_admin.php" class="btn">Ke Dashboard</a>
</div>

<script>
setTimeout(()=>{
    window.location.href="4dashboard_admin.php";
},3000);
</script>
</body>
</html>
