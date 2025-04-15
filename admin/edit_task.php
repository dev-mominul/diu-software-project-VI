<?php
session_start();  // Start the session
ini_set('display_errors', 1);  // Display errors
error_reporting(E_ALL);        // Report all PHP errors

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

// Fetch all users to populate the dropdown for user assignment
$user_sql = "SELECT id, username FROM users";
$user_result = $conn->query($user_sql);
$users = [];
while ($row = $user_result->fetch_assoc()) {
    $users[] = $row;
}

// Handle task update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];  // Get the task title
    $description = $_POST['description'];  // Get the task description
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];
    $assigned_user = $_POST['assigned_user'];  // Get the assigned user (user_id)

    // Update the task with new data, including user_id for assignment
    $update_sql = "UPDATE tasks SET title='$title', description='$description', due_date='$due_date', status='$status', user_id='$assigned_user' WHERE id=$task_id";

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

    <!-- Admin Dashboard Title (Separated from Navbar) -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold">Edit Task</h1>
    </header>

        <!-- Edit Task Form -->
        <div class="max-w-lg mx-auto bg-white p-8 shadow-lg rounded-lg">
            <!-- Success and Error Messages Inside the Form -->
            <?php if (isset($success_message)): ?>
                <div class="bg-green-100 text-green-700 p-4 rounded-md mb-6">
                    <p><?= $success_message ?></p>
                </div>
            <?php elseif (isset($error_message)): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded-md mb-6">
                    <p><?= $error_message ?></p>
                </div>
            <?php endif; ?>

            <form action="edit_task.php?id=<?php echo $task['id']; ?>" method="POST">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700">Task Title</label>
                    <!-- Task Title Input -->
                    <input type="text" name="title" value="<?php echo $task['title']; ?>" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700">Task Description</label>
                    <!-- Task Description Text Area -->
                    <textarea name="description" class="w-full p-3 mt-2 border border-gray-300 rounded" rows="5" ><?php echo $task['description']; ?></textarea>
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

                <div class="mb-4">
                    <label for="assigned_user" class="block text-gray-700">Assign User</label>
                    <select name="assigned_user" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                        <option value="">Select User</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['id']; ?>" <?php if ($user['id'] == $task['user_id']) echo 'selected'; ?>>
                                <?php echo $user['username']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">Update Task</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>

<?php
$conn->close();
?>
