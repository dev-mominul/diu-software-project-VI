<?php
session_start();  // Start the session

include('includes/db.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if user exists and password matches
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Login successful, store user info in session
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];  // Store role in session
            $_SESSION['user_id'] = $row['id']; // Store user ID in session

            // Redirect to the appropriate page based on the user role
            if ($_SESSION['role'] == 'admin') {
                header("Location: admin_dashboard.php");  // Redirect admin to the dashboard
            } else {
                header("Location: index.php");  // Redirect user to the task list page
            }
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "User not found!";
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
<body class="bg-gray-100">

    <!-- Include Navbar -->
    <?php include('includes/navbar.php'); ?>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-center text-gray-700 mb-6">Login</h1>

        <div class="max-w-lg mx-auto bg-white p-8 shadow-lg rounded-lg">
            <form action="login.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" name="username" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">Login</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include('includes/footer.php'); ?>

</body>
</html>
