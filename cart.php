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
    SELECT ci.cart_item_id, p.product_id, p.product_name, p.price, ci.quantity, p.image
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.product_id
    WHERE ci.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Initialize total price and store cart items
$total_price = 0;
$cart_items = [];

while ($row = $result->fetch_assoc()) {
    $total = $row['price'] * $row['quantity'];
    $total_price += $total;
    $cart_items[] = [
        'cart_item_id' => $row['cart_item_id'],
        'product_id' => $row['product_id'],
        'product_name' => $row['product_name'],
        'price' => $row['price'],
        'quantity' => $row['quantity'],
        'image' => $row['image'],
        'total' => $total
    ];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700&display=swap" rel="stylesheet">
    <!-- Title & Icon -->
    <link rel="icon" href="assets/image/icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="assets/image/icon.ico" type="image/x-icon">
    <title>Cart - Souvenir Online Shop</title>
    <!-- CSS & JS -->
    <script src="assets/js/detail.js"></script>
    <link rel="stylesheet" href="assets/css/cart.css">
</head>

<body>
    <!-- Navbar -->
    <header id="header" class="header">
        <nav id="navbar" class="navbar">
            <div class="nav-logo">
                <a href="home.php"><img src="assets/image/logoblack.png" alt="logo" class="logo"></a>
            </div>
            <div class="nav-items">
                <ul>
                    <li><a href="products.php" class="nav-font">Souvenir</a></li>
                    <li><a href="regions.php" class="nav-font">Region</a></li>
                    <li><a href="profile.php" class="nav-font">Your Profile</a></li>
                    <li><a href="cart.php"><img src="assets/image/cartblack.png" alt="cart" class="cart"></a></li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="content">
        <p class="title">Shopping Cart</p>
        <?php if (empty($cart_items)) : ?>
            <p class="empty">Your cart is empty</p>
        <?php else : ?>
            <form action="update_cart.php" method="post">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item) : ?>
                            <tr>
                                <td>
                                    <img src="uploads/products/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                                    <br>
                                    <?php echo htmlspecialchars($item['product_name']); ?>
                                </td>
                                <td class="price-center">Rp <?php echo number_format($item['price'], 2, ',', '.'); ?></td>
                                <td>
                                    <input type="number" class="input" name="quantities[<?php echo htmlspecialchars($item['cart_item_id']); ?>]" min="1" value="<?php echo htmlspecialchars($item['quantity']); ?>">
                                </td>
                                <td class="price-center">Rp <?php echo number_format($item['total'], 2, ',', '.'); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="remove_from_cart.php?cart_item_id=<?php echo htmlspecialchars($item['cart_item_id']); ?>" class="remove-btn">Remove</a>
                                        <a href="checkout_single_item.php?cart_item_id=<?php echo htmlspecialchars($item['cart_item_id']); ?>" class="checkout-btn">Checkout</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <h2 class="total-center">Total: Rp <?php echo number_format($total_price, 2, ',', '.'); ?></h2>
                <div class="center-update-cart-btn">
                    <button type="submit" class="update-cart-btn">Update Cart</button>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer id="footer" class="footer">
        <div class="footer-container">
            <div class="footer-column">
                <p class="foot-title">Souvenir Online Shop</p>
                <address>
                    Jababeka Education Park<br>
                    West Java 17530<br>
                    Indonesia<br>
                    <strong>Phone:</strong> <a href="tel:+6281283737833">(+62) 81283737833</a><br>
                    <strong>Email:</strong> <a href="mailto:customersupport@sos.id">customersupport@sos.id</a>
                </address>
            </div>
            <div class="footer-column">
                <p class="foot-title">Useful Links</p>
                <ul class="footer-links">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="products.php">Souvenir</a></li>
                    <li><a href="regions.php">Region</a></li>
                    <li><a href="profile.php">Profile</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <p class="foot-title">Our Social Networks</p>
                <p class="foot-text">Follow our social networks for more news and updates.</p>
                <div class="footer-social">
                    <a href="#"><img src="assets/image/twitter.png" alt="Twitter"></a>
                    <a href="#"><img src="assets/image/facebook.png" alt="Facebook"></a>
                    <a href="#"><img src="assets/image/instagram.png" alt="Instagram"></a>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="footer-logo">
                    <img src="assets/image/logo3.png" alt="Footer Logo">
                </div>
                <p>&copy; 2024 Souvenir Online Shop. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>