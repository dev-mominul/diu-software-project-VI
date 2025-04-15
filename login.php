<?php
session_start();  // Start the session

// Check if the user is already logged in
if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    // Redirect based on user role
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/dashboard.php");  // Redirect admin to the dashboard
        exit();
    } else {
        header("Location: user/dashboard.php");  // Redirect user to the dashboard
        exit();
    }
}

include('includes/db.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Login successful, store user info in session
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];  // Store role in session
            $_SESSION['user_id'] = $row['id']; // Store user ID in session

            // Redirect to the appropriate page based on the user role
            if ($_SESSION['role'] == 'admin') {
                header("Location: admin/dashboard.php");  // Redirect admin to the dashboard
                exit();
            } else {
                header("Location: user/dashboard.php");  // Redirect user to the dashboard
                exit();
            }
        } else {
            $error_message = "Incorrect password!";
        }
    } else {
        $error_message = "User not found!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <!-- Main Content -->
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Login</h2>

        <!-- Success/Error Messages -->
        <?php if (isset($error_message)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-md mb-6">
                <p><strong>Error:</strong> <?= $error_message ?></p>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="login.php" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>

            <div class="text-center">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Login</button>
            </div>
        </form>

        <!-- Back to Site Link -->
        <div class="mt-4 text-center">
            <a href="./index.php" class="text-blue-500 hover:underline">Back to home</a>
        </div>
    </div>

</body>
</html>
