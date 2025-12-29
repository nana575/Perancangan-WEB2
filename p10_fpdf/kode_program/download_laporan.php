<?php
include "0koneksi.php";
require __DIR__ . '/fpdf/fpdf.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/../../vendor/autoload.php';

/* ================= FILTER ================= */
$prodi    = $_GET['prodi'] ?? '';
$angkatan = $_GET['angkatan'] ?? '';
$kelas    = $_GET['kelas'] ?? '';

$where = [];
if ($prodi !== '')    $where[] = "m.id_prodi='$prodi'";
if ($angkatan !== '') $where[] = "m.angkatan='$angkatan'";
if ($kelas !== '')    $where[] = "m.kelas='$kelas'";

$whereSQL = count($where) ? "WHERE " . implode(" AND ", $where) : "";

/* ================= PDF ================= */
if (!is_dir('tmp')) mkdir('tmp');

$nama_file = "Laporan_Mahasiswa.pdf";
$path = "tmp/" . $nama_file;

$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'LAPORAN DATA MAHASISWA',0,1,'C');
$pdf->Ln(3);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,8,'No',1);
$pdf->Cell(40,8,'Prodi',1);
$pdf->Cell(45,8,'Nama',1);
$pdf->Cell(35,8,'NIM',1);
$pdf->Cell(25,8,'Angkatan',1);
$pdf->Cell(20,8,'Kelas',1);
$pdf->Cell(60,8,'Email',1,1);

$pdf->SetFont('Arial','',10);

$no = 1;
$q = mysqli_query($koneksi,"
    SELECT m.*, p.nama_prodi
    FROM tb_mahasiswa m
    JOIN tb_prodi p ON m.id_prodi = p.id_prodi
    $whereSQL
");

while ($r = mysqli_fetch_assoc($q)) {
    $pdf->Cell(10,8,$no,1);
    $pdf->Cell(40,8,$r['nama_prodi'],1);
    $pdf->Cell(45,8,$r['nama'],1);
    $pdf->Cell(35,8,$r['nim'],1);
    $pdf->Cell(25,8,$r['angkatan'],1);
    $pdf->Cell(20,8,$r['kelas'],1);
    $pdf->Cell(60,8,$r['email'],1,1);
    $no++;
}

$pdf->Output('F', $path);

/* ================= EMAIL ================= */
$mail = new PHPMailer(true);
$status = 'error';

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'emailpengirim4@gmail.com';
    $mail->Password   = 'app_password'; // app password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('emailpengirim@gmail.com', 'Sistem Akademik');
    $mail->addAddress('emailpenerima@gmail.com');

    $mail->Subject = 'Laporan Data Mahasiswa (PDF)';
    $mail->Body    = 'Terlampir laporan data mahasiswa dalam format PDF.';
    $mail->addAttachment($path);

    if ($mail->send()) {
        $status = 'success';
    }

} catch (Exception $e) {
    $status = 'error';
}

/* ================= CLEAN & REDIRECT ================= */
unlink($path);
header("Location: 3mahasiswa.php?status=$status");
exit;
