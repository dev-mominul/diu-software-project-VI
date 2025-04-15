<?php 
// Start session
session_start();

// Include database connection
include('includes/db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <!-- Include Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Include Navbar -->
    <?php include('includes/navbar.php'); ?>

<!-- Hero Section with Full Width and No Gap -->
<section class="bg-blue-600 py-20">
    <div class="container mx-auto text-center">
        <h1 class="text-4xl font-bold text-white mb-4">Welcome to the Task Manager</h1>
        <p class="text-lg text-white mb-8">Efficiently manage your tasks, set deadlines, and keep track of your progress with ease.</p>
        <a href="#how-it-works" class="bg-white text-blue-600 py-2 px-6 rounded-full text-lg font-semibold hover:bg-gray-200 transition duration-300">Learn How It Works</a>
    </div>
</section>


    <!-- About This Task Manager -->
    <section class="py-16 bg-gray-50" id="about">
        <div class="container mx-auto px-6 text-center max-w-screen-xl">
            <h2 class="text-3xl font-semibold text-gray-700 mb-8">About This Task Manager</h2>
            <p class="text-lg text-gray-600 mb-6">
                This Task Manager is a personal project developed as part of CSE336: Software Project VI for course completion. It helps users efficiently manage their daily tasks by allowing them to add, track, and update tasks seamlessly.
            </p>
        </div>
    </section>

    <!-- How the Task Manager Works -->
    <section id="how-it-works" class="py-16 bg-white">
        <div class="container mx-auto px-6 text-center max-w-screen-xl">
            <h2 class="text-3xl font-semibold text-gray-700 mb-8">How It Works</h2>
            <p class="text-lg text-gray-600 mb-6">
                This Task Manager system is easy to use and provides powerful features to keep your tasks on track. Here's how it works:
            </p>

            <div class="flex justify-center mb-8">
                <div class="w-1/3 p-4">
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">1. Add New Tasks</h3>
                        <p class="text-gray-600">Create tasks with descriptions, deadlines, and priority levels. Organize them based on your needs.</p>
                    </div>
                </div>
                <div class="w-1/3 p-4">
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">2. Track & Organize Tasks</h3>
                        <p class="text-gray-600">View your tasks in different statuses, such as "In Progress", "Upcoming", or "Completed". Keep track of everything effortlessly.</p>
                    </div>
                </div>
                <div class="w-1/3 p-4">
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">3. Stay on Top of Deadlines</h3>
                        <p class="text-gray-600">Set due dates and manage tasks effectively. The Task Manager ensures that you stay organized and complete your work on time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Features -->
    <section id="key-features" class="py-16 bg-gray-50">
        <div class="container mx-auto px-6 text-center max-w-screen-xl">
            <h2 class="text-3xl font-semibold text-gray-700 mb-8">Key Features</h2>
            <p class="text-lg text-gray-600 mb-6">
                This Task Manager offers powerful features for both <b>admins</b> and <b>users</b>, each with distinct roles and capabilities.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                <!-- Admin Features -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Admin Features</h3>
                    <ul class="list-disc list-inside text-gray-600">
                        <li>Has dedicated admin dashboard</li>
                        <li>Can access & manage all tasks</li>
                        <li>Can assign tasks to users</li>
                        <li>Manage users and roles</li>
                    </ul>
                </div>

                <!-- User Features -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">User Features</h3>
                    <ul class="list-disc list-inside text-gray-600">
                        <li>Has dedicated user dashboard</li>
                        <li>Can access only assigned tasks</li>
                        <li>Track status and due dates</li>
                        <li>Update tasks info and status</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action (CTA) -->
    <section class="py-16 text-center bg-blue-600 text-white">
        <h2 class="text-3xl font-semibold mb-6">Get Started with the Task Manager</h2>
        <p class="text-lg mb-6">Sign up today and start organizing your tasks like a pro!</p>
        <a href="register.php" class="bg-white text-blue-600 px-6 py-3 rounded-full text-xl font-semibold hover:bg-gray-200">Sign Up</a>
    </section>

    <!-- Include Footer -->
    <?php include('includes/footer.php'); ?>

</body>
</html>

<?php
$conn->close();  // Close the database connection
?>
