<?php
include '0koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM laporan ORDER BY tanggal DESC");
?>


<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Kaprodi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">


<div class="container mt-5">
<h3>Laporan</h3>
<p class="text-muted">Kelola dan unduh laporan program studi</p>


<table class="table table-hover bg-white rounded">
<thead class="table-light">
<tr>
<th>Nama Laporan</th>
<th>Kategori</th>
<th>Tanggal</th>
<th>Ukuran</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>


<?php while($row=mysqli_fetch_assoc($data)) { ?>
<tr>
<td><?= $row['nama_laporan']; ?></td>
<td><span class="badge bg-primary"><?= $row['kategori']; ?></span></td>
<td><?= date('d F Y', strtotime($row['tanggal'])); ?></td>
<td><?= $row['ukuran']; ?></td>
<td><span class="badge bg-success"><?= $row['status']; ?></span></td>
<td>
<a href="download_laporan.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">
⬇ Unduh
</a>
</td>
</tr>
<?php } ?>


</tbody>
</table>
</div>


</body>
</html>