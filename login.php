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
<body class="bg-gray-100">

    <!-- Include Navbar -->
    <?php include('includes/navbar.php'); ?>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-center text-gray-700 mb-6">Login</h1>

        <div class="max-w-lg mx-auto bg-white p-8 shadow-lg rounded-lg">
            <?php if (isset($error_message)): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded-md mb-6">
                    <p><?= $error_message ?></p>
                </div>
            <?php endif; ?>

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
