<?php
include "0koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>

    <!-- Bootstrap -->
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
            background-color: #0d6efd;
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
        }
        .table th {
            background-color: #f8f9fa;
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
        <h4>Data Mahasiswa</h4>
        <p class="text-muted">Kelola data mahasiswa di sistem akademik.</p>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <input type="text" class="form-control w-50" placeholder="Cari NIM atau Nama Mahasiswa...">
            <a href="2tambah_data.html" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Tambah Mahasiswa
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table align-middle table-bordered">
                    <thead>
                        <tr>
                            <th>ID Mahasiswa</th>
                            <th>ID User</th>
                            <th>ID Prodi</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Angkatan</th>
                            <th>Kelas</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM tb_mahasiswa";
                        $result = mysqli_query($koneksi, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                    <td>{$row['id_mahasiswa']}</td>
                                    <td>{$row['id_user']}</td>
                                    <td>{$row['id_prodi']}</td>
                                    <td>{$row['nama']}</td>
                                    <td>{$row['nim']}</td>
                                    <td>{$row['angkatan']}</td>
                                    <td>{$row['kelas']}</td>
                                    <td>{$row['email']}</td>
                                    <td><span class='badge bg-success'>Aktif</span></td>
                                    <td class='text-center'>
                                        <a href='3up_mahasiswa.php?id={$row['id_mahasiswa']}' class='text-warning me-2'>
                                            <i class='bi bi-pencil-square'></i>
                                        </a>
                                        <a href='3hapus_mahasiswa.php?id={$row['id_mahasiswa']}' class='text-danger' onclick='return confirm(\"Yakin ingin hapus data ini?\")'>
                                            <i class='bi bi-trash'></i>
                                        </a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10' class='text-center text-muted'>Tidak ada data</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
