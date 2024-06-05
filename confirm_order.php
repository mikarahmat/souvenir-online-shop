<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$order_id = $_GET['order_id'] ?? '';

if ($order_id) {
    // Update order status to "Completed"
    $update_query = "UPDATE orders SET status = 'Completed' WHERE order_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();

    // Retrieve product information from the order items
    $product_query = "
        SELECT product_id, quantity
        FROM order_items
        WHERE order_id = ?
    ";
    $stmt = $conn->prepare($product_query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Update the stock for each product
    while ($row = $result->fetch_assoc()) {
        $update_stock_query = "
            UPDATE products
            SET stock = stock - ?
            WHERE product_id = ?
        ";
        $update_stmt = $conn->prepare($update_stock_query);
        $update_stmt->bind_param("ii", $row['quantity'], $row['product_id']);
        $update_stmt->execute();
        $update_stmt->close();
    }

    $stmt->close();
}

// Redirect back to the profile page
header('Location: order_list.php');
exit;
