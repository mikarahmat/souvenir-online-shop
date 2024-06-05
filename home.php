<?php
// Start a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Personalized message
$full_name = $_SESSION['full_name'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];
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
    <title>Souvenir Online Shop</title>
    <!-- css & js -->
    <script src="assets/js/script.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
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
        <video autoplay muted loop>
            <source src="assets/video/video.mp4" type="video/mp4">
        </video>
        <div class="overlay">
            <p class="tag">Bringing Travels Home</p>
            <p class="tag">Explore Our Online Souvenir Showcase</p>
            <div class="2-button">
                <button class="tag-button" id="tag-button-1" onclick="window.location.href='products.php'">Go Shop</button>
                <button class="tag-button" id="tag-button-2" onclick="window.location.href='regions.php'">Regions</button>
            </div>
        </div>
    </section>
    <!-- below video -->
    <section class="below-vid" id="below-vid">
        <div id="below-sec" class="below-sec">
            <p class="tag-2">Welcome to our souvenir online shop!</p>
            <p class="tag-3">The finest local delicacies and unique gifts are here at our Souvenir Online Shop. From distinctive and delicious treats to regional crafts and</p>
            <p class="tag-4">treasures, we bring the spirit of travel into your home. Discover, explore, and share the joy with those you care about.</p>
        </div>
    </section>
    <!-- image slider -->
    <section id="our-products" class="our-products">
        <div class="double-slider-wrapper">
            <!-- First Slider: Products -->
            <div class="slider-container-1" onclick="window.location.href='products.php'">
                <p class="slider-title">See Our Products</p>
                <div class="slider-wrapper">
                    <div class="slider">
                        <img id="image-1" src="assets/image/piesusu.jpg" alt="Pie Susu">
                        <img id="image-2" src="assets/image/bakpia.jpg" alt="Bakpia">
                        <img id="image-3" src="assets/image/pempek.jpg" alt="Pempek">
                        <img id="image-4" src="assets/image/bikaambon.jpg" alt="Bika Ambon">
                    </div>
                    <div class="slider-nav">
                        <a href="#image-1"></a>
                        <a href="#image-2"></a>
                        <a href="#image-3"></a>
                        <a href="#image-4"></a>
                    </div>
                </div>
                <p class="text-slider">Discover Indonesia's finest local delicacies, carefully crafted and sourced to bring joy to your taste buds.</p>
                <button id="shop-button" class="button-slider" onclick="window.location.href='products.php'">Products</button>
            </div>
            <!-- Second Slider: Regions -->
            <div class="slider-container-2" onclick="window.location.href='regions.php'">
                <p class="slider-title">See Our Regions</p>
                <div class="slider-wrapper">
                    <div class="slider">
                        <img id="image-5" src="assets/image/bali.jpg" alt="Bali">
                        <img id="image-6" src="assets/image/jogja.jpg" alt="Jogja">
                        <img id="image-7" src="assets/image/palembang.jpg" alt="Palembang">
                        <img id="image-8" src="assets/image/medan.jpg" alt="Medan">
                    </div>
                    <div class="slider-nav">
                        <a href="#image-5"></a>
                        <a href="#image-6"></a>
                        <a href="#image-7"></a>
                        <a href="#image-8"></a>
                    </div>
                </div>
                <p class="text-slider">Embark on a journey through Indonesia's diverse regions and experience their unique cultural heritage.</p>
                <button id="region-button" class="button-slider">Regions</button>
            </div>
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