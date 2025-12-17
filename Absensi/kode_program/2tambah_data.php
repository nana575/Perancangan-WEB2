<?php
include "0koneksi.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

$id_user  = $_POST['id_user'];
$nama     = $_POST['nama'];
$email    = $_POST['email'];
$role     = $_POST['role'];
$username = $_POST['username'];
$status   = $_POST['status'];

// HASH PASSWORD (WAJIB)
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// INSERT USER
$stmt = $koneksi->prepare("
INSERT INTO tb_user 
(id_user, username, password, role, nama, email, status, is_verified) 
VALUES (?,?,?,?,?,?,?,0)
");
$stmt->bind_param("ssssssi",
    $id_user, $username, $password, $role, $nama, $email, $status
);
$stmt->execute();

// ROLE MAHASISWA
if($role=="mahasiswa"){
    $stmt = $koneksi->prepare("
    INSERT INTO tb_mahasiswa
    (id_mahasiswa, id_user, id_prodi, nama, nim, angkatan, kelas, email)
    VALUES (?,?,?,?,?,?,?,?)
    ");
    $stmt->bind_param("ssssssss",
        $_POST['id_mahasiswa'],
        $id_user,
        $_POST['id_prodi'],
        $nama,
        $_POST['nim'],
        $_POST['angkatan'],
        $_POST['kelas'],
        $email
    );
    $stmt->execute();
}

// ROLE DOSEN
if($role=="dosen"){
    $stmt = $koneksi->prepare("
    INSERT INTO tb_dosen
    (id_dosen, id_user, id_prodi, nama_dosen, email)
    VALUES (?,?,?,?,?)
    ");
    $stmt->bind_param("sssss",
        $_POST['id_dosen'],
        $id_user,
        $_POST['id_prodi'],
        $nama,
        $email
    );
    $stmt->execute();
}

// ROLE ADMIN
if($role=="admin"){
    $stmt = $koneksi->prepare("
    INSERT INTO tb_admin
    (id_admin, id_user, nama, email)
    VALUES (?,?,?,?)
    ");
    $stmt->bind_param("ssss",
        $_POST['id_admin'],
        $id_user,
        $nama,
        $email
    );
    $stmt->execute();
}

echo "<script>alert('User berhasil ditambahkan');location='4dashboard_admin.php';</script>";
}
?>
