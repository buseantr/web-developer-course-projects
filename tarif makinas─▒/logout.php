<?php
session_start();
session_destroy(); // Tüm oturumları sonlandır
header("Location: login.php");
exit;
?>
