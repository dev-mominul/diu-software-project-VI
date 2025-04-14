<!-- includes/navbar.php -->
<nav class="bg-blue-600 p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center max-w-screen-xl">
        <!-- Left side: Logo / Title -->
        <a href="/task_management_system/index.php" class="text-white text-2xl font-bold hover:text-gray-200">Task Manager</a>

        <!-- Right side: Navigation links -->
        <div>
            <?php if (isset($_SESSION['username'])): ?>
                <!-- Logged-in navbar -->
                <a href="/task_management_system/admin/dashboard.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Dashboard</a>
                <a href="/task_management_system/admin/manage_tasks.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Manage Tasks</a>
                <a href="/task_management_system/admin/manage_users.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Manage Users</a>
                <a href="/task_management_system/logout.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Logout</a>
            <?php else: ?>
                <!-- Not logged in -->
                <a href="/task_management_system/login.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Login</a>
                <a href="/task_management_system/register.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
