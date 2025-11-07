<?php
session_start();
$idsession = session_id();
if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 0;
}

$_SESSION['count']++;
$count = $_SESSION['count'];
?>
<html>
    <head>

    <title>Demo session – destroy </title>
        <style>
        body {
        background-color: #fef7e0;
        font-family: Verdana, sans-serif;
        text-align: center;
        padding-top: 70px;
        color: #444;
        }
        h1 {
        color: #f57c00;
        margin-bottom: 25px;
        }
        a {
        color: #1565c0;
        text-decoration: none;
        font-weight: bold;
        }
        a:hover {
        text-decoration: underline;
        }
        </style>

    </head>
    <body>
        <h1> Demo Session – reset nilai </h1>
        <?php
        echo "<br> ID Session : ".$idsession;
        echo "<br> Anda mengakses sever ini sebanyak : ".$count;
        ?>
    </body>
</html>