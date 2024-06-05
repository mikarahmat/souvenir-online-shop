<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'] ?? 0;
$quantity = $_POST['quantity'] ?? 1;

if (!$product_id) {
    header("Location: products.php");
    exit;
}

// Retrieve product details
$query = "
    SELECT product_id, product_name, price, stock
    FROM products
    WHERE product_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product || $quantity > $product['stock']) {
    header("Location: products.php");
    exit;
}

$total_price = $product['price'] * $quantity;

// Create a new order
$query = "INSERT INTO orders (user_id, order_date, total_amount, status) VALUES (?, NOW(), ?, 'Pending')";
$stmt = $conn->prepare($query);
$stmt->bind_param("id", $user_id, $total_price);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

// Insert item into order_items table
$query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiid", $order_id, $product['product_id'], $quantity, $product['price']);
$stmt->execute();
$stmt->close();

// Update product stock
$query = "UPDATE products SET stock = stock - ? WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $quantity, $product['product_id']);
$stmt->execute();
$stmt->close();

// Redirect to the order list page with a success message
$_SESSION['message'] = 'Your item has been successfully added to the order list. You can review it in your profile.';
header("Location: order_list.php");
exit;
