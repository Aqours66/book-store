<?php
session_start();
include 'header.php'; // Include header
// Include database connection
include_once "db_connection.php";

// Check if the search query is submitted
if (isset($_GET['query'])) {
    // Sanitize the search query
    $search_query = mysqli_real_escape_string($conn, $_GET['query']);

    // Perform the search query
    $sql = "SELECT * FROM books WHERE title LIKE '%$search_query%'";
    $result = mysqli_query($conn, $sql);

    // Check if any results are found
    if (mysqli_num_rows($result) > 0) {
        // Display search results
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div style='background-color: #1d2633; color: #fff; padding: 15px; margin-bottom: 10px; border-radius: 5px;'>";
            echo "<h3 style='margin-top: 0; margin-bottom: 5px;'><a href='product.php?book_id=" . $row['book_id'] . "' style='color: #fff;'>" . $row['title'] . "</a></h3>";
            echo "<p style='margin: 0; margin-bottom: 5px;'><strong>Author:</strong> " . $row['author'] . "</p>";
            echo "<p style='margin: 0; margin-bottom: 5px;'><strong>Description:</strong> " . $row['description'] . "</p>";
            echo "<p style='margin: 0; margin-bottom: 5px;'><strong>Price:</strong> $" . $row['price'] . "</p>";
            echo "</div>";
        }
    } else {
        // Display no results message
        echo "<p style='color: #fff;'>No results found.</p>";
    }
} else {
    // Redirect back to the homepage if no search query is provided
    header("Location: index.php");
    exit;
}
