<?php
include "0koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data umum user
    $id_user = $_POST['id_user'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $username = $_POST['username']; 
    $password = $_POST['password'];
    $status = $_POST['status'];

    // Insert ke tabel user
    $sql = "INSERT INTO tb_user (id_user, username, password, role, nama, email, status)
            VALUES ('$id_user', '$username', '$password', '$role', '$nama', '$email', '$status')";

    if ($koneksi->query($sql) === TRUE) {

        // === kalau role mahasiswa ===
        if ($role == "mahasiswa") {
            $id_mahasiswa = $_POST['id_mahasiswa'];
            $nim = $_POST['nim'];
            $angkatan = $_POST['angkatan'];
            $kelas = $_POST['kelas'];
            $id_prodi = $_POST['id_prodi'];

            $querymhs = "INSERT INTO tb_mahasiswa (id_mahasiswa, id_user, id_prodi, nama, nim, angkatan, kelas, email)
                         VALUES ('$id_mahasiswa', '$id_user', '$id_prodi', '$nama', '$nim', '$angkatan', '$kelas', '$email')";
            $koneksi->query($querymhs);

        // === kalau role dosen ===
        } elseif ($role == "dosen") {
            $id_dosen = $_POST['id_dosen'];
            $id_prodi = $_POST['id_prodi'];
            $id_mk = $_POST['id_mk'] ?? null; // kalau belum ada input mk, bisa null
            $nidn = $_POST['nidn'] ?? '';
            $nama_dosen = $nama; // dari input nama

            $querydosen = "INSERT INTO tb_dosen (id_dosen, id_user, id_mk, id_prodi, nidn, nama_dosen, email)
                           VALUES ('$id_dosen', '$id_user', '$id_mk', '$id_prodi', '$nidn', '$nama_dosen', '$email')";
            $koneksi->query($querydosen);

        // === kalau role admin ===
        } elseif ($role == "admin") {
            $id_admin = $_POST['id_admin'] ;
            $id_userv = $_POST['id_user'];
            $id_prodi = $_POST['id_prodi'];
            $nama = $_POST['nama'];
            $email = $_POST['email'];

            $queryadmin = "INSERT INTO tb_admin (id_admin, id_user, id_prodi, nama, email)
                           VALUES ('$id_admin', '$id_user', '$id_prodi', '$nama', '$email')";
            $koneksi->query($queryadmin);
        }

        echo "<script>
            alert('Pendaftaran berhasil!'); 
            window.location= '4dashboard_admin.php';
            </script>";

    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

$koneksi->close();
?>
