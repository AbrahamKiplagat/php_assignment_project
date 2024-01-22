<?php
// Include connection to the database
include "connect.php";

// Check if the user is logged in and has admin role
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Function to sanitize input
function sanitize_input($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

// Check if the user ID is provided
if (!isset($_GET['id'])) {
    header('Location: manage_users.php');
    exit();
}

$user_id = $_GET['id'];

// Fetch user information from the database
$result = mysqli_query($con, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($result);

// Check if the user exists
if (!$user) {
    header('Location: manage_users.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);
    $role = sanitize_input($_POST['role']);

    // Validate input
    if (empty($username) || empty($role)) {
        echo "Please fill in all required fields";
        exit();
    }

    // If a new password is provided, hash it
    $hashed_password = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $user['password'];

    // Perform SQL query to update user data
    $update_query = "UPDATE users SET username = '$username', password = '$hashed_password', role = '$role' WHERE id = $user_id";

    if (mysqli_query($con, $update_query)) {
        header('Location: manage_users.php');
        exit();
    } else {
        echo "Error updating user: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Update User</h1>
        <form action="update_user.php?id=<?php echo $user['id']; ?>" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $user['username']; ?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <input type="text" name="role" class="form-control" value="<?php echo $user['role']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
</body>

</html>
