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
    // Update order status to "Cancelled"
    $update_query = "UPDATE orders SET status = 'Cancelled' WHERE order_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to the profile page
header('Location: order_list.php');
exit;
