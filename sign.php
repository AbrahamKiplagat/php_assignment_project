<?php
$error_message = "";
$success_message = "";

session_start(); // Start or resume a session

if ($_SERVER['REQUEST_METHOD'] == "POST") {
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
    $role = sanitize_input($_POST['role']);

    // Validate input (you can add more validation as needed)
    if (empty($username) || empty($password) || empty($role)) {
        $error_message = "Please fill in all fields";
    } else {
        // Hash the password (for security)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the username already exists
        $check_query = "SELECT * FROM registration WHERE username = ?";
        $stmt_check = mysqli_prepare($con, $check_query);
        mysqli_stmt_bind_param($stmt_check, "s", $username);
        mysqli_stmt_execute($stmt_check);

        if (mysqli_stmt_fetch($stmt_check)) {
            $error_message = "Error: User already exists";
        } else {
            // Perform SQL query to insert data into the database using prepared statement
            $stmt = mysqli_prepare($con, "INSERT INTO registration (username, password, role) VALUES (?, ?, ?)");

            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param($stmt, "sss", $username, $hashed_password, $role);

            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Record added successfully";

                // Store user information in session after successful registration
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;

                // Redirect to welcome.php after successful registration
                header("Location: welcome.php");
                exit(); // Ensure that no further code is executed after the redirect
            } else {
                $error_message = "Error: " . mysqli_stmt_error($stmt);
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        }

        // Close the statement for checking existing username
        mysqli_stmt_close($stmt_check);
    }

    // Close the database connection
    mysqli_close($con);
}
?>

<!-- ... (rest of the HTML remains unchanged) -->

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">
    <title>Sign Up Page</title>
</head>

<body>
    <h1 class="text-center">Sign up page</h1>
    <div class="container mt-5">
        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <form action="sign.php" method="post">
            <div class="mb-3">
                <label for="exampleInputName" class="form-label">Name</label>
                <input type="text" placeholder="Enter Your Name" name="username" class="form-control">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="mb-3">
                <label for="exampleInputRole" class="form-label">Role</label>
                <select class="form-select" name="role">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn w-100 btn-primary">Submit</button>
        </form>
    </div>
</body> 
</html>
