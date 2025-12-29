
<?php
session_start();
include "0koneksi.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

// ============================
// Ambil input
// ============================
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    die("Username dan password wajib diisi");
}

// ============================
// Ambil data user
// ============================
$query = $koneksi->prepare(
    "SELECT * FROM tb_user WHERE username = ?"
);
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    die("Username tidak ditemukan");
}

$user = $result->fetch_assoc();

// ============================
// Cek password
// ============================
if (!password_verify($password, $user['password'])) {
    die("Password salah");
}

// ============================
// Cek verifikasi email
// ============================
if ($user['is_verified'] == 0) {

    $token = bin2hex(random_bytes(32));

    $update = $koneksi->prepare(
        "UPDATE tb_user 
         SET verify_token = ? 
         WHERE id_user = ?"
    );
    $update->bind_param("si", $token, $user['id_user']);
    $update->execute();

    // ============================
    // Kirim email verifikasi
    // ============================
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'cintadewikirana614@gmail.com'; // GANTI
        $mail->Password   = 'qcrntfxgrlfdsjrn';              // GANTI
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ],
        ];

        $mail->setFrom(
            'cintadewikirana614@gmail.com',
            'Sistem Absensi'
        );
        $mail->addAddress(
            $user['email'],
            $user['nama']
        );

        $mail->isHTML(true);

        $link = "http://localhost/perancangan_WEB2/p11_phpmailer/verify_email.php?token=$token";

        $mail->Subject = 'Verifikasi Email';
        $mail->Body    = "
            Halo <b>{$user['nama']}</b><br><br>
            Silakan klik tombol berikut untuk verifikasi email:<br><br>
            <a href='$link' 
               style='padding:10px 15px;
                      background:#4CAF50;
                      color:white;
                      text-decoration:none;
                      border-radius:6px;'>
                VERIFIKASI EMAIL
            </a>
        ";

        $mail->send();
        echo "Email verifikasi sudah dikirim. Silakan cek email.";

    } catch (Exception $e) {
        echo "Gagal kirim email: {$mail->ErrorInfo}";
    }

    exit;
}

// ============================
// Login berhasil
// ============================
$_SESSION['id_user'] = $user['id_user'];
$_SESSION['nama']    = $user['nama'];
$_SESSION['role']    = $user['role'];

header("Location: dashboard_mahasiswa.php");
exit;