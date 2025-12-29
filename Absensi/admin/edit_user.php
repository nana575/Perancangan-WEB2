<?php
session_start();
include "../0koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login/1login.html");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: user.php");
    exit();
}

// AMBIL DATA USER
$data = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE id_user='$id'");
$user = mysqli_fetch_assoc($data);

if (!$user) {
    die("Data user tidak ditemukan");
}

// PROSES UPDATE
if (isset($_POST['update'])) {
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $username = $_POST['username'];
    $role     = $_POST['role'];
    $status   = $_POST['status'];

    // kalau password diisi → update
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE tb_user SET
                    nama='$nama',
                    email='$email',
                    username='$username',
                    password='$password',
                    role='$role',
                    status='$status'
                WHERE id_user='$id'";
    } else {
        $sql = "UPDATE tb_user SET
                    nama='$nama',
                    email='$email',
                    username='$username',
                    role='$role',
                    status='$status'
                WHERE id_user='$id'";
    }

    if (mysqli_query($koneksi, $sql)) {
        header("Location: user.php?msg=update");
        exit();
    } else {
        $error = "Gagal update data";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    background:#f4f6f9;
    font-family:'Segoe UI', sans-serif;
}
.container{
    max-width:600px;
    margin-top:40px;
}
</style>
</head>
<body>

<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-pencil-square"></i> Edit User
        </div>
        <div class="card-body">

            <?php if(isset($error)){ ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php } ?>

            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control"
                           value="<?= $user['nama'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="<?= $user['email'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control"
                           value="<?= $user['username'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password (opsional)</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Kosongkan jika tidak diubah">
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
                        <option value="dosen" <?= $user['role']=='dosen'?'selected':'' ?>>Dosen</option>
                        <option value="mahasiswa" <?= $user['role']=='mahasiswa'?'selected':'' ?>>Mahasiswa</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="1" <?= $user['status']==1?'selected':'' ?>>Aktif</option>
                        <option value="0" <?= $user['status']==0?'selected':'' ?>>Tidak Aktif</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="user.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" name="update" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>
