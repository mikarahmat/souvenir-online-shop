<?php
// Include the database configuration file
include 'config.php';

// Start a session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted username/email and password
    $username_or_email = $_POST['username_or_email'];
    $password = $_POST['password'];

    // Prepare an SQL statement to find the user
    $stmt = $conn->prepare("SELECT user_id, username, email, password, full_name, phone, role FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param('ss', $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Verify if the user exists and the password matches
    if ($user && password_verify($password, $user['password'])) {
        // Store user information in the session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email']; // Add email to session
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['phone'] = $user['phone'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on user role
        if ($user['role'] === 'admin') {
            header('Location: dashboard.php');
        } else {
            header('Location: home.php');
        }
        exit;
    } else {
        // If login failed
        echo "<script>alert('Invalid username/email or password.'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <!-- title & icon -->
    <link rel="icon" href="assets/image/icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="assets/image/icon.ico" type="image/x-icon">
    <title>Login - Souvenir Online Shop</title>
    <!-- css -->
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <section id="video_sec" class="video_sec">
        <video autoplay muted loop>
            <source src="assets/video/video2.mp4" type="video/mp4">
        </video>
        <div class="overlay">
            <div class="login-container">
                <h2>Login to Your Account</h2>
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="username_or_email">Username or Email</label>
                        <input type="text" name="username_or_email" id="username_or_email" placeholder="Enter your username or email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="login-btn">Login</button>
                    <a href="register.php" class="register-link">Create an Account</a>
                </form>
            </div>
        </div>
    </section>
</body>

</html>