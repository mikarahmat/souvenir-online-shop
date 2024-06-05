<?php
// Include the database configuration file
include 'config.php';

// Start a session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'customer'; // Default role is customer

    // Validate that passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.'); window.history.back();</script>";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, full_name, phone, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssss', $username, $email, $hashed_password, $full_name, $phone, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please log in.'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Error during registration: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <!-- title & icon -->
    <link rel="icon" href="assets/image/icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="assets/image/icon.ico" type="image/x-icon">
    <title>Register - Souvenir Online Shop</title>
    <link rel="stylesheet" href="assets/css/register.css">
</head>

<body>
    <section id="video_sec" class="video_sec">
        <video autoplay muted loop>
            <source src="assets/video/video2.mp4" type="video/mp4">
        </video>
        <div class="overlay">
            <div class="register-container">
                <h2>Create an Account</h2>
                <form action="register.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" required placeholder="Enter your username">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" required placeholder="Enter your email">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" name="full_name" id="full_name" required placeholder="Enter your name">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" required placeholder="Enter your password">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" required placeholder="Enter your phone number">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" required placeholder="Confirm your password">
                        </div>
                    </div>
                    <button type="submit" class="register-btn">Register</button>
                    <a href="login.php" class="login-link">Already have an account? Login here</a>
                </form>
            </div>
        </div>
    </section>
</body>

</html>