<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Retrieve cart items for the logged-in user
$query = "
    SELECT ci.cart_item_id, p.product_id, p.product_name, p.price, ci.quantity
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.product_id
    WHERE ci.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$order_items = [];
while ($row = $result->fetch_assoc()) {
    $order_items[] = [
        'product_id' => $row['product_id'],
        'quantity' => $row['quantity'],
        'price' => $row['price'],
        'product_name' => $row['product_name']
    ];
}
$stmt->close();

// Create individual orders for each item
$query_order = "INSERT INTO orders (user_id, order_date, total_amount, status) VALUES (?, NOW(), ?, 'Pending')";
$query_order_items = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
$stmt_order = $conn->prepare($query_order);
$stmt_order_items = $conn->prepare($query_order_items);

foreach ($order_items as $item) {
    $total_price = $item['price'] * $item['quantity'];
    $stmt_order->bind_param("id", $user_id, $total_price);
    $stmt_order->execute();
    $order_id = $stmt_order->insert_id;

    $stmt_order_items->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
    $stmt_order_items->execute();
}

// Clear user's cart
$query = "DELETE FROM cart_items WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->close();

$stmt_order->close();
$stmt_order_items->close();
$conn->close();

// Redirect to profile page with notification
$_SESSION['order_notification'] = "Your items have been added to the order list.";
header("Location: order_list.php");
exit;
