<?php
session_start();
include('../includes/db.php'); // Include the database connection

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");  // Redirect to login if not admin
    exit();
}

// Handle task creation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];  // Task Title
    $description = $_POST['description'];  // Task Description (optional)
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];
    $user_id = $_POST['user_id'];  // User selected to assign the task to

    // Insert task into database
    $sql = "INSERT INTO tasks (title, description, due_date, status, user_id) VALUES ('$title', '$description', '$due_date', '$status', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "The task has been successfully added.";
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
    <title>Add Task</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Include Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Page Title -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold">Add New Task</h1>
    </header>

        <!-- Add Task Form -->
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

            <form action="add_task.php" method="POST">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700">Title</label>
                    <!-- Task Title Input -->
                    <input type="text" name="title" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700"> Description</label>
                    <!-- Task Description Text Area -->
                    <textarea name="description" class="w-full p-3 mt-2 border border-gray-300 rounded" rows="5"></textarea>
                </div>

                <div class="mb-4">
                    <label for="due_date" class="block text-gray-700">Due Date</label>
                    <input type="date" name="due_date" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700">Status</label>
                    <select name="status" class="w-full p-3 mt-2 border border-gray-300 rounded">
                        <option value="pending">Pending</option>
                        <option value="in-progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="user_id" class="block text-gray-700">Assign to User</label>
                    <select name="user_id" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                        <option value="">Select User</option>
                        <?php
                        // Fetch all users to assign task to
                        $sql = "SELECT id, username FROM users WHERE role = 'user'";
                        $users_result = $conn->query($sql);
                        if ($users_result->num_rows > 0) {
                            while ($user = $users_result->fetch_assoc()) {
                                echo "<option value='{$user['id']}'>{$user['username']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">Add Task</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>

<?php
$conn->close();
?>
