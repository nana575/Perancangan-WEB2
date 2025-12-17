<?php
session_start();
session_destroy();
header("Location: 1login.html");
exit;
