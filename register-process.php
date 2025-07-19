<?php
// Memasukkan file konfigurasi untuk mendapatkan koneksi database ($pdo)
require_once 'config.php';

// Memeriksa apakah data dikirim menggunakan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['registerEmail']);
    $password = $_POST['registerPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        die("Error: Semua kolom wajib diisi.");
    }
    if ($password !== $confirmPassword) {
        die("Error: Konfirmasi password tidak cocok.");
    }

    $sqlCheck = "SELECT user_id FROM users WHERE email = ?";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([$email]);
    if ($stmtCheck->fetch()) {
        die("Error: Email ini sudah terdaftar.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $username = $firstName . substr($lastName, 0, 1);

    try {
        // PERUBAHAN DI SINI: Query INSERT diperbarui untuk menyertakan first_name dan last_name
        $sql = "INSERT INTO users (first_name, last_name, email, username, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$firstName, $lastName, $email, $username, $hashedPassword]);

        header("Location: login.php?status=reg_success");
        exit();

    } catch (PDOException $e) {
        die("Gagal mendaftarkan pengguna: " . $e->getMessage());
    }
} else {
    header("Location: register.php");
    exit();
}
?>