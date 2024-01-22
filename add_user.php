<?php
// Include connection to the database
include "connect.php";

// Check if the user is logged in and has admin role
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    // Function to sanitize user input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// The rest of your code goes here...

    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);
    $role = sanitize_input($_POST['role']);

    // Validate input
    if (empty($username) || empty($password) || empty($role)) {
        echo "Please fill in all fields";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Perform SQL query to insert new user
    $insert_query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";

    if (mysqli_query($con, $insert_query)) {
        header('Location: manage_users.php');
        exit();
    } else {
        echo "Error adding user: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
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
    </style>
<?php
    // Include navbar
    include 'header.php';

    // Include sidebar
    include 'admin_sidebar.php';
    ?>
    <div class="content mt-5">
        <h1 class="text-center">Add User</h1>
        <form action="add_user.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
    <label for="role" class="form-label">Role</label>
    <select class="form-select" name="role" required>
        <option value="user" selected>User</option>
        <!-- You can add more roles as needed -->
    </select>
</div>

            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
    </div>
</body>

</html>
