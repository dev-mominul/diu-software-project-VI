<!-- admin/dashboard.php -->
<?php
session_start();
include('../includes/db.php');

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");  // Redirect to login if not admin
    exit();
}

// Fetch tasks and users from the database for the dashboard overview
$tasks_query = "SELECT * FROM tasks";
$tasks_result = $conn->query($tasks_query);

$users_query = "SELECT * FROM users";
$users_result = $conn->query($users_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Include Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Admin Dashboard Content -->
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-center text-gray-700 mb-6">Admin Dashboard</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Task Overview Card -->
            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800">Total Tasks</h2>
                <p class="text-gray-600"><?php echo $tasks_result->num_rows; ?> Tasks</p>
                <a href="manage_tasks.php" class="text-blue-600 hover:text-blue-800">Manage Tasks</a>
            </div>

            <!-- User Overview Card -->
            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800">Total Users</h2>
                <p class="text-gray-600"><?php echo $users_result->num_rows; ?> Users</p>
                <a href="manage_users.php" class="text-blue-600 hover:text-blue-800">Manage Users</a>
            </div>

            <!-- Add New Task Card -->
            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800">Add New Task</h2>
                <a href="add_task.php" class="text-blue-600 hover:text-blue-800">Add Task</a>
            </div>
        </div>

        <!-- Admin Actions -->
        <div class="mt-8">
            <h2 class="text-2xl font-semibold text-gray-800">Actions</h2>
            <ul class="list-disc ml-6 mt-4">
                <li><a href="manage_tasks.php" class="text-blue-600 hover:text-blue-800">View All Tasks</a></li>
                <li><a href="manage_users.php" class="text-blue-600 hover:text-blue-800">View All Users</a></li>
                <li><a href="add_task.php" class="text-blue-600 hover:text-blue-800">Create New Task</a></li>
            </ul>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include('../includes/footer.php'); ?>

</body>
</html>

<?php
$conn->close();
?>
