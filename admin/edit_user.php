<?php
session_start();
include('../includes/db.php');
include('../includes/navbar.php');  // Include navbar for success message

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");  // Redirect to login if not admin
    exit();
}

// Fetch user details from the database based on the ID
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update user details in the database
    $update_sql = "UPDATE users SET username='$username', email='$email', role='$role' WHERE id=$user_id";

    if ($conn->query($update_sql) === TRUE) {
        $success_message = "The user has been successfully updated.";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Include Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Page Title -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold">Edit User</h1>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto p-6 max-w-screen-xl">
        <!-- Success and Error Messages -->
        <?php if (isset($success_message)): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-md mb-6">
                <p><i class="fas fa-check-circle mr-2"></i> <?= $success_message ?></p>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-md mb-6">
                <p><i class="fas fa-exclamation-triangle mr-2"></i> <?= $error_message ?></p>
            </div>
        <?php endif; ?>

        <!-- Edit User Form -->
        <div class="max-w-lg mx-auto bg-white p-8 shadow-lg rounded-lg">
            <form action="edit_user.php?id=<?= $user['id'] ?>" method="POST">
                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" name="username" value="<?= $user['username'] ?>" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" value="<?= $user['email'] ?>" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label for="role" class="block text-gray-700">Role</label>
                    <select name="role" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include('../includes/footer.php'); ?>

</body>
</html>
