<?php
// Memasukkan file konfigurasi
require_once 'config.php';

// Memeriksa apakah ada query pencarian yang dikirim
if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
    
    // Ambil query pencarian dari URL
    $searchTerm = trim($_GET['q']);

    // Untuk saat ini, kita akan langsung mengalihkan ke halaman hasil.
    // Di masa depan, di sinilah Anda akan menjalankan query ke database
    // untuk mencari produk yang cocok.
    
    // Alihkan ke result.php, sambil membawa query pencarian
    // agar halaman hasil bisa menampilkannya.
    header("Location: " . SITE_URL . "/result.php?search=" . urlencode($searchTerm));
    exit();

} else {
    // Jika tidak ada query pencarian, kembalikan ke halaman find-dupe
    header("Location: " . SITE_URL . "/find-dupe.php?status=empty_search");
    exit();
}
?>