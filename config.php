<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ========== PENGATURAN KONEKSI DATABASE ==========
define('DB_HOST', 'localhost');
define('DB_USER', 'projec15_root');
define('DB_PASS', '@kaesquare123');
define('DB_NAME', 'projec15_liplab');

// ========== PENGATURAN SITUS ==========
define('SITE_NAME', 'LipLab');
define('SITE_URL', 'http:/liplab.project2ks2.my.id/liplab2'); 

// ========== KONEKSI DATABASE (PDO) ==========
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("KONEKSI GAGAL: " . $e->getMessage());
}

?>
