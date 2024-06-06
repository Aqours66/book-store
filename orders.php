// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Place new order
if (isset($_POST["place_order"])) {
// Process order and update stock quantity
foreach ($_SESSION["cart"] as $item) {
$book_id = $item["book_id"];
$quantity = $item["quantity"];
// Reduce stock quantity
updateStockQuantity($conn, $book_id, $quantity);
}
// Clear the cart after placing the order
$_SESSION["cart"] = array();
// Other order processing logic...
}
}

// Function to update stock quantity
function updateStockQuantity($conn, $book_id, $quantity)
{
// Retrieve current stock quantity
$sql = "SELECT stock_quantity FROM books WHERE book_id = $book_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
$current_quantity = $row["stock_quantity"];
// Update stock quantity
$new_quantity = $current_quantity - $quantity;
$update_sql = "UPDATE books SET stock_quantity = $new_quantity WHERE book_id = $book_id";
$conn->query($update_sql);
}
}