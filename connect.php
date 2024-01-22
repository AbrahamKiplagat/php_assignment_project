<?php
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = "";
$DATABASE = 'signupforms';
$PORT = 3307;

$con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE, $PORT);

// Check if the connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully to the database.";
?>
