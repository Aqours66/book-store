<?php
$email_err = $password_err = $confirm_password_err = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (isset($_POST["password"]) && !empty(trim($_POST["password"]))) {
        $password = trim($_POST["password"]);
    } else {
        $password_err = "Please enter a password.";
    }

    // Validate confirm password
    if (isset($_POST["confirm_password"]) && !empty(trim($_POST["confirm_password"]))) {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($password != $confirm_password) {
            $confirm_password_err = "Passwords did not match.";
        }
    } else {
        $confirm_password_err = "Please confirm password.";
    }

    // Check for input errors before updating the database
    if (empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        // Include the database connection file
        require_once 'db_connection.php';

        // Prepare a select statement
        $sql = "SELECT user_id, username FROM users WHERE email = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if email exists, if yes then update the password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($user_id, $username);
                    if ($stmt->fetch()) {
                        // Hash password
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);

                        // Update the password in the database
                        $sql = "UPDATE users SET password_hash = ? WHERE user_id = ?";
                        if ($stmt2 = $conn->prepare($sql)) {
                            // Bind variables to the prepared statement as parameters
                            $stmt2->bind_param("si", $param_password_hash, $param_user_id);

                            // Set parameters
                            $param_password_hash = $password_hash;
                            $param_user_id = $user_id;

                            // Attempt to execute the prepared statement
                            if ($stmt2->execute()) {
                                // Password updated successfully, redirect to login page
                                header("location: login.php");
                            } else {
                                echo "Oops! Something went wrong. Please try again later.";
                            }
                        }
                        // Close statement
                        $stmt2->close();
                    }
                } else {
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            $stmt->close();
        }
        // Close connection
        $conn->close();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Include the external CSS file -->
    <link rel="stylesheet" href="login.css">
</head>
<?php include 'header.php'; ?>

<body>
    <h2 class="login-title">Reset Password</h2>
    <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label class="login-label">Email</label>
            <input type="email" name="email" class="login-input" value="<?php echo $email; ?>">
            <span class="login-help-block"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group">
            <label class="login-label">New Password</label>
            <input type="password" name="password" class="login-input" value="<?php echo $password; ?>">
            <span class="login-help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <label class="login-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="login-input" value="<?php echo $confirm_password; ?>">
            <span class="login-help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="login-button" value="Reset Password">
        </div>
        <p class="login-reminder">Remember your password? <a href="login.php">Login here</a>.</p>
    </form>


</body>





</html>
<?php include 'footer.php'; ?>