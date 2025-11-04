<?php
session_start();
include "0koneksi.php";


if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$q_mahasiswa = mysqli_query($koneksi, "select count(*)as total from tb_mahasiswa");
$q_dosen = mysqli_query($koneksi, "select count(*)as total from tb_dosen");
$q_jadwal = mysqli_query($koneksi, "select count(*)as total from tb_jadwal");
$q_kehadiran = mysqli_query($koneksi, "select count(*)as total from tb_kehadiran");

$total_mahasiswa = mysqli_fetch_assoc($q_mahasiswa)['total'];
$total_dosen = mysqli_fetch_assoc($q_dosen)['total'];
$total_jadwal = mysqli_fetch_assoc($q_jadwal)['total'];
$total_kehadiran = mysqli_fetch_assoc($q_kehadiran)['total'];

$q_aktivitas = mysqli_query($koneksi, "SELECT * FROM tb_log ORDER BY waktu DESC LIMIT 6");

$q_jadwal_hari_ini = mysqli_query($koneksi, "
    select * from tb_jadwal
    where dayofweek(now()) = hari
    order by jam_mulai
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

     <style>
       body {
            background-color: #f5f6fa;
            display: flex;
            font-family: 'Segoe UI', sans-serif;
        }
        .sidebar {
            width: 250px;
            background-color: #14243dff;
            color: white;
            padding: 20px;
            height: 100vh;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 8px 0;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
            padding-left: 5px;
        }
        .content {
            flex: 1;
            padding: 25px;
            background-color: #f5f6fa;
        }
        .card {
            border: none;
            border-radius: 10px;
            transition: all 0.2s ease-in-out;
        }

        .card:hover {        
        transform: translateY(-4px);
        }
        
        .list-group-item {
        font-size: 0.9rem;
        }
    </style>
   
</head>
<body>
   <aside class="sidebar">
        <div class="brand mb-3">
            <div class="h5 mb-0">Admin Panel</div>
            <small>Sistem Akademik</small>
        </div><hr>

        <div class="mb-4">
            <div class="fw-semibold">Admin User</div>
            <small>Administrator</small>
        </div>
        <hr>

        <nav>
            <a href="4dashboard_admin.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            <div class="mt-3 fw-semibold">Data Master</div>
            <a href="3mahasiswa.php"><i class="bi bi-people me-2"></i>Mahasiswa</a>
            <a href="#"><i class="bi bi-person-badge me-2"></i>Dosen</a>
            <a href="#"><i class="bi bi-book me-2"></i>Prodi</a>
            <a href="#"><i class="bi bi-person-circle me-2"></i>User</a>
            <hr>
            <a href="#"><i class="bi bi-calendar3 me-2"></i>Jadwal Perkuliahan</a>
            <a href="#"><i class="bi bi-qr-code me-2"></i>QR Code</a>
            <a href="#"><i class="bi bi-journal-text me-2"></i>Jurnal</a>
            <a href="#"><i class="bi bi-file-earmark-text me-2"></i>Laporan</a>
        </nav>
        <hr>
        <a href="1logout.php" class="btn btn-danger w-100 mt-2"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
    </aside>

     <div class="content">
  <h3>Dashboard</h3>
  <p>Selamat datang di Sistem Manajemen Akademik</p>

  <div class="container-fluid mt-4">
    <div class="row g-3">
      <div class="col-md-3">
        <div class="card shadow-sm text-center p-3">
          <div class="text-primary"><i class="bi bi-mortarboard fs-3"></i></div>
          <h6>Total Mahasiswa</h6>
          <h3><?= $total_mahasiswa ?></h3>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card shadow-sm text-center p-3">
          <div class="text-success"><i class="bi bi-person-badge fs-3"></i></div>
          <h6>Total Dosen</h6>
          <h3><?= $total_dosen ?></h3>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card shadow-sm text-center p-3">
          <div class="text-warning"><i class="bi bi-calendar3 fs-3"></i></div>
          <h6>Jadwal Aktif</h6>
          <h3><?= $total_jadwal ?></h3>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card shadow-sm text-center p-3">
          <div class="text-danger"><i class="bi bi-person-check fs-3"></i></div>
          <h6>Kehadiran Hari Ini</h6>
          <h3><?= $total_kehadiran ?></h3>
        </div>
      </div>
    </div>
  </div>
</div>


     <div class="container-fluid mt-4">
    <div class="row g-3">
      <!-- Aktivitas Terbaru -->
      <div class="col-md-7">
        <div class="card shadow-sm p-3">
          <h5>Aktivitas Terbaru</h5>
          <ul class="list-group list-group-flush mt-2">
            <?php while ($log = mysqli_fetch_assoc($q_aktivitas)) { ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <i class="bi bi-dot text-success"></i>
                  <?= $log['aktivitas'] ?> oleh <b><?= $log['nama_user'] ?></b>
                </div>
                <small class="text-muted"><?= $log['waktu'] ?></small>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>

      <!-- Jadwal Hari Ini -->
      <div class="col-md-5">
        <div class="card shadow-sm p-3">
          <h5>Jadwal Kuliah Hari Ini</h5>
          <ul class="list-group list-group-flush mt-2">
            <?php while ($jadwal = mysqli_fetch_assoc($q_jadwal_hari_ini)) { ?>
              <li class="list-group-item">
                <b><?= $jadwal['mata_kuliah'] ?></b><br>
                <small><?= $jadwal['jam_mulai'] ?> - <?= $jadwal['jam_selesai'] ?></small>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>

