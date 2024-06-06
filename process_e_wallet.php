<?php
session_start(); // Start session

// Check if the payment method is e-wallet
if ($_POST['payment_method'] === 'e_wallet') {
    // Redirect to e-wallet payment instructions page
    header("Location: e_wallet.php");
    exit;
} else {
    // If the payment method is not e-wallet, redirect to the payment options page
    header("Location: payment.php");
    exit;
}
