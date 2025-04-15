<?php
// Start the session at the top of the page
session_start();

// Include database connection
include('includes/db.php');

// Register a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];  // Full Name
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash the password
    $role = 'user';  // Default role is 'user'

    // Check if the username or email already exists in the database
    $sql_check_user = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql_check_user);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If username or email exists, show error message
        $error_message = "Username or Email is already taken. Please choose a different one.";
    } else {
        // If no duplicate found, insert the new user into the database
        $sql = "INSERT INTO users (name, username, email, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $username, $email, $password, $role);

        if ($stmt->execute()) {
            // Registration successful, store user info in session
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            $_SESSION['user_id'] = $conn->insert_id; // Store user ID in session

            // Redirect to user dashboard
            header("Location: user/dashboard.php");
            exit();  // Ensure no further code is executed after the redirection
        } else {
            $error_message = "Error: " . $stmt->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Include Navbar -->
    <?php include('includes/navbar.php'); ?>

    <!-- Main Content -->
    <div class="container mx-auto p-6 max-w-screen-xl">
        <!-- Top Title (Spacing as per other pages) -->
        <header class="text-center pt-16 pb-8">
            <h1 class="text-3xl font-semibold text-gray-700">Register</h1>
        </header>

        <!-- Registration Form -->
        <div class="max-w-lg mx-auto bg-white p-8 shadow-lg rounded-lg">
            <!-- Show error message if username or email exists -->
            <?php if (isset($error_message)): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded-md mb-6">
                    <p><strong>Error:</strong> <?= $error_message ?></p>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <!-- Full Name Field -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Full Name</label>
                    <input type="text" name="name" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <!-- Username Field -->
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" name="username" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <!-- Email Field -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">Register</button>
                </div>
            </form>
        </div>
    </div>


</body>
</html>
