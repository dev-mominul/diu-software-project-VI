<!-- includes/navbar.php -->
<?php
session_start();
?>

<nav class="bg-blue-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="index.php" class="text-white text-xl font-bold">Task Manager</a>
        <div>
            <?php if (isset($_SESSION['username'])): ?>
                <!-- Logged-in navbar -->
                <a href="index.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Home</a>
                <a href="add_task.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Add Task</a>

                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <!-- Admin-specific links -->
                    <a href="admin_dashboard.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Dashboard</a>
                    <a href="user_management.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">User Management</a>
                <?php endif; ?>
                
                <a href="logout.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Logout</a>
            <?php else: ?>
                <!-- Not logged in -->
                <a href="login.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Login</a>
                <a href="register.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
