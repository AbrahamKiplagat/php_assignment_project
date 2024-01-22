<?php
// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

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
    $name = sanitize_input($_POST['name']);
    $price = sanitize_input($_POST['price']);
    $description = sanitize_input($_POST['description']);

    // Validate input
    if (empty($name) || empty($price) || empty($description)) {
        echo "Please fill in all fields";
        exit();
    }

    // Perform SQL query to insert new product
    $insert_query = "INSERT INTO products (name, price, description) VALUES ('$name', '$price', '$description')";

    if (mysqli_query($con, $insert_query)) {
        header('Location: manage_products.php');
        exit();
    } else {
        echo "Error adding product: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
    include 'header.php';
    include 'admin_sidebar.php';
    ?>
    <div class="content mt-5">
        <h1 class="text-center">Add Product</h1>
        <form action="add_product.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" class="form-control" step="0.01">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</body>

</html>
