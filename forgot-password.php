<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Include your CSS file -->
    <link rel="stylesheet" href="login.css">
</head>

<?php include 'header.php'; ?>

<body>
    <h2 class="login-title">Forgot Password</h2>
    <form class="login-form" action="reset-password.php" method="post">
        <div class="form-group">
            <label class="login-label">Email</label>
            <input type="email" name="email" class="login-input" required>
        </div>
        <div class="form-group">
            <input type="submit" class="login-button" value="Reset Password">
        </div>
        <p>Remember your password? <a href="login.php">Login here</a>.</p>
    </form>

</body>

</html>

<?php include 'footer.php'; ?>