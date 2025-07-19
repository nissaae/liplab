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
    echo json_encode(['success' => false, 'error' => 'Anda harus login untuk melihat wishlist.']);
    exit();
}

$userId = $_SESSION['user_id'];

try {
    // Query untuk mengambil wishlist items
    $wishlistSql = "SELECT 
                        p.product_id,
                        p.product_name,
                        p.price,
                        p.image_link,
                        p.product_type,
                        p.brand_id
                    FROM user_favorites uf
                    JOIN products p ON uf.product_id = p.product_id
                    WHERE uf.user_id = ?
                    ORDER BY uf.created_at DESC";
    
    $stmt = $pdo->prepare($wishlistSql);
    $stmt->execute([$userId]);
    $wishlistItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'data' => $wishlistItems]);

} catch (PDOException $e) {
    error_log("Wishlist fetch error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Terjadi kesalahan pada server.']);
}
?>