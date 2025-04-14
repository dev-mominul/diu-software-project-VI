<?php
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO tasks (description, due_date, status) VALUES ('$description', '$due_date', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "New task added successfully";
        header("Location: index.php"); // Redirect to homepage
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
