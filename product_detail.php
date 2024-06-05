<?php
session_start(); // Start the session
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

include 'config.php';

$product_name = $_GET['product'] ?? '';

$query = "
    SELECT p.product_id, p.product_name, p.price, p.stock, p.description, r.region_name, p.image
    FROM products p
    JOIN regions r ON p.region_id = r.region_id
    WHERE p.product_name = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $product_name);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <!-- title & icon -->
    <link rel="icon" href="assets/image/icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="assets/image/icon.ico" type="image/x-icon">
    <title><?php echo htmlspecialchars($product['product_name']); ?> - Souvenir Online Shop</title>
    <!-- css & js -->
    <script src="assets/js/detail.js"></script>
    <link rel="stylesheet" href="assets/css/detail.css">
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

    <!-- Product Detail -->
    <div class="product-detail-container">
        <img src="uploads/products/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
        <div class="product-info">
            <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
            <p><strong>Region:</strong> <?php echo htmlspecialchars($product['region_name']); ?></p>
            <p><strong>Price:</strong> Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></p>
            <p><strong>Stock:</strong> <?php echo htmlspecialchars($product['stock']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>

            <!-- Quantity Input -->
            <label for="quantity" class="label"><strong>Quantity:</strong></label>
            <input type="number" id="quantity" class="input-quantity" name="quantity" min="1" max="<?php echo htmlspecialchars($product['stock']); ?>" value="1">

            <!-- Button Container -->
            <div class="button-container">
                <!-- Add to Cart Form -->
                <form action="add_to_cart.php" method="post" id="cart-form">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                    <button type="submit" name="add_to_cart" class="add-to-cart-btn">Add to Cart</button>
                </form>

                <!-- Buy Now Form -->
                <form action="buy_now.php" method="post" id="buy-now-form">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                    <button type="submit" name="buy_now" class="buy-now-btn">Buy Now</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to synchronize quantity input between the two forms
        document.addEventListener('DOMContentLoaded', function() {
            var quantityInput = document.getElementById('quantity');
            var addToCartForm = document.getElementById('cart-form');
            var buyNowForm = document.getElementById('buy-now-form');

            addToCartForm.addEventListener('submit', function(event) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'quantity';
                input.value = quantityInput.value;
                addToCartForm.appendChild(input);
            });

            buyNowForm.addEventListener('submit', function(event) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'quantity';
                input.value = quantityInput.value;
                buyNowForm.appendChild(input);
            });
        });
    </script>



    </div>
    <!-- footer -->
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