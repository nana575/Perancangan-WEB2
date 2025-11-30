<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 600px;
            text-align: center;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            font-size: 100px;
            color: #27ae60;
            margin-bottom: 30px;
            animation: bounce 1s ease-in-out;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 36px;
            font-weight: 700;
        }

        .success-message {
            color: #27ae60;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 30px;
            padding: 15px;
            background: #f8fff9;
            border-radius: 10px;
            border: 2px solid #d5f5e3;
        }

        .user-info {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            margin: 25px 0;
            text-align: left;
            border-left: 5px solid #667eea;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .info-label {
            font-weight: 600;
            color: #2c3e50;
            min-width: 120px;
        }

        .info-value {
            color: #495057;
            text-align: right;
            flex: 1;
        }

        .role-badge {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-mahasiswa {
            background: #e8f6f3;
            color: #1abc9c;
        }

        .role-dosen {
            background: #fef9e7;
            color: #f39c12;
        }

        .role-admin {
            background: #f4ecf7;
            color: #8e44ad;
        }

        .role-kaprodi {
            background: #eaf2f8;
            color: #3498db;
        }

        .redirect-message {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin: 25px 0;
            font-weight: 600;
        }

        .loading-bar {
            height: 8px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            margin-top: 15px;
            overflow: hidden;
        }

        .loading-progress {
            height: 100%;
            width: 0%;
            background: white;
            border-radius: 4px;
            animation: loading 3s linear forwards;
        }

        @keyframes loading {
            from { width: 0%; }
            to { width: 100%; }
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            min-width: 150px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-3px);
        }

        .status-active {
            color: #27ae60;
            font-weight: 600;
        }

        .status-inactive {
            color: #e74c3c;
            font-weight: 600;
        }

        .database-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            font-size: 14px;
            color: #856404;
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
            }

            h1 {
                font-size: 28px;
            }

            .success-icon {
                font-size: 80px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .info-item {
                flex-direction: column;
                text-align: center;
            }

            .info-label, .info-value {
                text-align: center;
                min-width: auto;
            }

            .info-value {
                margin-top: 5px;
            }
        }

        /* Print styles */
        @media print {
            body {
                background: white !important;
            }
            
            .container {
                box-shadow: none !important;
                border: 1px solid #ddd;
            }
            
            .action-buttons {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
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
                $additional_info = "";

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
                    
                    $additional_info = "Mahasiswa berhasil didaftarkan dengan NIM: $nim";

                // === kalau role dosen ===
                } elseif ($role == "dosen") {
                    $id_dosen = $_POST['id_dosen'];
                    $id_prodi = $_POST['id_prodi'];
                    $id_mk = $_POST['id_mk'] ?? null;
                    $nidn = $_POST['nidn'] ?? '';
                    $nama_dosen = $nama;

                    $querydosen = "INSERT INTO tb_dosen (id_dosen, id_user, id_mk, id_prodi, nidn, nama_dosen, email)
                                   VALUES ('$id_dosen', '$id_user', '$id_mk', '$id_prodi', '$nidn', '$nama_dosen', '$email')";
                    $koneksi->query($querydosen);
                    
                    $additional_info = "Dosen berhasil didaftarkan dengan NIDN: $nidn";

                // === kalau role admin ===
                } elseif ($role == "admin") {
                    $id_admin = $_POST['id_admin'];
                    $id_userv = $_POST['id_user'];
                    $id_prodi = $_POST['id_prodi'];
                    $nama = $_POST['nama'];
                    $email = $_POST['email'];

                    $queryadmin = "INSERT INTO tb_admin (id_admin, id_user, id_prodi, nama, email)
                                   VALUES ('$id_admin', '$id_user', '$id_prodi', '$nama', '$email')";
                    $koneksi->query($queryadmin);
                    
                    $additional_info = "Admin berhasil didaftarkan";
                }

                // Tampilkan konfirmasi sukses
                echo '<div class="success-icon">✓</div>';
                echo '<h1>Pendaftaran Berhasil!</h1>';
                echo '<div class="success-message">Data berhasil disimpan ke database</div>';
                
                echo '<div class="user-info">';
                echo '<div class="info-item"><span class="info-label">ID User:</span> <span class="info-value">' . $id_user . '</span></div>';
                echo '<div class="info-item"><span class="info-label">Nama:</span> <span class="info-value">' . $nama . '</span></div>';
                echo '<div class="info-item"><span class="info-label">Email:</span> <span class="info-value">' . $email . '</span></div>';
                echo '<div class="info-item"><span class="info-label">Role:</span> <span class="info-value"><span class="role-badge role-' . $role . '">' . $role . '</span></span></div>';
                echo '<div class="info-item"><span class="info-label">Username:</span> <span class="info-value">' . $username . '</span></div>';
                echo '<div class="info-item"><span class="info-label">Status:</span> <span class="info-value ' . ($status == 1 ? 'status-active' : 'status-inactive') . '">' . ($status == 1 ? 'Aktif' : 'Tidak Aktif') . '</span></div>';
                
                if (!empty($additional_info)) {
                    echo '<div class="info-item"><span class="info-label">Info Tambahan:</span> <span class="info-value">' . $additional_info . '</span></div>';
                }
                echo '</div>';

                echo '<div class="database-info">';
                echo '<strong>✓ Data berhasil disimpan di:</strong><br>';
                echo '- Tabel tb_user<br>';
                if ($role == "mahasiswa") echo '- Tabel tb_mahasiswa';
                elseif ($role == "dosen") echo '- Tabel tb_dosen';
                elseif ($role == "admin") echo '- Tabel tb_admin';
                echo '</div>';

                echo '<div class="redirect-message">';
                echo '<p>Anda akan dialihkan ke halaman mahasiswa dalam 3 detik...</p>';
                echo '<div class="loading-bar"><div class="loading-progress"></div></div>';
                echo '</div>';

                echo '<div class="action-buttons">';
                echo '<a href="3mahasiswa.php" class="btn btn-primary">Lihat Data Mahasiswa</a>';
                echo '<a href="input_foto.php" class="btn btn-secondary">Tambah Data Lain</a>';
                echo '</div>';

                // Redirect otomatis
                echo "<script>
                        setTimeout(function() {
                            window.location.href = '3mahasiswa.php';
                        }, 3000);
                      </script>";

            } else {
                echo '<div style="text-align: center; padding: 40px;">';
                echo '<div style="font-size: 80px; color: #e74c3c; margin-bottom: 20px;">✗</div>';
                echo '<h1 style="color: #e74c3c;">Pendaftaran Gagal</h1>';
                echo '<div style="background: #fde8e8; color: #c53030; padding: 20px; border-radius: 10px; margin: 20px 0;">';
                echo '<strong>Error:</strong> ' . $sql . '<br>' . $koneksi->error;
                echo '</div>';
                echo '<a href="javascript:history.back()" style="display: inline-block; padding: 12px 25px; background: #3498db; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; margin-top: 20px;">Kembali</a>';
                echo '</div>';
            }
        }

        $koneksi->close();
        ?>
    </div>
</body>
</html>