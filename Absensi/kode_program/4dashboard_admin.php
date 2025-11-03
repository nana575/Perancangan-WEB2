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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2/dist.css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.font/bootstrap-icons.css" rel="stylesheet">

     <style>
       .sidebar {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 200px;
        background-color: rgba(24, 24, 68, 1);
        color: #fff;
        
       } 

       .dashboard {
        color: #fff;
        display: block;
        padding: 8px 16px;
        text-decoration: none;
       }      

       .dropdown1 {
        color: #fff;
        text-decoration: none;
       }
    </style>
   
</head>
<body>
    <aside class="sidebar">
        <div class="brand">
            <div class="logo text-white"><i class="bi-house-door-fill"></i></div>
            <div>
                <div class="h6 mb-0">Admin Panel</div>
                <div class="small-muted">Sistem Akademik</div>                
            </div>
        </div><hr>

        <div class="mb-4">
            <div class="text-white fw-semibold">Admin User</div>
            <div class="small-muted">Administration</div>
            <hr>
        </div>

        <nav class="dashboard">
            <a class="dashboard" href="4dashboard_admin.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a><br>
           
            <a class="dropdown1" href="3mahasiswa.php"><i class="bi bi-people me-2"></i>Mahasiswa</a><br>
            <a class="dropdown1" href="#"><i class="bi bi-person-badge me-2"></i>Dosen</a><br>
            <a class="dropdown1" href="#"><i class="bi bi-book me-2"></i>Prodi</a><br>
            <a class="dropdown1" href="#"><i class="bi bi-person-circle me-2"></i>User</a><br>

            <div class="small-muted mt-mb-2"></div>
            <a class="dropdown2" href="#"><i class="bi bi-calendar3 me-2"></i>Jadwal Perkuliahan</a><br>
            <a class="dropdown2" href="#"><i class="bi bi-qr-code me-2"></i>QR Code</a><br>
            <a class="dropdown2" href="#"><i class="bi bi-journal-text me=2"></i>Jurnal</a><br>
            <a class="dropdown2" href="#"><i class="bi bi-file=earmark-text me -2"></i>Laporan</a><br>

        </nav>
        <hr>
        <a href="logout.php" class="btn btn-danger w-100"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
    </aside>

    <!-- MAIN CONTENT -->
     <div class="content">
        <h3>Dashboard</h3>
        <p>Selamat datang di Sistem Manajemen Akademik</p>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="text-primary"><i class="bi bi-mortarboard fs-3"></i></div>
                <h5>Total Mahasiswa</h5>
                <h3><?= $total_mahasiswa?></h3>
            </div>            
        </div>
     </div>
     <div class="col-md-3">
        <div class="card shadow-sm text-center p-3">
            <div class="text-succes"><I class="bi bi-person-badge fs-3"></I></div>
            <h5>Total Dosen</h5>
            <h3><?= $total_dosen?></h3>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <div class="text-warning"><i class="bi bi-calendar3 fs-3"></i></div>
                <h5>Jadwal Aktif</h5>
                <h3><?=$total_jadwal?></h3>
            </div>            
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <div class="text-danger"><i class="bi bi-person-check fs-3"></i></div>
                <h5>Kehadiran Hari Ini</h5>
                <h3><?=$total_kehadiran ?></h3>
            </div>
        </div>
     </div>

    <div class="row g-3">
        <div class="cold-md-7">
            <div clss="card-shadow-sm p-3">
                <h5> Aktivitas Terbaru</h5>
                <ul class="list-group list-group-flush mt-2">
                    <?php while ($log = mysqli_fetch_assoc($q_aktivitas)) { ?>
                        <li class="list-group-item d-=flex justify-content-beetween">
                            <div>
                                <i class="bi bi-dot text-succes"></i>
                                <?=$log['aktivitas']?> oleh <b><?=$log['nama_user']?></b>
                            </div>
                            <small class="text-muted"><?=$log['waktu'] ?></small>                            
                        </li>
                        <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card shadow-sm p-3">
            <h5> Jadwal kuliah Hari Ini</h5>
            <ul class="list-group list-group-flush mt-2">
                <?php while ($jadwal = mysqli_fetch_assoc ($q_jadwal_hari_ini)){?>
                    <li class="list-group-item">
                        <b><?= $jadwal['mata_kuliah'] ?></b><br>
                        <small><?=$jadwal['jam_mulai'] ?>-<?=$jadwal['jam_selesai'] ?></small>                        
                    </li>
               <?php }?>
            </ul>
        </div>
    </div>
</body>
</html>

