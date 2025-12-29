<?php
session_start();
include "../0koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login/1login.html");
    exit();
}

// DATA USER
$id_user = $_SESSION['id_user'] ?? 0;

$user = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM tb_user WHERE id_user='$id_user'")
);

$nama = $user['nama'] ?? 'Admin';
$role = ucfirst($_SESSION['role'] ?? 'admin');

$foto = (!empty($user['foto']) && file_exists("../uploads/profile/".$user['foto']))
    ? "../uploads/profile/".$user['foto']
    : "../uploads/profile/default.jpg";

// QUERY DOSEN + PRODI
$query = mysqli_query($koneksi, "
    SELECT 
        d.*,
        p.nama_prodi
    FROM tb_dosen d
    LEFT JOIN tb_prodi p ON d.id_prodi = p.id_prodi
    ORDER BY d.nama_dosen ASC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Dosen</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    margin:0;
    background:#f4f6f9;
    font-family:'Segoe UI', sans-serif;
}
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
.submenu a{padding-left:40px;font-size:14px;}
.profile-box{
    display:flex;
    align-items:center;
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
    padding-bottom:60px;
}
.table th,.table td{font-size:14px;vertical-align:middle;}
.col-no{width:60px;}
.col-aksi{width:120px;text-align:center;}
.col-status{width:100px;text-align:center;}
.footer{
    position:fixed;
    bottom:0;
    left:260px;
    right:0;
    height:40px;
    background:#fff;
    border-top:1px solid #ddd;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:13px;
    color:#666;
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
    </div>

    <hr class="border-secondary">

    <a href="#"><i class="bi bi-calendar3 me-2"></i>Jadwal</a>
    <a href="#"><i class="bi bi-qr-code me-2"></i>QR Code</a>
    <a href="#"><i class="bi bi-journal-text me-2"></i>Jurnal</a>
    <a href="#"><i class="bi bi-file-earmark-text me-2"></i>Laporan</a>
    <hr>
    <a href="../login/1login.html" class="text-danger">
        <i class="bi bi-box-arrow-right me-2"></i>Logout
    </a>
</div>

<!-- CONTENT -->
<div class="content">
    <h4>Data Dosen</h4>
    <p class="text-muted">Kelola data dosen</p>

    <div class="d-flex justify-content-between mb-3">
        <input type="text" id="search" class="form-control w-50" placeholder="Cari nama dosen...">
        <a href="2tambah_data.html" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Dosen
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover align-middle text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="col-no">No</th>
                            <th>NIDN</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Email</th>
                            <th class="col-status">Status</th>
                            <th class="col-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                    <?php $no=1; while($row=mysqli_fetch_assoc($query)){ ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nidn'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['nama_prodi'] ?? '-' ?></td>
                            <td><?= $row['email'] ?></td>
                            <td class="col-status">
                                <span class="badge bg-success">Aktif</span>
                            </td>
                            <td class="col-aksi">
                                <a href="3edit_dosen.php?id=<?= $row['id_dosen'] ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="3hapus_data.php?id=<?= $row['id_dosen'] ?>"
                                   onclick="return confirm('Yakin hapus data?')"
                                   class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<div class="footer">
    © <?= date('Y') ?> Sistem Akademik • Admin Panel
</div>

<script>
document.getElementById("search").addEventListener("keyup", function(){
    let value = this.value.toLowerCase();
    document.querySelectorAll("#tableBody tr").forEach(tr=>{
        tr.style.display = tr.innerText.toLowerCase().includes(value) ? "" : "none";
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
