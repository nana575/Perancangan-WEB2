
<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
    
</head>
<body>

    <div class="container">
        <h2>Halo, <?php echo $_SESSION['username']; ?></h2>
        <p><b>Selamat Datang di Website Sistem Absensi Berbasis QR</b></p>
        <p>Kamu login sebagai <b><?php echo ucfirst($_SESSION['role']); ?></b></p>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

</body>
</html>
