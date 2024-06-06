<?php
session_start(); // Start session

// Check if the cart session variable exists and is not empty
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Define variables and initialize with empty values
    $name = $email = $phone = $account_name = $account_number = $bank_name = "";
    $name_err = $email_err = $phone_err = $account_name_err = $account_number_err = $bank_name_err = "";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
        // Validate name
        if (empty(trim($_POST["name"]))) {
            $name_err = "Please enter your name.";
        } else {
            $name = trim($_POST["name"]);
        }

        // Validate email
        if (empty(trim($_POST["email"]))) {
            $email_err = "Please enter your email.";
        } else {
            $email = trim($_POST["email"]);
        }

        // Validate phone
        if (empty(trim($_POST["phone"]))) {
            $phone_err = "Please enter your phone number.";
        } else {
            $phone = trim($_POST["phone"]);
        }

        // Validate account name
        if (empty(trim($_POST["account_name"]))) {
            $account_name_err = "Please enter your account name.";
        } else {
            $account_name = trim($_POST["account_name"]);
        }

        // Validate account number
        if (empty(trim($_POST["account_number"]))) {
            $account_number_err = "Please enter your account number.";
        } else {
            $account_number = trim($_POST["account_number"]);
        }

        // Validate bank name
        if (empty(trim($_POST["bank_name"]))) {
            $bank_name_err = "Please enter your bank name.";
        } else {
            $bank_name = trim($_POST["bank_name"]);
        }

        // Check input errors before processing the payment
        if (empty($name_err) && empty($email_err) && empty($phone_err) && empty($account_name_err) && empty($account_number_err) && empty($bank_name_err)) {
            // Process the bank transfer payment
            // This is just a placeholder, you would typically handle the payment process here
            // For demonstration purposes, we'll simply display a success message
            echo "<h2 style=\"text-align: center;\">Bank Transfer Payment Successful</h2>";
            echo "<p style=\"text-align: center;\">Thank you, $name, for your payment.</p>";
        }
    }
?>

    <div style="max-width: 400px; margin: 0 auto; padding: 20px; background-color: #1d2633; color: #fff; border-radius: 5px;">
        <h2 style="text-align: center; margin-bottom: 20px;">Bank Transfer Payment</h2>
        <p>Please fill in your details and confirm the payment.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div style="margin-bottom: 10px;">
                <label for="name">Full Name:</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #fff; color: #333; box-sizing: border-box;">
                <span class="error"><?php echo $name_err; ?></span>
            </div>
            <div style="margin-bottom: 10px;">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #fff; color: #333; box-sizing: border-box;">
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <div style="margin-bottom: 10px;">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($phone); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #fff; color: #333; box-sizing: border-box;">
                <span class="error"><?php echo $phone_err; ?></span>
            </div>
            <div style="margin-bottom: 10px;">
                <label for="account_name">Account Name:</label>
                <input type="text" name="account_name" id="account_name" value="<?php echo htmlspecialchars($account_name); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #fff; color: #333; box-sizing: border-box;">
                <span class="error"><?php echo $account_name_err; ?></span>
            </div>
            <div style="margin-bottom: 10px;">
                <label for="account_number">Account Number:</label>
                <input type="text" name="account_number" id="account_number" value="<?php echo htmlspecialchars($account_number); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #fff; color: #333; box-sizing: border-box;">
                <span class="error"><?php echo $account_number_err; ?></span>
            </div>
            <div style="margin-bottom: 10px;">
                <label for="bank_name">Bank Name:</label>
                <input type="text" name="bank_name" id="bank_name" value="<?php echo htmlspecialchars($bank_name); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #fff; color: #333; box-sizing: border-box;">
                <span class="error"><?php echo $bank_name_err; ?></span>
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