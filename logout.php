<?php
// Memasukkan file config untuk memulai session dan mengakses variabel
require_once 'config.php';

// Menghancurkan semua data session
session_destroy();

// Mengarahkan pengguna kembali ke halaman utama
header("Location: " . SITE_URL . "/index.php");
exit();
?>