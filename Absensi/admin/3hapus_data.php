<?php
include "0koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Cek dulu apakah datanya ada
    $cek = mysqli_query($koneksi, "SELECT * FROM tb_mahasiswa WHERE id_mahasiswa='$id'");
    if (mysqli_num_rows($cek) > 0) {
        $query = "DELETE FROM tb_mahasiswa WHERE id_mahasiswa='$id'";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo "<script>
                    alert('Data berhasil dihapus!');
                    window.location.href='3mahasiswa.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal menghapus data!');
                    window.location.href='3mahasiswa.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Data tidak ditemukan!');
                window.location.href='3mahasiswa.php';
              </script>";
    }
} else {
    header("Location: 3mahasiswa.php");
    exit();
}
?>
