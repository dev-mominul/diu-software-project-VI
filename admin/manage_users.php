<?php
session_start();
include('../includes/db.php');
include('../includes/navbar.php');  // Include navbar for success message

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");  // Redirect to login if not admin
    exit();
}

// Delete user
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id = $user_id";

    if ($conn->query($sql) === TRUE) {
        show_success_message("The user has been deleted successfully.");
        header("Location: manage_users.php");  // Redirect to user management page
        exit();  // Make sure the script stops executing after redirect
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all users from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
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

    <!-- Include Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-center text-gray-700 mb-6">Manage Users</h1>

        <!-- User Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4">User ID</th>
                        <th class="py-2 px-4">Username</th>
                        <th class="py-2 px-4">Email</th>
                        <th class="py-2 px-4">Role</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // If users exist in the database, display them in the table
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr class='border-t'>
                                    <td class='py-3 px-4 text-center'>{$row['id']}</td>
                                    <td class='py-3 px-4'>{$row['username']}</td>
                                    <td class='py-3 px-4'>{$row['email']}</td>
                                    <td class='py-3 px-4 text-center'>{$row['role']}</td>
                                    <td class='py-3 px-4 text-center'>
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

    <!-- Include Footer -->
    <?php include('../includes/footer.php'); ?>

</body>
</html>

<?php
$conn->close();
?>
