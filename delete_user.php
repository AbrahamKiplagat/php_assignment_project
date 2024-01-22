<?php
// Include connection to the database
include "connect.php";

// Check if the user is logged in and has admin role
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Check if the user ID is provided
if (!isset($_GET['id'])) {
    header('Location: manage_users.php');
    exit();
}

$user_id = $_GET['id'];

// Perform SQL query to delete the user
$delete_query = "DELETE FROM users WHERE id = $user_id";

if (mysqli_query($con, $delete_query)) {
    header('Location: manage_users.php');
    exit();
} else {
    echo "Error deleting user: " . mysqli_error($con);
}
?>
