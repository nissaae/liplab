<?php
require_once 'config.php'; // Make sure this path is correct

// 1. Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'User not logged in.']);
    exit;
}

// 2. Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
    exit;
}

// 3. Decode the incoming JSON data from the request body
$data = json_decode(file_get_contents('php://input'), true);

// 4. Check if the product_id exists in the decoded data
if (isset($data['product_id']) && !empty($data['product_id'])) {
    $productId = $data['product_id'];
    $userId = $_SESSION['user_id'];

    try {
        // 5. Prepare and execute the delete statement on the correct table
        $stmt = $pdo->prepare("DELETE FROM user_favorites WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute([
            ':user_id' => $userId,
            ':product_id' => $productId
        ]);

        // 6. Check if a row was actually deleted and send a success response
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Product removed successfully.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Item was not found in your favorites.']);
        }

    } catch (PDOException $e) {
        // Handle potential database errors during deletion
        error_log("Favorites removal error: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => 'A database error occurred.']);
    }
} else {
    // 7. This is the error you are seeing. It runs if product_id is not found.
    echo json_encode(['success' => false, 'error' => 'Product ID not provided.']);
    exit;
}
?>