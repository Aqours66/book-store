<?php
session_start(); // Start session

// Check if the cart session variable exists and is not empty
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Define variables and initialize with empty values
    $e_wallet_username = $e_wallet_password = "";
    $e_wallet_username_err = $e_wallet_password_err = "";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
        // Validate e-wallet username
        if (empty(trim($_POST["e_wallet_username"]))) {
            $e_wallet_username_err = "Please enter your e-wallet username.";
        } else {
            $e_wallet_username = trim($_POST["e_wallet_username"]);
        }

        // Validate e-wallet password
        if (empty(trim($_POST["e_wallet_password"]))) {
            $e_wallet_password_err = "Please enter your e-wallet password.";
        } else {
            $e_wallet_password = trim($_POST["e_wallet_password"]);
        }

        // Check input errors before processing the payment
        if (empty($e_wallet_username_err) && empty($e_wallet_password_err)) {
            // Process the e-wallet payment
            // This is just a placeholder, you would typically handle the payment process here
            // For demonstration purposes, we'll simply display a success message
            echo "<h2 style=\"text-align: center;\">E-Wallet Payment Successful</h2>";
            echo "<p style=\"text-align: center;\">Thank you for your payment using e-wallet.</p>";
        }
    }
?>

    <div style="max-width: 400px; margin: 0 auto; padding: 20px; background-color: #1d2633; color: #fff; border-radius: 5px;">
        <h2 style="text-align: center; margin-bottom: 20px;">E-Wallet Payment</h2>
        <p style="text-align: center;">Please enter your e-wallet credentials to confirm the payment.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div style="margin-bottom: 10px;">
                <label for="e_wallet_username">Username:</label>
                <input type="text" name="e_wallet_username" id="e_wallet_username" value="<?php echo htmlspecialchars($e_wallet_username); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #fff; color: #333; box-sizing: border-box;">
                <span class="error"><?php echo $e_wallet_username_err; ?></span>
            </div>
            <div style="margin-bottom: 10px;">
                <label for="e_wallet_password">Password:</label>
                <input type="password" name="e_wallet_password" id="e_wallet_password" value="<?php echo htmlspecialchars($e_wallet_password); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #fff; color: #333; box-sizing: border-box;">
                <span class="error"><?php echo $e_wallet_password_err; ?></span>
            </div>
            <div style="margin-bottom: 10px;">
                <input type="submit" name="confirm" value="Confirm Payment" style="width: 100%; padding: 10px; border: none; border-radius: 5px; background-color: #ff0045; color: #fff; cursor: pointer; transition: background-color 0.3s ease;">
            </div>
        </form>
    </div>

<?php
} else {
    // If the cart is empty, redirect to the homepage or display an error message
    header("Location: index.php");
    exit;
}
?>