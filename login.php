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
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
