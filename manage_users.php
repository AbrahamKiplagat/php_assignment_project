<?php
// Include connection to the database
include "connect.php";

// Fetch all users from the database
$result = mysqli_query($con, "SELECT id, username, role FROM users");
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Check if the user is logged in and has admin role
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
        .btn-custom-danger {
        background-color: #dc3545; /* Bootstrap danger color */
        border-color: #dc3545;
        font-weight: bold;
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
            .btn-custom-danger {
        background-color: #dc3545; /* Bootstrap danger color */
        border-color: #dc3545;
        font-weight: bold;
    }
        }
    </style>
    <?php
include 'header.php';

    // Include sidebar
    include 'admin_sidebar.php';
?>
    <div class="content mt-5">
        <h1 class="text-center">Manage Users</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <a href="update_user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning">Update</a>
                            <a href="view_user.php?id=<?php echo $user['id']; ?>" class="btn btn-success">View</a>
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
