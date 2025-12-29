<?php
session_start();
include "0koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login/1login.html");
    exit();
}

$id_user = $_SESSION['id_user'];

/* =====================
   PROSES UPDATE PROFIL
===================== */
if (isset($_POST['update'])) {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);

    // FOTO
    if (!empty($_FILES['foto']['name'])) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nama_foto = "user_" . $id_user . "." . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/profile/" . $nama_foto);

        mysqli_query($koneksi, "
            UPDATE tb_user 
            SET nama='$nama', email='$email', username='$username', foto='$nama_foto'
            WHERE id_user='$id_user'
        ");
    } else {
        mysqli_query($koneksi, "
            UPDATE tb_user 
            SET nama='$nama', email='$email', username='$username'
            WHERE id_user='$id_user'
        ");
    }

    $_SESSION['nama'] = $nama;
    $success = "Profil berhasil diperbarui";
}

/* =====================
   AMBIL DATA USER
===================== */
$query = mysqli_query($koneksi, "
    SELECT * FROM tb_user WHERE id_user='$id_user'
");
$user = mysqli_fetch_assoc($query);

$foto = (!empty($user['foto']) && file_exists("uploads/profile/".$user['foto']))
        ? "uploads/profile/".$user['foto']
        : "uploads/profile/default.png";
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Profil Saya</title>
<style>
body{
    background:#f4f6f9;
    font-family:'Segoe UI',sans-serif;
    padding:30px;
}
.card{
    max-width:750px;
    margin:auto;
    background:#fff;
    padding:30px;
    border-radius:14px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}
.header{
    display:flex;
    align-items:center;
    gap:20px;
}
.header img{
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid #ddd;
}
.header h2{
    margin:0;
}
.badge{
    display:inline-block;
    margin-top:6px;
    padding:5px 14px;
    border-radius:20px;
    font-size:12px;
    background:#e3e7ff;
    color:#4b5cff;
    text-transform:uppercase;
    font-weight:600;
}
form{
    margin-top:30px;
}
.form-group{
    margin-bottom:18px;
}
label{
    font-weight:600;
    display:block;
    margin-bottom:6px;
}
input{
    width:100%;
    padding:12px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
}
.actions{
    margin-top:25px;
    display:flex;
    gap:10px;
}
.btn{
    padding:12px 22px;
    border-radius:8px;
    border:none;
    cursor:pointer;
    font-weight:600;
}
.btn-primary{
    background:#4b5cff;
    color:#fff;
}
.btn-secondary{
    background:#6c757d;
    color:#fff;
    text-decoration:none;
    display:inline-block;
}
.alert{
    background:#e6fffa;
    color:#065f46;
    padding:12px 16px;
    border-radius:8px;
    margin-bottom:20px;
}
</style>
</head>
<body>

<div class="card">

    <?php if (!empty($success)) { ?>
        <div class="alert"><?= $success ?></div>
    <?php } ?>

    <div class="header">
        <img src="<?= $foto ?>">
        <div>
            <h2><?= htmlspecialchars($user['nama']) ?></h2>
            <span class="badge"><?= $user['role'] ?></span>
        </div>
    </div>

    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="<?= $user['nama'] ?>" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= $user['email'] ?>" required>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?= $user['username'] ?>" required>
        </div>

        <div class="form-group">
            <label>Foto Profil</label>
            <input type="file" name="foto">
        </div>

        <div class="actions">
            <button type="submit" name="update" class="btn btn-primary">
                Simpan Perubahan
            </button>
            <a href="../admin/4dashboard_admin.php" class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </form>

</div>

</body>
</html>
