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

// In-Progress Tasks
$sql_in_progress = "SELECT * FROM tasks WHERE user_id = $user_id AND status = 'in-progress' ORDER BY due_date ASC";
$in_progress_result = $conn->query($sql_in_progress);

// Upcoming Tasks (Pending status)
$sql_upcoming = "SELECT * FROM tasks WHERE user_id = $user_id AND status = 'pending' ORDER BY due_date ASC";
$upcoming_result = $conn->query($sql_upcoming);

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
        <!-- Page Title -->
        <header class="text-center pt-10 pb-16">
            <h1 class="text-3xl font-bold text-gray-700">User Dashboard</h1> <!-- Title with appropriate spacing -->
        </header>

        <!-- Horizontal Task Categories -->
        <div class="flex justify-between mb-12"> <!-- Increased bottom margin for better separation -->
            <div class="w-full text-center">
                <h2 class="text-xl font-semibold text-gray-700 flex items-center justify-center">
                    <i class="fas fa-spinner text-orange-500 mr-2"></i> In-Progress
                </h2>
            </div>
            <div class="w-full text-center">
                <h2 class="text-xl font-semibold text-gray-700 flex items-center justify-center">
                    <i class="fas fa-clock text-blue-500 mr-2"></i> Upcoming
                </h2>
            </div>
            <div class="w-full text-center">
                <h2 class="text-xl font-semibold text-gray-700 flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i> Completed
                </h2>
            </div>
        </div>

        <!-- Task Lists -->
        <div class="flex space-x-6">
            <!-- In-progress Tasks -->
            <div class="w-1/3 bg-white p-6 shadow-lg rounded-lg">
                <?php if ($in_progress_result->num_rows > 0): ?>
                    <?php while ($task = $in_progress_result->fetch_assoc()): ?>
                        <div class="mb-6 border-b pb-6">
                            <div class="flex items-center space-x-3">
                                <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                                <h3 class="text-lg font-semibold text-gray-800"><?= $task['title']; ?></h3> <!-- Task Title -->
                            </div>
                            <p class="text-gray-600">Due: <?= $task['due_date']; ?></p>
                            <a href="edit_task.php?id=<?= $task['id']; ?>" class="text-blue-600 hover:text-blue-800 mt-2 block">Edit Task</a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center text-gray-600">No in-progress tasks.</p>
                <?php endif; ?>
            </div>

            <!-- Upcoming Tasks -->
            <div class="w-1/3 bg-white p-6 shadow-lg rounded-lg">
                <?php if ($upcoming_result->num_rows > 0): ?>
                    <?php while ($task = $upcoming_result->fetch_assoc()): ?>
                        <div class="mb-6 border-b pb-6">
                            <div class="flex items-center space-x-3">
                                <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                                <h3 class="text-lg font-semibold text-gray-800"><?= $task['title']; ?></h3> <!-- Task Title -->
                            </div>
                            <p class="text-gray-600">Due: <?= $task['due_date']; ?></p>
                            <a href="edit_task.php?id=<?= $task['id']; ?>" class="text-blue-600 hover:text-blue-800 mt-2 block">Edit Task</a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center text-gray-600">No upcoming tasks.</p>
                <?php endif; ?>
            </div>

            <!-- Completed Tasks -->
            <div class="w-1/3 bg-white p-6 shadow-lg rounded-lg">
                <?php if ($completed_result->num_rows > 0): ?>
                    <?php while ($task = $completed_result->fetch_assoc()): ?>
                        <div class="mb-6">
                            <div class="flex items-center space-x-3">
                                <span class="w-3 h-3 rounded-full bg-green-500"></span>
                                <h3 class="text-lg font-semibold text-gray-800"><?= $task['title']; ?></h3> <!-- Task Title -->
                            </div>
                            <p class="text-gray-600">Completed on: <?= $task['due_date']; ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center text-gray-600">No completed tasks.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>

</body>
</html>

<?php
$conn->close();
?>
