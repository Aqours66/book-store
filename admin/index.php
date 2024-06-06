<?php
session_start();

// Check if admin username is set in session
if (isset($_SESSION['admin_username'])) {
    $admin_username = $_SESSION['admin_username'];
    // Redirect to the admin dashboard
    header("Location: dashboard.php");
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../admin/css/index.css">
</head>

<body>
    <div class="dashboard-container">
        <h2>Welcome to Admin Portal!</h2>
        <p>Please choose an option:</p>
        <ul>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </div>
</body>

</html>