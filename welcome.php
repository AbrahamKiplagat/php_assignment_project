<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to the login page if not logged in
    exit();
}

$username = $_SESSION['username'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'User'; // Default to 'User' if role is not set
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">
    <!-- Custom styles -->
    <style>
        body {
            padding-top: 56px; /* Adjusted for the fixed top navbar */
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 56px; /* Height of the fixed top navbar */
            left: 0;
            width: 250px;
            background-color: #aa95d8; /* Bootstrap dark color */
            padding-top: 20px;
            color: white;
        }

        .sidebar a {
            padding: 10px;
            color: white;
            text-decoration: none;
            display: block;
        }

        .sidebar a:hover {
            background-color: #495057; /* Bootstrap secondary color */
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>

<body>
<style>
    

    .btn-custom-danger {
        background-color: #dc3545; /* Bootstrap danger color */
        border-color: #dc3545;
        font-weight: bold;
    }
</style> 
<?php
include 'header.php';

    // Include sidebar
    include 'admin_sidebar.php';
?>
    <!-- Sidebar -->
    

    <!-- Main Content -->
    <div class="content">
        <h1>Welcome, <?php echo $username; ?>!</h1>
        <p>Your Role: <?php echo $role; ?></p>

        <?php if (strcasecmp($role, 'Admin') === 0): ?>
            <h2>Admin Dashboard</h2>
            <!-- Admin-specific content goes here -->
        <?php elseif (strcasecmp($role, 'User') === 0): ?>
            <h2>User Dashboard</h2>
            <!-- User-specific content goes here -->
        <?php else: ?>
            <p>Unknown Role</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JavaScript (optional, only needed if you use Bootstrap JS components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>
