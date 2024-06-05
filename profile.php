<?php
// Start a session
session_start();

// Include the database configuration file
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Retrieve user information from the session
$username = $_SESSION['username'] ?? 'N/A';
$email = $_SESSION['email'] ?? 'N/A';
$full_name = $_SESSION['full_name'] ?? 'N/A';
$phone = $_SESSION['phone'] ?? 'N/A';
$profile_picture = $_SESSION['profile_picture'] ?? 'usericon.png';

// Define the profile pictures path
$profile_pictures_path = 'uploads/profile_pictures/';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile - <?php echo htmlspecialchars($username); ?></title>
    <link rel="icon" href="assets/image/icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="assets/image/icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/profile.css">
</head>

<body>
    <div class="profile-container">
        <h2>Profile</h2>
        <img src="<?php echo $profile_pictures_path . htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="profile-picture">
        <div class="profile-info">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($full_name); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
        </div>
        <form action="edit_profile.php" method="GET">
            <button type="submit" class="edit-btn">Edit</button>
        </form>
        <form action="order_list.php" method="GET">
            <button type="submit" class="logout-btn">Order List</button>
        </form>
        <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>

</html>