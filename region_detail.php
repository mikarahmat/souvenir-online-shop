<?php
session_start(); // Start the session
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

include 'config.php'; // Include your database connection file

// Check if region is set in the query parameter
if (isset($_GET['region'])) {
    $region_id = mysqli_real_escape_string($conn, $_GET['region']);

    // Fetch region details including the image
    $region_query = "SELECT region_name, description, image FROM regions WHERE region_id = '$region_id'";
    $region_result = mysqli_query($conn, $region_query);
    $region = mysqli_fetch_assoc($region_result);

    // Fetch products for the specified region
    $query = "SELECT product_name, description, price, image, stock FROM products WHERE region_id = '$region_id'";
    $result = mysqli_query($conn, $query);
} else {
    // Redirect if region is not specified
    header('Location: regions.php');
    exit();
}
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
    <title>Products - <?php echo htmlspecialchars($region['region_name']); ?> - Souvenir Online Shop</title>
    <!-- css & js -->
    <script src="assets/js/region.js"></script>
    <link rel="stylesheet" href="assets/css/detail2.css">
</head>

<body>
    <!-- navbar -->
    <header id="header" class="header">
        <nav id="navbar" class="navbar">
            <div class="nav-logo">
                <a href="home.php"><img src="assets/image/logo.png" alt="logo" class="logo"></a>
            </div>
            <div class="nav-items">
                <ul>
                    <li><a href="products.php" class="nav-font">Souvenir</a></li>
                    <li><a href="regions.php" class="nav-font">Region</a></li>
                    <li><a href="profile.php" class="nav-font">Your Profile</a></li>
                    <li><a href="cart.php"><img src="assets/image/cartwhite.png" alt="cart" class="cart"></a></li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Video Section -->
    <section id="video_sec" class="video_sec">
        <img src="uploads/regions/<?php echo htmlspecialchars($region['image']); ?>" alt="<?php echo htmlspecialchars($region['region_name']); ?>">
        <div class="overlay">
            <p class="tag"><?php echo htmlspecialchars($region['region_name']); ?></p>
            <p class="tag-2"><?php echo htmlspecialchars($region['description']); ?></p>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="products-grid-section">
        <p class="page-title">Products from <?php echo htmlspecialchars($region['region_name']); ?></p>
        <div class="products-grid">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                $is_sold_out = ($row['stock'] <= 0);
                echo '
                <div class="product-card" onclick="window.location.href=\'product_detail.php?product=' . urlencode($row['product_name']) . '\'">
                    <img src="uploads/products/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['product_name']) . '">
                    <p class="product-name">' . htmlspecialchars($row['product_name']) . '</p>
                    <p class="price">Rp ' . number_format($row['price'], 2, ',', '.') . '</p>
                    ' . ($is_sold_out ? '<span class="sold-out-label">Sold Out</span>' : '') . '
                    <a href="product_detail.php?product=' . urlencode($row['product_name']) . '" class="details-link">View Details</a>
                </div>
            ';
            }
            ?>
        </div>
    </section>

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
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Souvenir</a></li>
                    <li><a href="#">Region</a></li>
                    <li><a href="#">Profile</a></li>
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