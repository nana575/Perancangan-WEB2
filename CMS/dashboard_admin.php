<?php
session_start();
include "../0koneksi.php";

/* =======================
   CEK LOGIN ADMIN
======================= */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login/login.html");
    exit();
}

/* =======================
   DATA USER LOGIN
======================= */
$id_user = $_SESSION['id_user'] ?? 0;

$user = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM tb_user WHERE id_user='$id_user'")
);

// fallback biar aman
$nama = $user['nama'] ?? 'Admin';
$role = ucfirst($_SESSION['role'] ?? 'admin');

// foto profil
$foto = (!empty($user['foto']) && file_exists("../uploads/profile/".$user['foto']))
    ? "../uploads/profile/".$user['foto']
    : "../uploads/profile/default.jpg";

/* =======================
   STATISTIK
======================= */
$total_mahasiswa = mysqli_fetch_assoc(
    mysqli_query($koneksi,"SELECT COUNT(*) AS total FROM tb_mahasiswa")
)['total'] ?? 0;

$total_dosen = mysqli_fetch_assoc(
    mysqli_query($koneksi,"SELECT COUNT(*) AS total FROM tb_dosen")
)['total'] ?? 0;

$total_jadwal = mysqli_fetch_assoc(
    mysqli_query($koneksi,"SELECT COUNT(*) AS total FROM tb_jadwal")
)['total'] ?? 0;

$total_hadir = mysqli_fetch_assoc(
    mysqli_query($koneksi,"SELECT COUNT(*) AS total FROM tb_kehadiran")
)['total'] ?? 0;

/* =======================
   DATA AKTIVITAS & JADWAL
======================= */
$q_aktivitas = mysqli_query($koneksi,"
    SELECT * FROM tb_log 
    ORDER BY waktu DESC 
    LIMIT 6
");

$q_jadwal = mysqli_query($koneksi,"
    SELECT * FROM tb_jadwal 
    WHERE DAYOFWEEK(NOW()) = hari 
    ORDER BY jam_mulai
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{background:#f4f6f9}
.sidebar{
    width:260px;
    height:100vh;
    background:#181844;
    color:white;
    position:fixed;
    padding:20px;
    overflow-y:auto;
}
.sidebar a{
    color:#ddd;
    text-decoration:none;
    display:block;
    padding:10px 15px;
    border-radius:6px;
}
.sidebar a:hover{
    background:#2c2c6c;
    color:white;
}
.submenu a{
    padding-left:40px;
    font-size:14px;
}
.profile-box{
    display:flex;
    align-items: center;
}
.profile-box img{
    width:50px;
    height:50px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid #fff;
}
.content{
    margin-left:260px;
    padding:25px;
}
.card-icon{
    font-size:32px;
}
.footer{
    position:fixed;
    bottom:0;
    left:260px; /* sejajar sidebar */
    right:0;
    height:40px;
    background:#ffffff;
    border-top:1px solid #ddd;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:13px;
    color:#666;
    z-index:999;
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
        <a href="../profil.php" class="profile-link">
            <img src="<?= $foto ?>">
        </a>
        <div>
            <div class="fw-semibold"><?= htmlspecialchars($nama) ?></div>
            <small class="text-secondary"><?= htmlspecialchars($role) ?></small>
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
        <a href="5dosen.php" class="text-white fw-semibold">
            <i class="bi bi-person-badge me-2"></i>Dosen
        </a>
        <a href="prodi.php"><i class="bi bi-book me-2"></i>Prodi</a>
        <a href="user.php"><i class="bi bi-person-circle me-2"></i>User</a>
        <a href="mk.php"><i class="bi bi-book-half me-2"></i>Matakuliah</a>
    </div>

    <hr class="border-secondary">

    <a href="jadwal.php"><i class="bi bi-calendar3 me-2"></i>Jadwal</a>
    <a href="qr.php"><i class="bi bi-qr-code me-2"></i>QR Code</a>
    <a href="kuisioner.php"><i class="bi bi-journal-text me-2"></i>Kuisioner</a>
    <a href="laporan.php"><i class="bi bi-file-earmark-text me-2"></i>Laporan</a>
    <hr>
    <a href="../login/login.html" class="text-danger">
        <i class="bi bi-box-arrow-right me-2"></i>Logout
    </a>
</div>

<!-- CONTENT -->
<div class="content">
<h4 class="fw-bold mb-4">Dashboard</h4>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm p-3">
            <i class="bi bi-mortarboard text-primary card-icon"></i>
            <div class="fw-semibold">Mahasiswa</div>
            <h4><?= $total_mahasiswa ?></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm p-3">
            <i class="bi bi-person-badge text-success card-icon"></i>
            <div class="fw-semibold">Dosen</div>
            <h4><?= $total_dosen ?></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm p-3">
            <i class="bi bi-calendar text-warning card-icon"></i>
            <div class="fw-semibold">Jadwal</div>
            <h4><?= $total_jadwal ?></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm p-3">
            <i class="bi bi-person-check text-danger card-icon"></i>
            <div class="fw-semibold">Kehadiran</div>
            <h4><?= $total_hadir ?></h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold">
                <i class="bi bi-clock-history me-2"></i>Aktivitas Terbaru
            </div>
            <ul class="list-group list-group-flush">
                <?php if(mysqli_num_rows($q_aktivitas) == 0){ ?>
                    <li class="list-group-item text-muted">Belum ada aktivitas</li>
                <?php } ?>
                <?php while($a=mysqli_fetch_assoc($q_aktivitas)){ ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span><?= $a['aktivitas'] ?> <b><?= $a['nama_user'] ?></b></span>
                    <small><?= $a['waktu'] ?></small>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold">
                <i class="bi bi-calendar-event me-2"></i>Jadwal Hari Ini
            </div>
            <ul class="list-group list-group-flush">
                <?php if(mysqli_num_rows($q_jadwal) == 0){ ?>
                    <li class="list-group-item text-muted">Tidak ada jadwal</li>
                <?php } ?>
                <?php while($j=mysqli_fetch_assoc($q_jadwal)){ ?>
                <li class="list-group-item">
                    <b><?= $j['mata_kuliah'] ?></b><br>
                    <small><?= $j['jam_mulai'] ?> - <?= $j['jam_selesai'] ?></small>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
</div>
    <!-- FOOTER -->
    <div class="footer">
        © <?= date('Y') ?> Sistem Akademik • Admin Panel
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
