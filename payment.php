<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #141d26;
            color: #fff;
        }

        header {
            background-color: #1d2633;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin-left: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        main {
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            max-width: 300px;
        }

        label {
            margin-bottom: 10px;
        }

        select,
        input[type="submit"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            background-color: #fff;
            color: #333;
            cursor: pointer;
        }

        input[type="submit"] {
            background-color: #ff0045;
            color: #fff;
            border: none;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #ff506a;
        }

        /* CSS for centering the payment options form */
        .payment-options {
            display: flex;
            justify-content: center;
            align-items: center;

            /* Adjust height as needed */
            flex-direction: column;
        }
    </style>


</head>

<?php
session_start(); // Start session

include 'header.php';

// Check if the cart session variable exists and is not empty
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Display payment options
    echo "<main>";
    echo "<div class=\"payment-options\">";
    echo "<h2>Payment Options</h2>";
    echo "<form action=\"\" method=\"post\">";
    echo "<label for=\"payment_method\">Select Payment Method:</label>";
    echo "<select name=\"payment_method\" id=\"payment_method\">";
    echo "<option value=\"bank_transfer\">Bank Transfer</option>";
    echo "<option value=\"e_wallet\">E-Wallet</option>";
    echo "</select>";
    echo "<input type=\"submit\" name=\"submit\" value=\"Proceed to Payment\">";
    echo "</form>";
    echo "</div>";

    // Process selected payment method
    if (isset($_POST['submit'])) {
        $payment_method = $_POST['payment_method'];
        switch ($payment_method) {
            case 'bank_transfer':
                include 'bank_transfer.php';
                break;
            case 'e_wallet':
                include 'e_wallet.php';
                break;
            default:
                echo "Invalid payment method selected.";
        }
    }
    echo "</main>";
} else {
    // If the cart is empty, redirect to the homepage or display an error message
    header("Location: index.php");
    exit;
}

include 'footer.php';
?>