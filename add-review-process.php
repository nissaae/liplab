<?php
// Memasukkan file konfigurasi untuk database dan sesi
require_once 'config.php';

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika tidak, kirim respons error dalam bentuk JSON
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Anda harus login untuk memberikan review.']);
    exit();
}

// Memeriksa apakah data dikirim dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Mengambil data dari form
    $userId = $_SESSION['user_id'];
    $productId = $_POST['product_id'];
    $rating = $_POST['rating'];
    $reviewText = trim($_POST['review_text']);

    // Validasi dasar
    if (empty($productId) || empty($rating) || $rating < 1 || $rating > 5) {
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=review_failed");
        exit();
    }

    // -- Masukkan review baru ke database --
    try {
        // Cek dulu apakah pengguna sudah pernah mereview produk ini
        $checkSql = "SELECT review_id FROM reviews WHERE user_id = ? AND product_id = ?";
        $stmtCheck = $pdo->prepare($checkSql);
        $stmtCheck->execute([$userId, $productId]);
        
        if ($stmtCheck->fetch()) {
             // Jika sudah ada, mungkin lebih baik mengarahkannya untuk mengedit (fitur masa depan)
             header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=already_reviewed");
             exit();
        }

        // Jika belum, masukkan review baru
        $sql = "INSERT INTO reviews (product_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$productId, $userId, $rating, $reviewText]);

        // Arahkan kembali ke halaman sebelumnya dengan pesan sukses
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=review_success");
        exit();

    } catch (PDOException $e) {
        error_log("Gagal menambahkan review: " . $e->getMessage());
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=db_error");
        exit();
    }
} else {
    // Jika halaman diakses langsung, arahkan ke halaman utama
    header("Location: " . SITE_URL . "/index.php");
    exit();
}
?>