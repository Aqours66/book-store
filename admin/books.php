<?php
include 'dashboard.php';
include_once "book_functions.php";

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new book
    if (isset($_POST["add_book"])) {
        $title = $_POST["title"];
        $author = $_POST["author"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $image_url = $_FILES["profile_image"]["name"]; // Update to use the uploaded file name
        $stock_quantity = $_POST["stock_quantity"];
        $type = $_POST["type"];

        $message = createBook($conn, $title, $author, $description, $price, $image_url, $stock_quantity, $type);
    }

    // Update book
    if (isset($_POST["edit_book"])) {
        $book_id = $_POST["book_id"];
        $title = $_POST["title"];
        $author = $_POST["author"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $image_url = $_FILES["profile_image"]["name"]; // Update to use the uploaded file name
        $stock_quantity = $_POST["stock_quantity"];
        $type = $_POST["type"];

        $message = updateBook($conn, $book_id, $title, $author, $description, $price, $image_url, $stock_quantity, $type);
    }

    // Delete book
    if (isset($_POST["delete_book"])) {
        $book_id = $_POST["book_id"];
        $message = deleteBook($conn, $book_id);
    }
}

// Display books
$books = getBooks($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
    <link rel="stylesheet" href="../admin/css/books.css"> <!-- Link to your custom CSS styles -->
</head>

<body>
    <h1>Manage Books</h1>

    <!-- Display success/error message -->
    <?php if (isset($message)) : ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Add Book Form -->
    <button onclick="toggleForm('addBookForm')" class="add-button">Add Book</button>
    <form id="addBookForm" method="post" style="display: none;" enctype="multipart/form-data">
        Title: <input type="text" name="title" required><br>
        Author: <input type="text" name="author" required><br>
        Description: <textarea name="description"></textarea><br>
        Price: <input type="text" name="price" required><br>
        Profile Image: <input type="file" name="profile_image"><br>
        Stock Quantity: <input type="text" name="stock_quantity"><br>
        Type:
        <select name="type" required>
            <option value="">Select Type</option>
            <option value="Light Novel">Light Novel</option>
            <option value="Manga">Manga</option>
        </select><br>
        <input type="submit" name="add_book" value="Add Book">
    </form>


    <!-- Display Books -->
    <h2>Books</h2>
    <table border="1">
        <tr>
            <th>Book ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
            <th>Stock Quantity</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($books as $book) : ?>
            <tr>
                <td><?php echo $book['book_id']; ?></td>
                <td><?php echo $book['title']; ?></td>
                <td><?php echo $book['author']; ?></td>
                <td><?php echo $book['description']; ?></td>
                <td><?php echo $book['price']; ?></td>
                <td><img src="../admin/<?php echo $book['image_url']; ?>" alt="Book Image" style="width: 100px;"></td>
                <td><?php echo $book['stock_quantity']; ?></td>
                <td><?php echo $book['type']; ?></td>
                <td>
                    <!-- Edit Book Form -->
                    <button onclick="toggleForm('editBookForm_<?php echo $book['book_id']; ?>')">Edit</button>
                    <form id="editBookForm_<?php echo $book['book_id']; ?>" method="post" style="display: none;" enctype="multipart/form-data">
                        <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                        Title: <input type="text" name="title" value="<?php echo $book['title']; ?>" required><br>
                        Author: <input type="text" name="author" value="<?php echo $book['author']; ?>" required><br>
                        Description: <textarea name="description"><?php echo $book['description']; ?></textarea><br>
                        Price: <input type="text" name="price" value="<?php echo $book['price']; ?>" required><br>
                        Profile Image: <input type="file" name="profile_image"><br>
                        Stock Quantity: <input type="text" name="stock_quantity" value="<?php echo $book['stock_quantity']; ?>"><br>
                        Type:
                        <select name="type" required>
                            <option value="">Select Type</option>
                            <option value="Light Novel" <?php if ($book['type'] == "Light Novel") echo "selected"; ?>>Light Novel</option>
                            <option value="Manga" <?php if ($book['type'] == "Manga") echo "selected"; ?>>Manga</option>
                        </select><br>
                        <input type="submit" name="edit_book" value="Update Book">
                    </form>

                    <!-- Delete Book Button -->
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                        <input type="submit" name="delete_book" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <script>
        // Function to toggle form visibility
        function toggleForm(formId) {
            var form = document.getElementById(formId);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>

</html>