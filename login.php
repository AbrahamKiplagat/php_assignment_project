<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "connect.php";

    // Function to sanitize input
    function sanitize_input($input)
    {
        global $con;
        return mysqli_real_escape_string($con, htmlspecialchars(trim($input)));
    }

    // Get and sanitize form data
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);

    // Validate input (you can add more validation as needed)
    if (empty($username) || empty($password)) {
        $error_message = "Please fill in all fields";
    } else {
        // Authenticate user from "users" table
        $query = "SELECT username, password FROM users WHERE username = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $db_username, $db_password);
            mysqli_stmt_fetch($stmt);

            // Verify the password
            if (password_verify($password, $db_password)) {
                // Start the session and set session variables
                session_start();
                $_SESSION['username'] = $db_username;

                // Redirect to the dashboard
                header('Location: welcome.php');
                exit();
            }
        }

        // Close the statement
        mysqli_stmt_close($stmt);

        // Authenticate user from "register" table
        $query = "SELECT username, password, role FROM registration WHERE username = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $db_username, $db_password, $db_role);
            mysqli_stmt_fetch($stmt);

            // Verify the password
            if (password_verify($password, $db_password)) {
                // Start the session and set session variables
                session_start();
                $_SESSION['username'] = $db_username;
                $_SESSION['role'] = $db_role;

                // Redirect to the welcome page
                header('Location: welcome.php');
                exit();
            }
        }

        // Close the statement
        mysqli_stmt_close($stmt);

        // If neither table has a matching user, show an error
        $error_message = "Invalid username or password";
    }

    // Close the database connection
    mysqli_close($con);
}
?>
<!-- Rest of your HTML code remains unchanged -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">
</head>

<body>
<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color: #f8f9fa; /* Bootstrap background color */
    }

    .container {
        width: 400px;
        margin-top: 50px;
    }

    .alert {
        margin-top: 20px;
    }

    form {
        margin-top: 20px;
    }

    .mt-3 {
        margin-top: 20px;
    }

    p {
        text-align: center;
    }
</style>

    <div class="container mt-5">
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <div class="mt-3">
            <p>Don't have an account? <a href="sign.php">Register here</a>.</p>
        </div>
    </div>
</body>

</html>
