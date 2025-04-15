<?php
session_start();
include('../includes/db.php');

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Check if task ID is provided in the URL
if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Delete task from the database
    $sql = "DELETE FROM tasks WHERE id = $task_id";
    if ($conn->query($sql) === TRUE) {
        // Redirect to manage_tasks.php with success message
        header("Location: manage_tasks.php?deleted=1");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No task ID provided.";
}

$conn->close();
?>
