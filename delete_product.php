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

$delete_query = "DELETE FROM products WHERE id = $product_id";

if (mysqli_query($con, $delete_query)) {
    header('Location: manage_products.php');
    exit();
} else {
    echo "Error deleting product: " . mysqli_error($con);
}
?>
