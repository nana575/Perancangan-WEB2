<?php
session_start();
include "0koneksi.php";
$username = $_POST['username'];
$password = $_POST['password'];

$sql ="select * from tb_user where username ='$username'";
$result = $koneksi->query($sql);

if ($result->num_rows) {
    $row= $result->fetch_assoc();

    if ($password == $row['password']){
    $_SESSION['id_user'] = $row['id_user'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['role'] = $row['role'];

        if ($row['role'] == 'admin'){
            header("Location: 4dashboard_admin.php");
        } elseif ($row['role'] == 'mahasiswa') {           
                header("Location: dashboard_mahasiswa.php");
        } else if ($row['role'] == 'dosen') {                
                    header("Location: dashboard_dosen.php");                
        }
        }
        } else {
            echo "<script>alert('Password Salah!'); window.location='1login.html';</script>";
}

$koneksi->close();
?>