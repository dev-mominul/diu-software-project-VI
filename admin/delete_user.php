<?php
session_start();
include('../includes/db.php');

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");  // Redirect to login if not admin
    exit();
}

// Delete user
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id = $user_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to manage_users.php with success message
        header("Location: manage_users.php?deleted=1");
        exit();  // Stop script execution after redirect
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
