<?php
// Include database connection
include('includes/db.php');

// Fetch all tasks from the database
$sql = "SELECT * FROM tasks ORDER BY due_date ASC";  // You can change the order here
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <!-- Include Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="text-white text-xl font-bold">Task Manager</a>
            <div>
                <a href="index.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Home</a>
                <a href="add_task.php" class="text-white px-4 py-2 hover:bg-blue-500 rounded">Add Task</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-center text-gray-700 mb-6">Task List</h1>
        
        <!-- Add New Task Button -->
        <div class="flex justify-center mb-4">
            <a href="add_task.php" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">Add New Task</a>
        </div>

        <!-- Task Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4">Task ID</th>
                        <th class="py-2 px-4">Task Description</th>
                        <th class="py-2 px-4">Due Date</th>
                        <th class="py-2 px-4">Status</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // If tasks exist in the database, display them in the table
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr class='border-t'>
                                    <td class='py-3 px-4 text-center'>{$row['id']}</td>
                                    <td class='py-3 px-4'>{$row['description']}</td>
                                    <td class='py-3 px-4 text-center'>{$row['due_date']}</td>
                                    <td class='py-3 px-4 text-center'>{$row['status']}</td>
                                    <td class='py-3 px-4 text-center'>
                                        <a href='edit_task.php?id={$row['id']}' class='text-blue-600 hover:text-blue-800'>Edit</a> | 
                                        <a href='delete_task.php?id={$row['id']}' class='text-red-600 hover:text-red-800'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center py-3 px-4'>No tasks found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-600 p-4 text-white text-center">
        <p>&copy; 2025 Task Management System | Designed by Your Name</p>
    </footer>

</body>
</html>

<?php
$conn->close();  // Close the database connection
?>
