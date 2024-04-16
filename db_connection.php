<?php
// Database configuration
$db_host = 'localhost';     // Change this to your database host
$db_username = 'root';      // Change this to your database username
$db_password = '';          // Change this to your database password
$db_name = 'lamonde'; // Change this to your database name

// Create database connection
$connection = mysqli_connect($db_host, $db_username, $db_password, $db_name);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
