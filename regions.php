<?php
session_start(); // Start the session
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

include 'config.php'; // Ensure you have your database configuration here

$query = "SELECT region_id, region_name, description, image FROM regions";
$result = mysqli_query($conn, $query);
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
    <title>Regions - Souvenir Online Shop</title>
    <!-- css & js -->
    <script src="assets/js/region.js"></script>
    <link rel="stylesheet" href="assets/css/regions.css">
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
    <!-- video section -->
    <section id="video_sec" class="video_sec">
        <img src="assets/image/backdrop2.png" alt="backdrop">
        <div class="overlay">
            <p class="tag">List of Regions</p>
        </div>
    </section>
    <!-- Region List -->
    <section class="regions-list">
        <p class="page-title">See Our Regions</p>
        <div class="regions-grid">
            <?php while ($row = mysqli_fetch_assoc($result)) {
                echo '
            <div class="region-card" onclick="window.location.href=\'region_detail.php?region=' . urlencode($row['region_id']) . '\'">
                <img src="uploads/regions/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['region_name']) . '">
                <div class="overlay">
                    <p class="name">' . htmlspecialchars($row['region_name']) . '</p>
                    <p class="region-description">' . htmlspecialchars($row['description']) . '</p>
                </div>
            </div>';
            }
            ?>
        </div>
    </section>
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