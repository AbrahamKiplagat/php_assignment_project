<?php
include "connect.php";

session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: manage_products.php');
    exit();
}

$product_id = $_GET['id'];

$result = mysqli_query($con, "SELECT * FROM products WHERE id = $product_id");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header('Location: manage_products.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product Details</title>
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

        /* Card styling */
        .card {
            max-width: 400px;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }
    </style>

    <?php
    include 'header.php';
    include 'admin_sidebar.php';
    ?>

    <div class="content mt-5">
        <h1 class="text-center">Product Details</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Product ID: <?php echo $product['id']; ?></h5>
                <p class="card-text">Name: <?php echo $product['name']; ?></p>
                <p class="card-text">Price: <?php echo $product['price']; ?></p>
                <p class="card-text">Description: <?php echo $product['description']; ?></p>
            </div>
        </div>
        <a href="manage_products.php" class="btn btn-primary mt-3">Back to Products List</a>
    </div>
</body>

</html>
