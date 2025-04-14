<?php
session_start();
include('../includes/db.php');

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");  // Redirect to login if not admin
    exit();
}

// Fetch all tasks from the database along with assigned users
$sql = "SELECT tasks.*, users.username AS assigned_user FROM tasks LEFT JOIN users ON tasks.user_id = users.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tasks</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Include Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-center text-gray-700 mb-6">Manage Tasks</h1>

        <!-- Task Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4">Task ID</th>
                        <th class="py-2 px-4">Task Description</th>
                        <th class="py-2 px-4">Due Date</th>
                        <th class="py-2 px-4">Status</th>
                        <th class="py-2 px-4">Assigned User</th>
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
                                    <td class='py-3 px-4 text-center'>{$row['assigned_user']}</td>
                                    <td class='py-3 px-4 text-center'>
                                        <a href='edit_task.php?id={$row['id']}' class='text-blue-600 hover:text-blue-800'>Edit</a> | 
                                        <a href='delete_task.php?id={$row['id']}' class='text-red-600 hover:text-red-800'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center py-3 px-4'>No tasks found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include('../includes/footer.php'); ?>

</body>
</html>

<?php
$conn->close();
?>
