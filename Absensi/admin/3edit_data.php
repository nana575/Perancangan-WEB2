<?php
include "../0koneksi.php";

// Cek apakah ada parameter id_mahasiswa dari URL
if (isset($_GET['id'])) {
    $id_mahasiswa = $_GET['id'];

    // Ambil data mahasiswa berdasarkan id
    $query = "SELECT * FROM tb_mahasiswa WHERE id_mahasiswa='$id_mahasiswa'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        echo "<script>
                alert('Data tidak ditemukan!');
                window.location.href='3mahasiswa.php';
              </script>";
        exit;
    }
}

// Jika tombol submit ditekan (form disubmit)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $id_prodi = $_POST['id_prodi'];
    $angkatan = $_POST['angkatan'];
    $kelas = $_POST['kelas'];
    $email = $_POST['email'];

    $query_update = "UPDATE tb_mahasiswa SET 
                        nama='$nama', 
                        nim='$nim', 
                        id_prodi='$id_prodi',
                        angkatan='$angkatan',
                        kelas='$kelas',
                        email='$email'
                    WHERE id_mahasiswa='$id_mahasiswa'";

    $update_result = mysqli_query($koneksi, $query_update);

    if ($update_result) {
        echo "<script>
                alert('Data berhasil diperbarui!');
                window.location.href='3mahasiswa.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data!');
                window.location.href='3mahasiswa.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4>Edit Data Mahasiswa</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <input type="hidden" name="id_mahasiswa" value="<?= $data['id_mahasiswa']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?= $data['nama']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIM</label>
                        <input type="text" name="nim" class="form-control" value="<?= $data['nim']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ID Prodi</label>
                        <input type="text" name="id_prodi" class="form-control" value="<?= $data['id_prodi']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Angkatan</label>
                        <input type="text" name="angkatan" class="form-control" value="<?= $data['angkatan']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" name="kelas" class="form-control" value="<?= $data['kelas']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $data['email']; ?>" required>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    <a href="3mahasiswa.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
