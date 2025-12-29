<?php
session_start();
include "../0koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login/1login.html");
    exit();
}

// ambil ID
$id_prodi = $_GET['id'] ?? null;
if (!$id_prodi) {
    header("Location: 3prodi.php");
    exit();
}

// ambil data prodi
$data = mysqli_query($koneksi, "SELECT * FROM tb_prodi WHERE id_prodi='$id_prodi'");
$prodi = mysqli_fetch_assoc($data);
if (!$prodi) {
    header("Location: 3prodi.php");
    exit();
}

// proses update
if (isset($_POST['update'])) {
    $kode_prodi = $_POST['kode_prodi'];
    $nama_prodi = $_POST['nama_prodi'];
    $jenjang    = $_POST['jenjang'];

    mysqli_query($koneksi, "
        UPDATE tb_prodi SET
            kode_prodi='$kode_prodi',
            nama_prodi='$nama_prodi',
            jenjang='$jenjang'
        WHERE id_prodi='$id_prodi'
    ");

    header("Location: 3prodi.php");
    exit();
}

// DATA USER
$nama = $_SESSION['nama'] ?? 'Admin';
$role = ucfirst($_SESSION['role'] ?? 'admin');
$foto = "../uploads/profile/default.jpg";
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Prodi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{margin:0;background:#f4f6f9;font-family:'Segoe UI',sans-serif;}
.sidebar{
    width:260px;height:100vh;background:#181844;color:white;
    position:fixed;padding:20px;overflow-y:auto;
}
.sidebar a{color:#ddd;text-decoration:none;display:block;padding:10px 15px;border-radius:6px;}
.sidebar a:hover{background:#2c2c6c;color:white;}
.submenu a{padding-left:40px;font-size:14px;}
.profile-box{display:flex;align-items:center;gap:10px;}
.profile-box img{
    width:45px;height:45px;border-radius:50%;
    object-fit:cover;border:2px solid #fff;
}
.content{
    margin-left:260px;
    padding:25px;
    padding-bottom:60px;
}
.footer{
    position:fixed;bottom:0;left:260px;right:0;height:40px;
    background:#fff;border-top:1px solid #ddd;
    display:flex;align-items:center;justify-content:center;
    font-size:13px;color:#666;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h5 class="fw-bold">Admin Panel</h5>
    <small class="text-secondary">Sistem Akademik</small>
    <hr>

    <div class="profile-box mb-3">
        <img src="<?= $foto ?>">
        <div>
            <div class="fw-semibold"><?= $nama ?></div>
            <small class="text-secondary"><?= $role ?></small>
        </div>
    </div>

    <hr>

    <a href="4dashboard_admin.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>

    <a data-bs-toggle="collapse" href="#dataMaster">
        <i class="bi bi-folder me-2"></i>Data Master
        <i class="bi bi-chevron-down float-end"></i>
    </a>

    <div class="collapse show submenu" id="dataMaster">
        <a href="3mahasiswa.php"><i class="bi bi-people me-2"></i>Mahasiswa</a>
        <a href="3dosen.php"><i class="bi bi-person-badge me-2"></i>Dosen</a>
        <a href="3prodi.php" class="text-white fw-semibold">
            <i class="bi bi-book me-2"></i>Prodi
        </a>
    </div>

    <hr>
    <a href="../login/1login.html" class="text-danger">
        <i class="bi bi-box-arrow-right me-2"></i>Logout
    </a>
</div>

<!-- CONTENT -->
<div class="content">
    <h4>Edit Program Studi</h4>
    <p class="text-muted">Perbarui data program studi</p>

    <div class="card shadow-sm col-md-6">
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Kode Prodi</label>
                    <input type="text" name="id_Prodi" class="form-control"
                           value="<?= $prodi['id_Prodi'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Prodi</label>
                    <input type="text" name="nama_prodi" class="form-control"
                           value="<?= $prodi['nama_prodi'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenjang</label>
                    <select name="jenjang" class="form-select" required>
                        <option value="D3" <?= $prodi['jenjang']=='D3'?'selected':'' ?>>D3</option>
                        <option value="S1" <?= $prodi['jenjang']=='S1'?'selected':'' ?>>S1</option>
                        <option value="S2" <?= $prodi['jenjang']=='S2'?'selected':'' ?>>S2</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="prodi.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" name="update" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- FOOTER -->
<div class="footer">
    © <?= date('Y') ?> Sistem Akademik • Admin Panel
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
