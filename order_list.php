<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Retrieve individual pending orders
$pending_query = "
    SELECT o.order_id, o.order_date, o.total_amount, o.status, p.product_name, oi.quantity, oi.price
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN products p ON oi.product_id = p.product_id
    WHERE o.user_id = ? AND o.status = 'Pending'
";
$pending_stmt = $conn->prepare($pending_query);
$pending_stmt->bind_param("i", $user_id);
$pending_stmt->execute();
$pending_result = $pending_stmt->get_result();
$pending_orders = $pending_result->fetch_all(MYSQLI_ASSOC);
$pending_stmt->close();

// Retrieve individual completed orders
$completed_query = "
    SELECT o.order_id, o.order_date, o.total_amount, o.status, p.product_name, oi.quantity, oi.price
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN products p ON oi.product_id = p.product_id
    WHERE o.user_id = ? AND o.status = 'Completed'
";
$completed_stmt = $conn->prepare($completed_query);
$completed_stmt->bind_param("i", $user_id);
$completed_stmt->execute();
$completed_result = $completed_stmt->get_result();
$completed_orders = $completed_result->fetch_all(MYSQLI_ASSOC);
$completed_stmt->close();

// Retrieve individual canceled orders
$canceled_query = "
    SELECT o.order_id, o.order_date, o.total_amount, o.status, p.product_name, oi.quantity, oi.price
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN products p ON oi.product_id = p.product_id
    WHERE o.user_id = ? AND o.status = 'Cancelled'
";
$canceled_stmt = $conn->prepare($canceled_query);
$canceled_stmt->bind_param("i", $user_id);
$canceled_stmt->execute();
$canceled_result = $canceled_stmt->get_result();
$canceled_orders = $canceled_result->fetch_all(MYSQLI_ASSOC);
$canceled_stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order List - Souvenir Online Shop</title>
    <link rel="stylesheet" href="assets/css/order_list.css">
</head>

<body>
    <h1>Order List</h1>
    <!-- Pending Orders Section -->
    <section class="order-section">
        <h2>Pending Orders</h2>
        <?php if (empty($pending_orders)) : ?>
            <p>You have no pending orders.</p>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pending_orders as $order) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                            <td>Rp <?php echo number_format($order['quantity'] * $order['price'], 0, ',', '.'); ?></td>
                            <td>
                                <a href="payment.php?order_id=<?php echo $order['order_id']; ?>" class="confirm-btn">Payment</a>
                                <a href="cancel_order.php?order_id=<?php echo $order['order_id']; ?>" class="cancel-btn">Cancel</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

    <!-- Completed Orders Section -->
    <section class="order-section">
        <h2>Completed Orders</h2>
        <?php if (empty($completed_orders)) : ?>
            <p>You have no completed orders.</p>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($completed_orders as $order) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                            <td>Rp <?php echo number_format($order['quantity'] * $order['price'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

    <!-- Canceled Orders Section -->
    <section class="order-section">
        <h2>Canceled Orders</h2>
        <?php if (empty($canceled_orders)) : ?>
            <p>You have no canceled orders.</p>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($canceled_orders as $order) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                            <td>Rp <?php echo number_format($order['quantity'] * $order['price'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</body>

</html>