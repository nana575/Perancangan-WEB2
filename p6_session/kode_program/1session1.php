<?php
Session_start();
if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 0; 
}

$_SESSION['count']++;
?>

<html>
    <head>

        <title>Demo session 1 </title>
        <style>
        body {
        background-color: #e8f0fe;
        font-family: Arial, sans-serif;
        text-align: center;
        padding-top: 80px;
        color: #333;
        }
        h1 {
        color: #1a73e8;
        margin-bottom: 20px;
        }
        p, span {
        font-size: 18px;
        }
        </style>

    </head>
<body>
    <h1> Demo Session 1 </h1> 
    <?php echo "Anda telah mengakses halaman ini sebanyak : " .$_SESSION['count']. "kali";
    ?>
</body>
</html>