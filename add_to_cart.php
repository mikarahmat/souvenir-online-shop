<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'] ?? '';
$quantity = (int)($_POST['quantity'] ?? 1);

if (!empty($product_id) && $quantity > 0) {
    // Check if the product is already in the cart
    $query = "
        SELECT cart_item_id, quantity
        FROM cart_items
        WHERE user_id = ? AND product_id = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the quantity if the item already exists
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;
        $update_query = "
            UPDATE cart_items
            SET quantity = ?
            WHERE cart_item_id = ?
        ";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ii", $new_quantity, $row['cart_item_id']);
        $update_stmt->execute();
    } else {
        // Insert the item into the cart if it doesn't exist
        $insert_query = "
            INSERT INTO cart_items (user_id, product_id, quantity)
            VALUES (?, ?, ?)
        ";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $insert_stmt->execute();
    }

    // Free resources
    $stmt->close();
}

// Redirect back to the previous page
$redirect_url = $_SERVER['HTTP_REFERER'] ?? 'products.php';
header("Location: $redirect_url");
exit;
