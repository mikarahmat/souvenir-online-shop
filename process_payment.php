<!-- process_payment.php -->
<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$order_id = $_POST['order_id'] ?? 0;
$payment_method_id = $_POST['payment_method_id'] ?? 0;

if ($order_id == 0 || $payment_method_id == 0) {
    header('Location: profile.php');
    exit;
}

// Insert payment information
$query = "
    INSERT INTO payments (order_id, amount, payment_date, status, payment_method_id)
    SELECT o.order_id, o.total_amount, NOW(), 'paid', ?
    FROM orders o
    WHERE o.order_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $payment_method_id, $order_id);
$stmt->execute();
$stmt->close();

// Update order status
$query = "UPDATE orders SET status = 'Completed' WHERE order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$stmt->close();

// Reduce stock
$query = "
    UPDATE products p
    JOIN order_items oi ON p.product_id = oi.product_id
    SET p.stock = p.stock - oi.quantity
    WHERE oi.order_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$stmt->close();

header('Location: order_list.php?success=payment_confirmed');
exit;
