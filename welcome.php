<?php
// Start a session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: login.php');
    exit();
}

// Include the header and footer files
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="welcome.css">
</head>

<body>

    <h2 class="welcome-title">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

    <?php if (!empty($_SESSION['profile_image'])) : ?>
        <img class="profile-image" src="<?php echo htmlspecialchars($_SESSION['profile_image']); ?>" alt="Profile Image">
    <?php endif; ?>

    <p class="thankyou">Thank you for registering!</p>

    <p class="logout"><a class="logout-link" href="logout.php">Logout</a></p>

    <footer class="footer">
        <!-- Add footer content here -->
    </footer>


</body>

</html>