<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_item_id = $_GET['cart_item_id'] ?? '';

if (!empty($cart_item_id)) {
    $query = "DELETE FROM cart_items WHERE cart_item_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $cart_item_id, $user_id);
    $stmt->execute();
    $stmt->close();
}

header('Location: cart.php');
exit;
?>