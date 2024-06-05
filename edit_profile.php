<?php
// Start a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Retrieve user information from the session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$full_name = $_SESSION['full_name'];
$phone = $_SESSION['phone'];
$profile_picture = $_SESSION['profile_picture'] ?? 'usericon.png';

// Define the profile pictures path
$profile_pictures_path = 'uploads/profile_pictures/';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Profile - <?php echo htmlspecialchars($username); ?></title>
    <link rel="icon" href="assets/image/icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="assets/image/icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/profile-2.css">
</head>

<body>
    <div class="edit-profile-container">
        <h2>Edit Profile</h2>
        <img src="<?php echo $profile_pictures_path . htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="profile-picture">
        <form action="save_profile.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
            </div>
            <div class="form-group">
                <label for="profile_picture">Profile Picture</label>
                <input type="file" name="profile_picture" id="profile_picture">
            </div>
            <button type="submit" class="save-btn">Save</button>
        </form>
        <form action="profile.php" method="GET">
            <button type="submit" class="cancel-btn">Cancel</button>
        </form>
    </div>
</body>

</html>