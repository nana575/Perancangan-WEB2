<?php
include "../0koneksi.php";

if(isset($_POST['submit'])) {
    $nama_mk = $_POST['nama_mk'] ?? '';

    if($nama_mk != '') {
        $sql = "INSERT INTO tb_mk (nama_mk) VALUES (?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("s", $nama_mk);
        if($stmt->execute()) {
            echo "Mata kuliah berhasil ditambahkan!";
        } else {
            echo "Gagal menambahkan MK: " . $koneksi->error;
        }
        $stmt->close();
    } else {
        echo "Nama mata kuliah wajib diisi!";
    }
}
?>

<h2>Tambah Mata Kuliah</h2>
<form action="" method="post">
    <input type="text" name="nama_mk" placeholder="Nama Mata Kuliah">
    <button type="submit" name="submit">Tambah</button>
</form>
