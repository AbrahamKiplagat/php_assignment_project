<!-- ... (previous code) ... -->

<body>
    <!-- Navigation Bar -->
    
<nav class="navbar navbar-expand-lg navbar-dark  fixed-top" style="background-color: #f905ea;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Welcome Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link btn btn-custom-danger" href="logout.php">Logout</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link btn btn-custom-success" href="logout.php">Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-custom-danger" href="logout.php">Logout</a>
                </li> -->
            </ul>
        </div>
    </div>
</nav>

    <?php
    // Include the admin sidebar
    if ($_SESSION['role'] === 'admin') {
        include 'admin_sidebar.php';
    }
    ?>
