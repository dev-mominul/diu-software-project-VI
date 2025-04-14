<?php
include('includes/db.php');

// Register a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash the password
    $role = 'user';  // Default role is 'user'

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
        header("Location: login.php");  // Redirect to login page
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-center text-gray-700 mb-6">Register</h1>

        <div class="max-w-lg mx-auto bg-white p-8 shadow-lg rounded-lg">
            <form action="register.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" name="username" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" class="w-full p-3 mt-2 border border-gray-300 rounded" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">Register</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include('includes/footer.php'); ?>

</body>
</html>
