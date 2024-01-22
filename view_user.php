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

// Fetch user information from the database
$result = mysqli_query($con, "SELECT id, username, role FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($result);

// Check if the user exists
if (!$user) {
    header('Location: manage_users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">
</head>

<body>
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

        .btn-custom-danger {
            background-color: #dc3545; /* Bootstrap danger color */
            border-color: #dc3545;
            font-weight: bold;
        }

        .card {
            width: 18rem;
        }
    </style>
    <?php
    include 'header.php';

    // Include sidebar
    include 'admin_sidebar.php';
    ?>
    <div class="content mt-5">
        <h1 class="text-center">User Details</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User Information</h5>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td><?php echo $user['id']; ?></td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td><?php echo $user['username']; ?></td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td><?php echo $user['role']; ?></td>
                        </tr>
                    </tbody>
                </table>
                <a href="manage_users.php" class="btn btn-primary">Back to Users List</a>
            </div>
        </div>
    </div>
</body>

</html>
