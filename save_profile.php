<?php
// Include the database configuration file
include 'config.php';

// Start a session
session_start();

// Define the profile pictures path
$profile_pictures_path = 'uploads/profile_pictures/';

// Create the directory if it doesn't exist
if (!is_dir($profile_pictures_path)) {
    mkdir($profile_pictures_path, 0777, true);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];

    // Initialize profile picture
    $profile_picture = $_SESSION['profile_picture'] ?? 'usericon.png';

    // Handle file upload if a new picture is provided
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_name = basename($_FILES['profile_picture']['name']);
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = $user_id . '.' . $file_extension;

        // Move the uploaded file to the profile pictures directory
        if (move_uploaded_file($file_tmp, $profile_pictures_path . $new_file_name)) {
            $profile_picture = $new_file_name;
        }
    }

    // Update user data in the database
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, full_name = ?, phone = ?, profile_picture = ? WHERE user_id = ?");
    $stmt->bind_param('sssssi', $username, $email, $full_name, $phone, $profile_picture, $user_id);

    if ($stmt->execute()) {
        // Update session data
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['full_name'] = $full_name;
        $_SESSION['phone'] = $phone;
        $_SESSION['profile_picture'] = $profile_picture;

        echo "<script>alert('Profile updated successfully!'); window.location.href = 'profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
}
