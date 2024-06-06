<head>
    <style>
        /* Style for manga books */
        .manga-books-container {
            display: flex;
            flex-wrap: wrap;
        }

        .manga-book {
            width: 25%;
            /* Adjust the width as needed */
            display: flex;
            margin-bottom: 20px;
        }

        .manga-book img {
            width: 100px;
            height: 100px;
            margin-right: 20px;
        }

        .manga-details {
            flex-grow: 1;
        }

        .manga-details h3 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .manga-details p {
            margin: 0;
            margin-bottom: 5px;
        }
    </style>



</head>

<?php
session_start();
include 'header.php'; // Include header
include_once "db_connection.php";

// Database connection code here

// Query to select all manga books
$sql = "SELECT * FROM books WHERE type = 'Manga'";
$result = mysqli_query($conn, $sql);


// Check if there are manga books available
if (mysqli_num_rows($result) > 0) {
    echo "<div class='manga-books-container'>"; // Opening manga-books-container
    // Output manga books
    while ($row = mysqli_fetch_assoc($result)) {
        // Wrap the entire manga book container in an anchor tag
        echo "<a href='product.php?book_id=" . $row['book_id'] . "' style='text-decoration: none; color: inherit;'>";
        echo "<div class='manga-book'>";
        echo "<img src='" . $row['image_url'] . "' alt='" . $row['title'] . "' style='width:100px;height:100px;'>";
        echo "<div class='manga-details'>";
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p><strong>Author:</strong> " . $row['author'] . "</p>";
        echo "<p><strong>Description:</strong> " . $row['description'] . "</p>";
        echo "<p><strong>Price:</strong> $" . $row['price'] . "</p>";
        echo "</div>"; // Close manga-details
        echo "</div>"; // Close manga-book
        echo "</a>"; // Close anchor tag
    }
    echo "</div>"; // Closing manga-books-container
} else {
    echo "<p>No manga books available.</p>";
}

include 'footer.php'; // Include footer
?>