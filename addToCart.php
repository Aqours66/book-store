<?php
session_start(); // Start session

// Check if the form is submitted and the user is logged in
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    // Include database connection file
    include_once "db_connection.php";

    // Retrieve product details from the form
    $book_id = $_POST['book_id'];
    $quantity = $_POST['quantity'];

    // Fetch the book details from the database
    $sql = "SELECT * FROM books WHERE book_id = $book_id";
    $result = $conn->query($sql);

    // Check if the book exists
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();

        // Check if the cart session variable exists
        if (!isset($_SESSION['cart'])) {
            // If the cart doesn't exist, initialize it as an empty array
            $_SESSION['cart'] = array();
        }

        // Check if the product is already in the cart
        if (array_key_exists($book_id, $_SESSION['cart'])) {
            // If the product is already in the cart, update the quantity
            $_SESSION['cart'][$book_id]['quantity'] += $quantity;
        } else {
            // If the product is not in the cart, add it
            $_SESSION['cart'][$book_id] = array(
                'quantity' => $quantity,
                'title' => $book['title'],
                'price' => $book['price']
                // You can add more product details here if needed
            );
        }
    }
}

// Redirect the user back to the product detail page
header("Location: product.php?id=" . $book_id);
exit();
