<!-- payment.php -->
<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$order_id = $_GET['order_id'] ?? 0;
if ($order_id == 0) {
    header('Location: profile.php');
    exit;
}

// Fetch payment methods
$query = "SELECT method_id, method_name FROM payment_methods";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$payment_methods = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Method</title>
    <link rel="stylesheet" href="assets/css/payment.css">
</head>
<body>
    <h1>Select Payment Method</h1>
    <form action="process_payment.php" method="post">
        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
        <?php foreach ($payment_methods as $method) : ?>
            <input type="radio" name="payment_method_id" value="<?php echo htmlspecialchars($method['method_id']); ?>" required>
            <?php echo htmlspecialchars($method['method_name']); ?><br>
        <?php endforeach; ?>
        <button type="submit" class="confirm-btn">Confirm Payment</button>
    </form>
</body>
</html>
