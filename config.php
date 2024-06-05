<?php
// Database configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'sos');
define('DB_PORT', '3310');

// Create a database connection
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

// Check the connection
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Optional: Set the character set to UTF-8
if (!mysqli_set_charset($conn, 'utf8')) {
    die("Error loading character set utf8: " . mysqli_error($conn));
}
