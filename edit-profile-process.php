<?php
// Memasukkan file konfigurasi dan memulai sesi
require_once 'config.php';

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: " . SITE_URL . "/login.php?status=must_login");
    exit();
}

// Memeriksa apakah form dikirim menggunakan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Mengambil data dari form dengan aman
    $userId = $_SESSION['user_id'];
    $firstName = trim($_POST['editFirstName']);
    $lastName = trim($_POST['editLastName']);
    $email = trim($_POST['editEmail']);
    $skinTone = $_POST['editSkinTone']; // Ini adalah undertone/skin tone
    // Anda bisa menambahkan validasi untuk Preferred Finish juga jika diperlukan
    // $preference = $_POST['editPreference']; 

    // Validasi dasar agar kolom tidak kosong
    if (empty($firstName) || empty($lastName) || empty($email)) {
        header("Location: " . SITE_URL . "/profile.php?status=update_failed");
        exit();
    }

    // -- Perbarui data pengguna di database --
    try {
        // Kolom 'undertone' di database akan diisi dengan nilai dari 'editSkinTone'
        $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, undertone = ? WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$firstName, $lastName, $email, $skinTone, $userId]);

        // Perbarui juga data di session agar perubahan langsung terlihat
        $_SESSION['first_name'] = $firstName;
        $_SESSION['last_name'] = $lastName;
        $_SESSION['email'] = $email;
        $_SESSION['undertone'] = $skinTone;

        // Arahkan kembali ke profil dengan pesan sukses
        header("Location: " . SITE_URL . "/profile.php?status=update_success");
        exit();

    } catch (PDOException $e) {
        // Jika terjadi error pada database
        error_log("Gagal memperbarui profil: " . $e->getMessage());
        header("Location: " . SITE_URL . "/profile.php?status=db_error");
        exit();
    }

} else {
    // Jika halaman ini diakses langsung, arahkan kembali ke profil
    header("Location: " . SITE_URL . "/profile.php");
    exit();
}
?>