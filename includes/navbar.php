<!-- includes/navbar.php -->
<nav class="bg-blue-600 p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center max-w-screen-xl">
        <!-- Site Title -->
        <a href="/index.php" class="text-white text-2xl font-bold hover:text-gray-200">Task Manager</a>
        
        <!-- Navbar Menu (Right Side) -->
        <div>
            <?php if (isset($_SESSION['username'])): ?>
                <!-- Logged-in Navbar (Admin or User) -->
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <!-- Admin-Specific Links -->
                    <a href="/admin/dashboard.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Admin Dashboard</a>
                    <a href="/admin/manage_tasks.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Manage Tasks</a>
                    <a href="/admin/manage_users.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Manage Users</a>
                <?php else: ?>
                    <!-- User-Specific Links -->
                    <a href="/user/dashboard.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Dashboard</a>
                <?php endif; ?>
                
                <!-- Logout Link (relative path to the root directory) -->
                <a href="/logout.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Logout</a>
            <?php else: ?>
                <!-- Not Logged-in Navbar -->
                <a href="/login.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Login</a>
                <a href="/register.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
