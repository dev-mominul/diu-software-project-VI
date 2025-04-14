<?php
session_start();
include('../includes/db.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

// Get the task ID from the URL
if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    
    // Fetch task details from the database, ensuring the task belongs to the logged-in user
    $sql = "SELECT * FROM tasks WHERE id = $task_id AND user_id = {$_SESSION['user_id']}";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
    } else {
        echo "Task not found or you don't have permission to edit it.";
        exit();  // Exit if the task is not found or doesn't belong to the logged-in user
    }
} else {
    echo "Task ID is missing.";
    exit();  // Exit if no task ID is provided in the URL
}

// Handle task status update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];

    // Update task status in the database
    $update_sql = "UPDATE tasks SET status = '$status' WHERE id = $task_id";

    if ($conn->query($update_sql) === TRUE) {
        $success_message = "Task status updated successfully!";
    } else {
        $error_message = "Error updating task: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Include Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Main Content -->
    <div class="container mx-auto p-6 max-w-screen-xl">
        <h1 class="text-3xl font-semibold text-center text-gray-700 mb-6">Edit Task</h1>

        <!-- Success/Error Messages -->
        <?php if (isset($success_message)): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-md mb-6">
                <p><strong>Success:</strong> <?= $success_message ?></p>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-md mb-6">
                <p><strong>Error:</strong> <?= $error_message ?></p>
            </div>
        <?php endif; ?>

        <!-- Edit Task Form -->
        <div class="max-w-lg mx-auto bg-white p-8 shadow-lg rounded-lg">
            <form action="edit_task.php?id=<?= $task['id']; ?>" method="POST">
                <!-- Task Description (Read-only) -->
                <div class="mb-4">
                    <label for="description" class="block text-gray-700">Task Description</label>
                    <input type="text" name="description" value="<?= $task['description']; ?>" class="w-full p-3 mt-2 border border-gray-300 rounded" readonly>
                </div>

                <!-- Due Date (Read-only) -->
                <div class="mb-4">
                    <label for="due_date" class="block text-gray-700">Due Date</label>
                    <input type="date" name="due_date" value="<?= $task['due_date']; ?>" class="w-full p-3 mt-2 border border-gray-300 rounded" readonly>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="block text-gray-700">Task Status</label>
                    <select name="status" class="w-full p-3 mt-2 border border-gray-300 rounded">
                        <option value="pending" <?= $task['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="in-progress" <?= $task['status'] == 'in-progress' ? 'selected' : ''; ?>>In Progress</option>
                        <option value="completed" <?= $task['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">Update Status</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
