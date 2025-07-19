<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');

if (!isset($pdo)) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed.']);
    exit();
}

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Anda harus login untuk menambahkan ke wishlist.']);
    exit();
}

// Memeriksa apakah data dikirim sebagai JSON
$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['product_id'])) {
    echo json_encode(['success' => false, 'error' => 'Product ID tidak valid.']);
    exit();
}

$userId = $_SESSION['user_id'];
$productId = $data['product_id'];

try {
    // Cek apakah produk sudah ada di wishlist
    $checkSql = "SELECT favorite_id FROM user_favorites WHERE user_id = ? AND product_id = ?";
    $stmt = $pdo->prepare($checkSql);
    $stmt->execute([$userId, $productId]);
    $existing = $stmt->fetch();

    if ($existing) {
        // Jika sudah ada, hapus dari wishlist
        $deleteSql = "DELETE FROM user_favorites WHERE favorite_id = ?";
        $stmt = $pdo->prepare($deleteSql);
        $stmt->execute([$existing['favorite_id']]);
        echo json_encode(['success' => true, 'action' => 'removed']);
    } else {
        // Jika belum ada, tambahkan ke wishlist
        $insertSql = "INSERT INTO user_favorites (user_id, product_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($insertSql);
        $stmt->execute([$userId, $productId]);
        echo json_encode(['success' => true, 'action' => 'added']);
    }

} catch (PDOException $e) {
    error_log("Wishlist Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Terjadi kesalahan pada server.']);
}
?>