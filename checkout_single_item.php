<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_item_id = $_GET['cart_item_id'] ?? 0;

if (!$cart_item_id) {
    header("Location: cart.php");
    exit;
}

// Retrieve the cart item details
$query = "
    SELECT ci.cart_item_id, p.product_id, p.product_name, p.price, ci.quantity
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.product_id
    WHERE ci.cart_item_id = ? AND ci.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $cart_item_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_item = $result->fetch_assoc();

if (!$cart_item) {
    header("Location: cart.php");
    exit;
}

$stmt->close();

// Calculate the total price
$total_price = $cart_item['price'] * $cart_item['quantity'];

// Create a new order
$query = "INSERT INTO orders (user_id, order_date, total_amount, status) VALUES (?, NOW(), ?, 'Pending')";
$stmt = $conn->prepare($query);
$stmt->bind_param("id", $user_id, $total_price);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

// Insert the item into the order_items table
$query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiid", $order_id, $cart_item['product_id'], $cart_item['quantity'], $cart_item['price']);
$stmt->execute();
$stmt->close();

// Remove the item from the cart
$query = "DELETE FROM cart_items WHERE cart_item_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $cart_item_id, $user_id);
$stmt->execute();
$stmt->close();

// Redirect to the order list with a success message
$_SESSION['message'] = 'Your item has been successfully added to the order list. You can review it in your profile.';
header("Location: cart.php");
exit;
