<?php
session_start();
include('../includes/db.php');

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");  // Redirect to login if not admin
    exit();
}

// Delete task
if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $sql = "DELETE FROM tasks WHERE id = $task_id";

    if ($conn->query($sql) === TRUE) {
        echo "Task deleted successfully!";
        header("Location: manage_tasks.php");  // Redirect to task management page
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
