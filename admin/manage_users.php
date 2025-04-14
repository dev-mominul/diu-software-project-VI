<?php
session_start();
include('../includes/db.php');
include('../includes/navbar.php');  // Include navbar for success message

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");  // Redirect to login if not admin
    exit();
}

// Fetch all users from the database including the 'name' field (Full Name)
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Check for user deletion success message
$task_deleted = isset($_GET['deleted']) && $_GET['deleted'] == 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Page Title -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold">Manage Users</h1>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto p-6 max-w-screen-xl">
        <!-- Success Message for User Deletion -->
        <?php if ($task_deleted): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-md mb-6">
                <p><i class="fas fa-check-circle mr-2"></i> The user has been deleted successfully!</p>
            </div>
        <?php endif; ?>

        <!-- User Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="py-3 px-6 border border-gray-300 text-left">Username</th>
                        <th class="py-3 px-6 border border-gray-300 text-left">Full Name</th>
                        <th class="py-3 px-6 border border-gray-300 text-left">Email</th>
                        <th class="py-3 px-6 border border-gray-300 text-left">Role</th>
                        <th class="py-3 px-6 border border-gray-300 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // If users exist in the database, display them in the table
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr class='border-t'>
                                    <td class='py-3 px-6 text-left border border-gray-300'>{$row['username']}</td>
                                    <td class='py-3 px-6 text-left border border-gray-300'>{$row['name']}</td> <!-- Full Name -->
                                    <td class='py-3 px-6 text-left border border-gray-300'>{$row['email']}</td>
                                    <td class='py-3 px-6 text-left border border-gray-300'>{$row['role']}</td>
                                    <td class='py-3 px-6 text-left border border-gray-300'>
                                        <a href='edit_user.php?id={$row['id']}' class='text-blue-600 hover:text-blue-800'>Edit</a> | 
                                        <a href='delete_user.php?delete={$row['id']}' class='text-red-600 hover:text-red-800'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center py-3 px-4'>No users found.</td></tr>";
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
