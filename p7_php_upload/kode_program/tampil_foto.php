<?php
include('koneksi.php');

// Ambil data join dari tb_user + tb_files
$perintah = "
    SELECT 
        u.id_user,
        u.nama,
        f.file_name,
        f.file_path
    FROM tb_user u
    LEFT JOIN tb_files f ON u.id_user = f.id_user
    ORDER BY u.id_user ASC
";

$query = mysqli_query($koneksi, $perintah);
?>
<html>
<head>
<title>Halaman Tampil Foto</title>
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
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    h2 {
        color: #2c3e50;
        margin-bottom: 25px;
        text-align: center;
        font-weight: 600;
        font-size: 32px;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
    }
    
    .container {
        width: 100%;
        max-width: 1200px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .header {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        padding: 20px;
        text-align: center;
    }
    
    .header h3 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .add-btn {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }
    
    .add-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }
    
    thead {
        background: linear-gradient(135deg, #2c3e50, #34495e);
        color: white;
    }
    
    th {
        padding: 15px 12px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    tbody tr {
        border-bottom: 1px solid #e9ecef;
        transition: all 0.3s;
    }
    
    tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    tbody tr:nth-child(even) {
        background-color: #f8fafc;
    }
    
    tbody tr:nth-child(even):hover {
        background-color: #f1f3f4;
    }
    
    td {
        padding: 15px 12px;
        color: #495057;
        font-size: 14px;
    }
    
    .user-id {
        font-weight: 600;
        color: #2c3e50;
    }
    
    .user-name {
        font-weight: 500;
        color: #495057;
    }
    
    .photo-cell {
        text-align: center;
    }
    
    .photo-preview {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        border: 2px solid #e9ecef;
        transition: all 0.3s;
    }
    
    .photo-preview:hover {
        transform: scale(1.8);
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        z-index: 10;
        position: relative;
    }
    
    .no-photo {
        color: #6c757d;
        font-style: italic;
        font-size: 12px;
    }
    
    .file-path {
        font-family: 'Courier New', monospace;
        font-size: 12px;
        color: #6c757d;
        word-break: break-all;
        max-width: 200px;
    }
    
    .delete-btn {
        display: inline-block;
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s;
        text-align: center;
        min-width: 70px;
    }
    
    .delete-btn:hover {
        background: linear-gradient(135deg, #c0392b, #a93226);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(231, 76, 60, 0.3);
    }
    
    .no-action {
        color: #6c757d;
        text-align: center;
        font-style: italic;
    }
    
    .stats {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-top: 20px;
        text-align: center;
        width: 100%;
        max-width: 1200px;
    }
    
    .stats h3 {
        color: #2c3e50;
        margin-bottom: 15px;
    }
    
    .stat-cards {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .stat-card {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        padding: 15px 25px;
        border-radius: 8px;
        min-width: 150px;
    }
    
    .stat-number {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 14px;
        opacity: 0.9;
    }
    
    @media (max-width: 768px) {
        body {
            padding: 20px 10px;
        }
        
        h2 {
            font-size: 24px;
        }
        
        .container {
            border-radius: 12px;
        }
        
        th, td {
            padding: 10px 8px;
            font-size: 12px;
        }
        
        .header h3 {
            font-size: 20px;
        }
        
        .stat-cards {
            flex-direction: column;
            align-items: center;
        }
        
        .stat-card {
            width: 100%;
            max-width: 200px;
        }
    }
</style>
</head>
<body>

<h2>DATA FOTO USER</h2>

<div class="container">
    <div class="header">
        <h3>MENAMPILKAN FOTO</h3>
        <a href="input_foto.php" class="add-btn">TAMBAH DATA</a>
    </div>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID User</th>
                    <th>Nama</th>
                    <th>Foto</th>
                    <th>Path Foto</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalUsers = 0;
                $usersWithPhotos = 0;
                
                while ($data = mysqli_fetch_assoc($query)) {
                    $totalUsers++;
                    
                    // Jika belum upload foto
                    if (empty($data['file_path'])) {
                        $path = "";
                    } else {
                        $path = $data['file_path'];
                        $usersWithPhotos++;
                    }
                ?>
                <tr>
                    <td class="user-id"><?= $data['id_user']; ?></td>
                    <td class="user-name"><?= $data['nama']; ?></td>

                    <td class="photo-cell">
                        <?php if (!empty($path)) { ?>
                            <img src="<?= $path; ?>" class="photo-preview" alt="Foto <?= $data['nama']; ?>">
                        <?php } else { ?>
                            <span class="no-photo">Belum Upload</span>
                        <?php } ?>
                    </td>

                    <td class="file-path"><?= $path; ?></td>

                    <td>
                        <?php if (!empty($data['file_name'])) { ?>
                            <a href="delete.php?del=<?= $data['id_user']; ?>" class="delete-btn" 
                               onclick="return confirm('Yakin ingin menghapus foto <?= $data['nama']; ?>?')">
                                DELETE
                            </a>
                        <?php } else { ?>
                            <span class="no-action">-</span>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="stats">
    <h3>Statistik Upload Foto</h3>
    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-number"><?= $totalUsers; ?></div>
            <div class="stat-label">Total User</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $usersWithPhotos; ?></div>
            <div class="stat-label">User dengan Foto</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $totalUsers - $usersWithPhotos; ?></div>
            <div class="stat-label">Belum Upload</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $totalUsers > 0 ? round(($usersWithPhotos / $totalUsers) * 100, 1) : 0; ?>%</div>
            <div class="stat-label">Persentase</div>
        </div>
    </div>
</div>

</body>
</html>