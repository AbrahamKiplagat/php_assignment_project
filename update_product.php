<?php
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

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

    // Perform SQL query to update product data
    $update_query = "UPDATE products SET name = '$name', price = '$price', description = '$description' WHERE id = $product_id";

    if (mysqli_query($con, $update_query)) {
        header("Location: view_product.php?id=$product_id");
        exit();
    } else {
        echo "Error updating product: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
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
    </style>

    <?php
    include 'header.php';
    include 'admin_sidebar.php';
    ?>

    <div class="content mt-5">
        <h1 class="text-center">Update Product</h1>
        <form action="update_product.php?id=<?php echo $product['id']; ?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $product['name']; ?>">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" class="form-control" value="<?php echo $product['price']; ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control"><?php echo $product['description']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
        
    </div>
</body>

</html>
