<?php
session_start();
include('../includes/db.php'); // Include the database connection

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");  // Redirect to login if not admin
    exit();
}

// Fetch task details for the task ID from the URL
if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $sql = "SELECT * FROM tasks WHERE id = $task_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
    } else {
        echo "Task not found.";
        exit();
    }
}

// Handle task update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    $update_sql = "UPDATE tasks SET description='$description', due_date='$due_date', status='$status' WHERE id=$task_id";

    if ($conn->query($update_sql) === TRUE) {
        $success_message = "The task has been successfully updated.";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
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
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-center text-gray-700 mb-6">Edit Task</h1>

        <!-- Success and Error Messages -->
        <?php if (isset($success_message)): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-md mb-6">
                <p><?= $success_message ?></p>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-md mb-6">
                <p><?= $error_message ?></p>
            </div>
        <?php endif; ?>

        <!-- Edit Task Form -->
        <div class="max-w-lg mx-auto bg-white p-8 shadow-lg rounded-lg">
            <form action="edit_task.php?id=<?php echo $task['id']; ?>" method="POST">
                <div class="mb-4">
                    <label for="description" class="block text-gray-700">Task Description</label>
                    <input type="text" name="description" value="<?php echo $task['description']; ?>" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <div class="mb-4">
                    <label for="due_date" class="block text-gray-700">Due Date</label>
                    <input type="date" name="due_date" value="<?php echo $task['due_date']; ?>" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700">Status</label>
                    <select name="status" class="w-full p-3 mt-2 border border-gray-300 rounded">
                        <option value="pending" <?php if ($task['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="in-progress" <?php if ($task['status'] == 'in-progress') echo 'selected'; ?>>In Progress</option>
                        <option value="completed" <?php if ($task['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">Update Task</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>

<?php
$conn->close();
?>
