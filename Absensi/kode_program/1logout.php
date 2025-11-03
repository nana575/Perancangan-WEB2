<?php
session_start();
session_unset(); // hapus semua data session
session_destroy(); // hancurkan session

// arahkan balik ke halaman login
header("Location: 1login.html");
exit();
?>
