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
    <!-- Include FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">

    <!-- Include Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Admin Dashboard Content -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold">Admin Dashboard</h1>
    </header>

    <div class="container mx-auto p-6 max-w-screen-xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Task Overview Card with Icon -->
            <div class="bg-white p-8 shadow-lg rounded-lg flex items-center">
                <div class="text-blue-600 mr-6">
                    <i class="fas fa-tasks fa-2x"></i> <!-- Adjusted icon size -->
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Total Tasks</h2>
                    <p class="text-gray-600"><?php echo $tasks_result->num_rows; ?> Tasks</p>
                    <a href="manage_tasks.php" class="text-blue-600 hover:text-blue-800">Manage Tasks</a>
                </div>
            </div>

            <!-- User Overview Card with Icon -->
            <div class="bg-white p-8 shadow-lg rounded-lg flex items-center">
                <div class="text-blue-600 mr-6">
                    <i class="fas fa-users fa-2x"></i> <!-- Adjusted icon size -->
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Total Users</h2>
                    <p class="text-gray-600"><?php echo $users_result->num_rows; ?> Users</p>
                    <a href="manage_users.php" class="text-blue-600 hover:text-blue-800">Manage Users</a>
                </div>
            </div>

            <!-- Add New Task Card with Icon -->
            <div class="bg-white p-8 shadow-lg rounded-lg flex items-center">
                <div class="text-blue-600 mr-6">
                    <i class="fas fa-plus-circle fa-2x"></i> <!-- Adjusted icon size -->
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Add New Task</h2>
                    <a href="add_task.php" class="text-blue-600 hover:text-blue-800">Add Task</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<?php
$conn->close();
?>
