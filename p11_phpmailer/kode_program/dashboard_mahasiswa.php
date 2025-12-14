<?php
session_start();
include "0koneksi.php";

// === CEK LOGIN ===
if (!isset($_SESSION['id_user'])) {
    header("Location: 1login.html");
    exit;
}

// === CEK ROLE ===
if ($_SESSION['role'] !== 'mahasiswa') {
    die("Akses ditolak!");
}

$id_user = $_SESSION['id_user'];

// === AMBIL DATA MAHASISWA ===
$q = $koneksi->prepare("
    SELECT m.*, p.nama_prodi 
    FROM tb_mahasiswa m
    JOIN tb_prodi p ON m.id_prodi = p.id_prodi
    WHERE m.id_user = ?
");
$q->bind_param("i", $id_user);
$q->execute();
$data = $q->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Mahasiswa</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { margin:0; font-family: 'Segoe UI', sans-serif; background:#f4f6f8; }
        .container { display:flex; }
        
        /* === SIDEBAR === */
        .sidebar {
            width:260px; background:#0f172a; color:white; min-height:100vh; padding:20px;
        }
        .sidebar h2 { margin-bottom:30px; font-size:20px; }
        .profile { margin-bottom:30px; }
        .menu a {
            display:flex; align-items:center; gap:10px;
            color:white; text-decoration:none;
            padding:12px; border-radius:8px; margin-bottom:8px;
        }
        .menu a.active, .menu a:hover { background:#16a34a; }

        /* === MAIN CONTENT === */
        .main { flex:1; padding:30px; }
        .header h1 { margin:0; }
        .cards { display:grid; grid-template-columns: repeat(4,1fr); gap:20px; margin-top:25px; }
        .card {
            background:white; padding:20px; border-radius:12px;
            box-shadow:0 4px 10px rgba(0,0,0,.05);
            display:flex; justify-content:space-between; align-items:center;
        }
        .card i { font-size:32px; }

        /* === TASKS === */
        .tasks {
            background:#fff7ed; padding:20px; border-radius:12px;
            margin-top:30px; border:1px solid #fed7aa;
        }
        .task {
            background:white; padding:15px; border-radius:10px;
            display:flex; justify-content:space-between; align-items:center;
            margin-top:10px;
        }
        .task span { font-size:13px; color:#555; }
        .btn {
            background:#16a34a; color:white; border:none;
            padding:8px 14px; border-radius:8px; cursor:pointer;
        }
        .logout { background:#ef4444; }
    </style>
</head>
<body>
<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2><i class="fa-solid fa-graduation-cap"></i> Portal Mahasiswa</h2>
        <div class="profile">
            <strong><?= htmlspecialchars($_SESSION['nama']) ?></strong><br>
            <small><?= htmlspecialchars($data['nim']) ?></small>
        </div>
        <div class="menu">
            <a class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="#"><i class="fa-solid fa-calendar"></i> Jadwal Perkuliahan</a>
            <a href="absensi.php"><i class="fa-solid fa-qrcode"></i> Scan QR Code</a>
            <a href="#"><i class="fa-solid fa-clipboard-list"></i> Kuisioner</a>
            <a href="logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <!-- MAIN -->
    <div class="main">
        <div class="header">
            <h1>Dashboard Mahasiswa</h1>
            <p>Selamat datang, <?= htmlspecialchars($_SESSION['nama']) ?> - <?= htmlspecialchars($data['kelas']) ?></p>
        </div>

        <div class="cards">
            <div class="card"><div><p>Mata Kuliah Aktif</p><h2>—</h2></div><i class="fa-solid fa-book"></i></div>
            <div class="card"><div><p>Jadwal Hari Ini</p><h2>—</h2></div><i class="fa-solid fa-calendar-day"></i></div>
            <div class="card"><div><p>Kehadiran</p><h2>—</h2></div><i class="fa-solid fa-user-check"></i></div>
            <div class="card"><div><p>Kuisioner</p><h2>—</h2></div><i class="fa-solid fa-file-lines"></i></div>
        </div>

        <div class="tasks">
            <h3><i class="fa-solid fa-calendar-day"></i> Jadwal Kuliah Hari Ini</h3>
            <div class="task">
                <div>
                    <strong>—</strong><br>
                    <span>Data jadwal akan ditampilkan dari database</span>
                </div>
                <button class="btn" disabled>Detail</button>
            </div>
            <div class="task">
                <div>
                    <strong>—</strong><br>
                    <span>Data jadwal akan ditampilkan dari database</span>
                </div>
                <button class="btn" disabled>Detail</button>
            </div>
        </div>

    </div>
</div>
</body>
</html>
