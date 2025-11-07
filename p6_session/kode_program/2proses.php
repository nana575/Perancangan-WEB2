<?php
session_start();
$nama = $_POST["nama"];
$umur = $_POST["umur"];
$email = $_POST["email"];
$waktu = date("Y-m-d H:i:s");
$_SESSION["nama"] = $nama;
$_SESSION["umur"] = $umur;
$_SESSION["email"] = $email;
?>
<HTML>
    <head>
        <style>
            body {
            background-color: #e1f5fe;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            color: #01579b;
            padding-top: 70px;
            }
            h1 {
            color: #0277bd;
            }
            h2 {
            color: #0288d1;
            }
            a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: white;
            background-color: #03a9f4;
            padding: 10px 20px;
            border-radius: 6px;
            transition: background 0.3s;
            }
            a:hover {
            background-color: #0288d1;
            }
        </style>

    </head>
    <BODY>
        <?php
            echo "<H1> Hallo ".$_SESSION["nama"]. "</H1>";
        ?>
        <H2> Selamat Datang Di Situs Kami </H2>
        <?php
            echo "Umur Anda saat ini adalah ".$_SESSION["umur"]."tahun <BR>";
            echo "Alamat email Anda adalah ".$_SESSION["email"]."<BR>";
        ?>
            <BR>
            <A href="2next.php"> Klik di sini </A> untuk menuju ke halaman berikut.
    </BODY>
</HTML>