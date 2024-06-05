<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Process cart updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $cart_item_id => $quantity) {
        $quantity = (int)$quantity;
        if ($quantity > 0) {
            // Update quantity
            $query = "UPDATE cart_items SET quantity = ? WHERE cart_item_id = ? AND user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iii", $quantity, $cart_item_id, $user_id);
            $stmt->execute();
        }
    }
}

header('Location: cart.php');
exit;
?>
