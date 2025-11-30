<!DOCTYPE html>
<html>
<head>
    <title>Upload Berhasil</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        
        .container {
            background-color: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .success-icon {
            font-size: 80px;
            color: #2ecc71;
            margin-bottom: 20px;
            animation: bounce 1s ease-in-out;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-15px);}
            60% {transform: translateY(-7px);}
        }
        
        h1 {
            color: #2c3e50;
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 32px;
        }
        
        .info-box {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
            border-left: 4px solid #3498db;
        }
        
        .info-item {
            margin-bottom: 10px;
            display: flex;
        }
        
        .info-label {
            font-weight: 600;
            color: #34495e;
            min-width: 100px;
        }
        
        .info-value {
            color: #2c3e50;
        }
        
        .image-preview {
            margin: 25px 0;
            padding: 15px;
            background-color: #f8fafc;
            border-radius: 10px;
            display: inline-block;
        }
        
        .image-preview img {
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: 3px solid #e9ecef;
        }
        
        .countdown {
            background: linear-gradient(to right, #3498db, #2980b9);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }
        
        .redirect-link {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background-color: #2ecc71;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .redirect-link:hover {
            background-color: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        
        .loading-bar {
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            margin-top: 15px;
            overflow: hidden;
        }
        
        .loading-progress {
            height: 100%;
            width: 0%;
            background: linear-gradient(to right, #2ecc71, #3498db);
            border-radius: 3px;
            animation: loading 3s linear forwards;
        }
        
        @keyframes loading {
            from { width: 0%; }
            to { width: 100%; }
        }
        
        @media (max-width: 600px) {
            .container {
                padding: 25px;
            }
            
            h1 {
                font-size: 26px;
            }
            
            .info-item {
                flex-direction: column;
            }
            
            .info-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>

<?php
include('koneksi.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_FILES['foto'])) {
    die("Input file tidak ditemukan. Pastikan name='foto' di form.");
}

$id_user = $_POST['id_user'];
$nama = $_POST['nama'];

if (empty($id_user)) {
    die("ID User masih kosong.");
}

// Cek apakah id_user ada
$cek = mysqli_query($koneksi, "SELECT id_user FROM tb_user WHERE id_user='$id_user'");
if (mysqli_num_rows($cek) == 0) {
    die("ID User <b>$id_user</b> tidak ditemukan di tabel tb_user!");
}

if (empty($nama)) {
    die("Nama masih kosong.");
}

$file = $_FILES['foto'];
$nama_asli = $file['name'];
$tmp = $file['tmp_name'];
$ukuran = $file['size'];
$error = $file['error'];

if ($error !== 0) {
    die("Error upload: kode $error");
}

$folder = "gambar/";

if (!is_dir($folder)) {
    if (!mkdir($folder, 0777, true)) {
        die("Gagal membuat folder 'gambar/'. Cek permission!");
    }
}

$ext = strtolower(pathinfo($nama_asli, PATHINFO_EXTENSION));
$valid = ['jpg','jpeg','png','gif'];

if (!in_array($ext, $valid)) {
    die("Format file tidak valid: $ext");
}

if ($ukuran > 10000000000) {
    die("Ukuran file terlalu besar!");
}

$nama_baru = uniqid() . "." . $ext;

if (!move_uploaded_file($tmp, $folder . $nama_baru)) {
    die("Gagal upload file. Cek permission folder 'gambar/'.");
}

// DB DATA
$id_files = substr(uniqid(), -10);
$file_name = $nama_baru;
$file_path = $folder . $nama_baru;
$file_type = $ext;
$file_size = $ukuran;
$uploaded_at = date("Y-m-d H:i:s");

$sql = "INSERT INTO tb_files 
        (id_files, id_user, file_name, file_path, file_type, file_size, uploaded_at)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $sql);

mysqli_stmt_bind_param($stmt, "sssssis",
    $id_files,
    $id_user,
    $file_name,
    $file_path,
    $file_type,
    $file_size,
    $uploaded_at
);

if ($stmt->execute()) {
    echo '<div class="container">';
    echo '<div class="success-icon">✓</div>';
    echo '<h1>Upload Berhasil!</h1>';
    
    echo '<div class="info-box">';
    echo '<div class="info-item"><span class="info-label">Nama:</span> <span class="info-value">' . $nama . '</span></div>';
    echo '<div class="info-item"><span class="info-label">ID User:</span> <span class="info-value">' . $id_user . '</span></div>';
    echo '<div class="info-item"><span class="info-label">File:</span> <span class="info-value">' . $nama_asli . '</span></div>';
    echo '<div class="info-item"><span class="info-label">Ukuran:</span> <span class="info-value">' . round($ukuran / 1024, 2) . ' KB</span></div>';
    echo '</div>';
    
    echo '<div class="image-preview">';
    echo '<img src="' . $folder . $nama_baru . '" height="200">';
    echo '</div>';
    
    echo '<div class="countdown">';
    echo '<p>Anda akan dialihkan ke halaman data dalam 3 detik...</p>';
    echo '<div class="loading-bar"><div class="loading-progress"></div></div>';
    echo '</div>';
    
    echo '<a href="tampil_foto.php" class="redirect-link">Lihat Data Sekarang</a>';
    echo '</div>';

    // Redirect setelah 3 detik
    echo "<script>
            setTimeout(function() {
                window.location.href = 'tampil_foto.php';
            }, 3000);
          </script>";

} else {
    echo '<div class="container" style="text-align:center;">';
    echo '<div style="font-size:60px;color:#e74c3c;margin-bottom:20px;">✗</div>';
    echo '<h1 style="color:#e74c3c;">Gagal Upload</h1>';
    echo '<p>Gagal menyimpan data ke database: ' . mysqli_error($koneksi) . '</p>';
    echo '<a href="javascript:history.back()" style="display:inline-block;margin-top:20px;padding:12px 25px;background-color:#3498db;color:white;text-decoration:none;border-radius:6px;font-weight:600;">Kembali</a>';
    echo '</div>';
}
?>

</body>
</html>