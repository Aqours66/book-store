<?php
session_start(); // Start session

include 'header.php';

// Function to handle updating cart quantities
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $book_id = intval($_POST['book_id']);
    if ($_POST['action'] === 'update' && isset($_POST['quantity'])) {
        $quantity = intval($_POST['quantity']);
        if ($quantity > 0) {
            $_SESSION['cart'][$book_id]['quantity'] = $quantity;
        } else {
            unset($_SESSION['cart'][$book_id]); // Remove item if quantity is set to zero or less
        }
    } elseif ($_POST['action'] === 'delete') {
        unset($_SESSION['cart'][$book_id]); // Remove item
    }
}

// Check if the cart session variable exists
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shopping Cart</title>
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

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            table,
            th,
            td {
                border: 1px solid #ccc;
                padding: 10px;
                text-align: left;
            }

            th {
                background-color: #1d2633;
            }

            td {
                background-color: #1d2633;
            }

            tfoot td {
                font-size: 18px;
                font-weight: bold;
            }

            .total-price {
                text-align: right;
            }

            .empty-cart-message {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 80vh;
                font-size: 24px;
                color: #ff0045;
            }

            .action-buttons {
                display: flex;
                gap: 10px;
            }

            .btn {
                padding: 5px 10px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .btn-update {
                background-color: #4caf50;
                color: white;
            }

            .btn-delete {
                background-color: #f44336;
                color: white;
            }

            .confirm-button {
                background-color: #ff0045;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                text-decoration: none;
                margin-top: 20px;
            }

            .confirm-button:hover {
                background-color: #ff506a;
            }
        </style>
    </head>

    <body>
        <main>
            <h1>Shopping Cart</h1>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_price = 0;
                    foreach ($_SESSION['cart'] as $book_id => $item) {
                        $total = $item['quantity'] * $item['price'];
                        $total_price += $total;
                    ?>
                        <tr>
                            <td><?php echo $item['title']; ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="99">
                                    <input type="hidden" name="action" value="update">
                                    <button type="submit" class="btn btn-update">Update</button>
                                </form>
                            </td>
                            <td>$<?php echo $item['price']; ?></td>
                            <td>$<?php echo number_format($total, 2); ?></td>
                            <td>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="total-price">Total:</td>
                        <td>$<?php echo number_format($total_price, 2); ?></td>
                    </tr>
                </tfoot>
            </table>
            <a href="payment.php" class="confirm-button">Confirm and Pay</a>
            <!-- Display payment options -->

        </main>

        <?php include 'footer.php'; ?>
    </body>

    </html>

<?php
} else {
    echo "<div style='display: flex; align-items: center; justify-content: center; height: 80vh; font-size: 24px; color: #ff0045;'>Your cart is empty.</div>";
}
?>