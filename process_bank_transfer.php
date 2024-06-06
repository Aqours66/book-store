<?php
session_start(); // Start session

// Check if the payment method is bank transfer
if ($_POST['payment_method'] === 'bank_transfer') {
    // Redirect to bank transfer instructions page
    header("Location: bank_transfer.php");
    exit;
} else {
    // If the payment method is not bank transfer, redirect to the payment options page
    header("Location: payment.php");
    exit;
}
