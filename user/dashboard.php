<?php
session_start();
include('../includes/db.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

// Fetch tasks categorized by status
$user_id = $_SESSION['user_id'];

// Upcoming Tasks (Pending status)
$sql_upcoming = "SELECT * FROM tasks WHERE user_id = $user_id AND status = 'pending' ORDER BY due_date ASC";
$upcoming_result = $conn->query($sql_upcoming);

// In-Progress Tasks
$sql_in_progress = "SELECT * FROM tasks WHERE user_id = $user_id AND status = 'in-progress' ORDER BY due_date ASC";
$in_progress_result = $conn->query($sql_in_progress);

// Completed Tasks
$sql_completed = "SELECT * FROM tasks WHERE user_id = $user_id AND status = 'completed' ORDER BY due_date ASC";
$completed_result = $conn->query($sql_completed);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100">

    <!-- Include Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Main Content -->
    <div class="container mx-auto p-6 max-w-screen-xl">
        <h1 class="text-3xl font-semibold text-center text-gray-700 mb-6">Welcome to Your Dashboard, <?= $_SESSION['username']; ?></h1>

        <!-- Upcoming Tasks Section -->
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Upcoming Tasks (Pending)</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if ($upcoming_result->num_rows > 0): ?>
                <?php while ($task = $upcoming_result->fetch_assoc()): ?>
                    <div class="bg-white p-6 shadow-lg rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-yellow-500 mr-3"></i>
                            <h2 class="text-xl font-semibold text-gray-800"><?= $task['description']; ?></h2>
                        </div>
                        <p class="text-gray-600">Due: <?= $task['due_date']; ?></p>
                        <a href="edit_task.php?id=<?= $task['id']; ?>" class="text-blue-600 hover:text-blue-800">Edit Task</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="bg-white p-6 shadow-lg rounded-lg text-center">
                    <p class="text-gray-600">No upcoming tasks.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- In-progress Tasks Section -->
        <h2 class="text-2xl font-semibold text-gray-700 mt-10 mb-4">In-Progress Tasks</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if ($in_progress_result->num_rows > 0): ?>
                <?php while ($task = $in_progress_result->fetch_assoc()): ?>
                    <div class="bg-white p-6 shadow-lg rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-spinner text-blue-500 animate-spin mr-3"></i>
                            <h2 class="text-xl font-semibold text-gray-800"><?= $task['description']; ?></h2>
                        </div>
                        <p class="text-gray-600">Due: <?= $task['due_date']; ?></p>
                        <a href="edit_task.php?id=<?= $task['id']; ?>" class="text-blue-600 hover:text-blue-800">Edit Task</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="bg-white p-6 shadow-lg rounded-lg text-center">
                    <p class="text-gray-600">No in-progress tasks.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Completed Tasks Section -->
        <h2 class="text-2xl font-semibold text-gray-700 mt-10 mb-4">Completed Tasks</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if ($completed_result->num_rows > 0): ?>
                <?php while ($task = $completed_result->fetch_assoc()): ?>
                    <div class="bg-white p-6 shadow-lg rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <h2 class="text-xl font-semibold text-gray-800"><?= $task['description']; ?></h2>
                        </div>
                        <p class="text-gray-600">Completed on: <?= $task['due_date']; ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="bg-white p-6 shadow-lg rounded-lg text-center">
                    <p class="text-gray-600">No completed tasks.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>

<?php
$conn->close();
?>
