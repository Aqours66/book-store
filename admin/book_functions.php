<?php
// book_functions.php

include_once "../db_connection.php";

// CRUD operations for books

// Create operation
// Create operation
function createBook($conn, $title, $author, $description, $price, $image_url, $stock_quantity, $type)
{
    // Handle file upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        // File was successfully uploaded
        $tmp_name = $_FILES["profile_image"]["tmp_name"];
        $name = basename($_FILES["profile_image"]["name"]);
        $target_dir = "uploads/";
        $target_file = $target_dir . $name;

        // Move uploaded file to desired directory
        if (move_uploaded_file($tmp_name, $target_file)) {
            // File upload successful
            $image_url = $target_file; // Update $image_url with the path of the uploaded file
        } else {
            // File upload failed
            return "Error uploading file.";
        }
    }

    // Now, proceed with the SQL query
    $sql = "INSERT INTO books (title, author, description, price, image_url, stock_quantity, type) VALUES ('$title', '$author', '$description', $price, '$image_url', $stock_quantity, '$type')";
    if ($conn->query($sql) === TRUE) {
        return "Book added successfully!";
    } else {
        return "Error adding book: " . $conn->error;
    }
}


// Read operation
function getBooks($conn)
{
    $sql = "SELECT * FROM books";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Update operation
function updateBook($conn, $book_id, $title, $author, $description, $price, $image_url, $stock_quantity, $type)
{
    // Check if a new file has been uploaded
    if ($_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["profile_image"]["tmp_name"];
        $name = basename($_FILES["profile_image"]["name"]);
        $target_dir = "uploads/";
        $target_file = $target_dir . $name;

        // Move uploaded file to desired directory
        if (move_uploaded_file($tmp_name, $target_file)) {
            // File upload successful
            $image_url = $target_file;
        } else {
            // File upload failed
            return "Error uploading file.";
        }
    }

    $sql = "UPDATE books SET title='$title', author='$author', description='$description', price=$price, image_url='$image_url', stock_quantity=$stock_quantity, type='$type' WHERE book_id=$book_id";
    if ($conn->query($sql) === TRUE) {
        return "Book updated successfully!";
    } else {
        return "Error updating book: " . $conn->error;
    }
}

// Delete operation
function deleteBook($conn, $book_id)
{
    $sql = "DELETE FROM books WHERE book_id=$book_id";
    if ($conn->query($sql) === TRUE) {
        return "Book deleted successfully!";
    } else {
        return "Error deleting book: " . $conn->error;
    }
}


// Create operation
//--function createBook($conn, $title, $author, $description, $price, $image_url, $stock_quantity, $type)
//{
   // $sql = "INSERT INTO books (title, author, description, price, image_url, stock_quantity, type) VALUES ('$title', '$author', '$description', $price, '$image_url', $stock_quantity, '$type')";
    //if ($conn->query($sql) === TRUE) {
    //    return "Book added successfully!";
    //} else {
   //     return "Error adding book: " . $conn->error;
   // }
//}
