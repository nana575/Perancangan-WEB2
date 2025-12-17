<?php
include "0koneksi.php";

/* =====================
   AMBIL FILTER
   ===================== */
$id_prodi = $_GET['id_prodi'] ?? '';
$angkatan = $_GET['angkatan'] ?? '';
$kelas    = $_GET['kelas'] ?? '';

$where = [];

if ($id_prodi != '') {
    $where[] = "m.id_prodi = '$id_prodi'";
}
if ($angkatan != '') {
    $where[] = "m.angkatan = '$angkatan'";
}
if ($kelas != '') {
    $where[] = "m.kelas = '$kelas'";
}

$whereSQL = '';
if (!empty($where)) {
    $whereSQL = "WHERE " . implode(" AND ", $where);
}

/* =====================
   QUERY UTAMA (JOIN PRODI)
   ===================== */
$q = mysqli_query($koneksi, "
    SELECT 
        m.id_mahasiswa,
        m.nama,
        m.nim,
        m.angkatan,
        m.kelas,
        m.email,
        p.nama_prodi
    FROM tb_mahasiswa m
    LEFT JOIN tb_prodi p ON m.id_prodi = p.id_prodi
    $whereSQL
    ORDER BY m.id_mahasiswa DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Laporan Data Mahasiswa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4 bg-light">

<h4>Laporan Data Mahasiswa</h4>
<p class="text-muted">Rekap data mahasiswa</p>

<!-- =====================
     FILTER
     ===================== -->
<form method="get" class="row g-2 mb-3">
    <div class="col-md-3">
       <select name="id_prodi" class="form-select">
        <option value="" <?= ($id_prodi == '') ? 'selected' : '' ?>>
            -- Semua Prodi --
        </option>

        <?php
        $prodi = mysqli_query($koneksi, "SELECT * FROM tb_prodi");
        while($p = mysqli_fetch_assoc($prodi)){
            $selected = ($id_prodi !== '' && $id_prodi == $p['id_prodi']) ? 'selected' : '';
            echo "<option value='{$p['id_prodi']}' $selected>{$p['nama_prodi']}</option>";
        }
        ?>
    </select>

    </div>

    <div class="col-md-3">
        <select name="angkatan" class="form-select">
            <option value="">-- Semua Angkatan --</option>
            <?php
            for($i = 2018; $i <= date('Y'); $i++){
                $selected = ($angkatan == $i) ? 'selected' : '';
                echo "<option value='$i' $selected>$i</option>";
            }
            ?>
        </select>
    </div>

    <div class="col-md-2">
        <select name="kelas" class="form-select">
            <option value="">-- Semua Kelas --</option>
            <?php
            foreach(['A','B','C'] as $k){
                $selected = ($kelas == $k) ? 'selected' : '';
                echo "<option value='$k' $selected>$k</option>";
            }
            ?>
        </select>
    </div>

    <div class="col-md-3">
        <button class="btn btn-primary">Filter</button>
        <a href="3mahasiswa.php" class="btn btn-secondary">Reset</a>
        <a href="download_laporan.php?<?= http_build_query($_GET) ?>" class="btn btn-success">
            Export PDF
        </a>
    </div>
</form>

<!-- =====================
     TABEL DATA
     ===================== -->
<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>NIM</th>
    <th>Prodi</th>
    <th>Angkatan</th>
    <th>Kelas</th>
    <th>Email</th>
</tr>
</thead>

<tbody>
<?php
$no = 1;
if(mysqli_num_rows($q) > 0){
    while($row = mysqli_fetch_assoc($q)){
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $row['nama'] ?></td>
    <td><?= $row['nim'] ?></td>
    <td><?= $row['nama_prodi'] ?? '-' ?></td>
    <td><?= $row['angkatan'] ?></td>
    <td><?= $row['kelas'] ?></td>
    <td><?= $row['email'] ?></td>
</tr>
<?php
    }
} else {
    echo "<tr><td colspan='7' class='text-center'>Data tidak ditemukan</td></tr>";
}
?>
</tbody>
</table>
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show">
                📧 Laporan berhasil dikirim ke email, silakan cek inbox.
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php else: ?>
            <div class="alert alert-danger alert-dismissible fade show">
                ❌ Laporan gagal dikirim ke email.
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


