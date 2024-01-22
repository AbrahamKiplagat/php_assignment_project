<?php
// Check if the user is logged in
// session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Fetch the user's role from the session
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>

<!-- Sidebar -->
<div class="sidebar">
    <a href="welcome.php">Home</a>
    
    <?php
    // Display admin-specific links if the user is an admin
    if ($userRole === 'admin') {
        echo '
            <a href="manage_users.php">Manage Users</a>
            <a href="manage_products.php">Manage Products</a>
            <a href="add_user.php">Add User</a>
        ';
        // Add other admin-specific links here
    } else {
        // Display user-specific link if the user is not an admin
        echo '<a href="view_product_public.php">View Products</a>';
        // Add other user-specific links here
    }
    ?>
</div>
