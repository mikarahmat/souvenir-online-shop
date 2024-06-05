<?php
include 'config.php';

$response = [];

// Get total products in stock
$query = "SELECT product_name, stock FROM products";
$result = $conn->query($query);

$product_stocks = [];
while ($row = $result->fetch_assoc()) {
    $product_stocks[] = $row;
}
$response['product_stocks'] = $product_stocks;

// Get total revenue
$query = "SELECT SUM(amount) as total_revenue FROM payments WHERE status = 'paid'";
$result = $conn->query($query);
$total_revenue = $result->fetch_assoc()['total_revenue'] ?? 0;
$response['total_revenue'] = number_format($total_revenue, 0, ',', '.');

// Get daily revenues
$query = "
    SELECT DATE(payment_date) as day, SUM(amount) as daily_revenue
    FROM payments
    WHERE status = 'paid'
    GROUP BY day
    ORDER BY day ASC
";
$result = $conn->query($query);

$daily_revenues = [];
while ($row = $result->fetch_assoc()) {
    $daily_revenues[] = $row;
}
$response['daily_revenues'] = $daily_revenues;

// Get best-selling products
$query = "
    SELECT p.product_name, SUM(oi.quantity) as total_sold
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    JOIN orders o ON oi.order_id = o.order_id
    WHERE o.status = 'Completed'
    GROUP BY p.product_name
    ORDER BY total_sold DESC
";
$result = $conn->query($query);

$best_selling = [];
while ($row = $result->fetch_assoc()) {
    $best_selling[] = $row;
}
$response['best_selling'] = $best_selling;

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
