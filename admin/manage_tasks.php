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

// Check for task deletion success message
$task_deleted = isset($_GET['deleted']) && $_GET['deleted'] == 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tasks</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">

    <!-- Include Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Page Title -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold">Manage Tasks</h1>
    </header>

    <div class="container mx-auto p-6 max-w-screen-xl">
        <!-- Success Message for Task Deletion -->
        <?php if ($task_deleted): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-md mb-6">
                <p><i class="fas fa-check-circle mr-2"></i> Task Deleted Successfully!</p>
            </div>
        <?php endif; ?>

        <!-- Task Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="py-3 px-6 border border-gray-300 text-left">Task ID</th>
                        <th class="py-3 px-6 border border-gray-300 text-left">Title</th>
                        <th class="py-3 px-6 border border-gray-300 text-left">Due Date</th>
                        <th class="py-3 px-6 border border-gray-300 text-left">Status</th>
                        <th class="py-3 px-6 border border-gray-300 text-left">Assigned User</th>
                        <th class="py-3 px-6 border border-gray-300 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // If tasks exist in the database, display them in the table
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            // Determine task status color and icon
                            $status_color = '';
                            $status_icon = '';
                            switch ($row['status']) {
                                case 'in-progress':
                                    $status_color = 'text-orange-500';
                                    $status_icon = 'fas fa-spinner';
                                    break;
                                case 'completed':
                                    $status_color = 'text-green-500';
                                    $status_icon = 'fas fa-check-circle';
                                    break;
                                case 'pending':
                                    $status_color = 'text-blue-500';
                                    $status_icon = 'fas fa-clock';
                                    break;
                            }

                            echo "<tr class='border-t'>
                                    <td class='py-3 px-6 text-left border border-gray-300'>{$row['id']}</td>
                                    <td class='py-3 px-6 text-left border border-gray-300'>{$row['title']}</td>
                                    <td class='py-3 px-6 text-left border border-gray-300'>{$row['due_date']}</td>
                                    <td class='py-3 px-6 text-left border border-gray-300'>
                                        <span class='inline-flex items-center'>
                                            <i class='$status_icon mr-2 $status_color'></i> {$row['status']}
                                        </span>
                                    </td>
                                    <td class='py-3 px-6 text-left border border-gray-300'>{$row['assigned_user']}</td>
                                    <td class='py-3 px-6 text-left border border-gray-300'>
                                        <a href='edit_task.php?id={$row['id']}' class='text-blue-600 hover:text-blue-800'>Edit</a> | 
                                        <a href='delete_task.php?id={$row['id']}&delete=1' class='text-red-600 hover:text-red-800'>Delete</a>
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

</body>
</html>

<?php
$conn->close();
?>
