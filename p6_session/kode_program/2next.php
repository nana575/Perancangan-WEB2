<?php
session_start();
?>
<HTML>
    <head>
        <style>
            body {
            background-color: #fce4ec;
            font-family: 'Helvetica Neue', sans-serif;
            text-align: center;
            padding-top: 70px;
            color: #ad1457;
            }
            h2 {
            color: #c2185b;
            margin-bottom: 15px;
            }
            a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: white;
            background-color: #e91e63;
            padding: 10px 20px;
            border-radius: 6px;
            transition: 0.3s;
            }
            a:hover {
            background-color: #c2185b;
            }
        </style>

    </head>
<BODY>
    <H2> Anda memasuki halaman kedua </H2>
        <?php
        echo "Nama anda ".$_SESSION["nama"]."<br>";
        echo "Umur Anda saat ini adalah ".$_SESSION["umur"]." tahun<BR>";
        echo "Alamat email Anda adalah ".$_SESSION["email"]."<BR>";
        ?>
    <A HREF="2data.php"> Klik disini </A> untuk menuju ke halaman awal.
    <?php
        //untuk menghapus variabel session di server
        session_destroy();
    ?>
</BODY>
</HTML>