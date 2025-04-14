<?php
session_start();
include('../includes/db.php');

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");  // Redirect to login if not admin
    exit();
}

// Delete user
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = $user_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to manage_users.php with a success message (query parameter)
        header("Location: manage_users.php?deleted=1");
        exit(); // Make sure to stop script execution after redirection
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

