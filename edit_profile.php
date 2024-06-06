<?php

include 'header.php';
// Start the session
session_start();

// Include the database connection file
require_once 'db_connection.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form input data
    $new_username = $_POST['new_username'];
    $new_email = $_POST['new_email'];
    $new_password = $_POST['new_password'];

    // Check if a new profile image was uploaded
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        // Process the uploaded file
        $image_name = $_FILES['profile_image']['name'];
        $tmp_name = $_FILES['profile_image']['tmp_name'];
        $image_path = 'uploads/' . $image_name;

        // Move the uploaded file to a new location
        if (move_uploaded_file($tmp_name, $image_path)) {
            // Update the user's profile image in the database
            $stmt = $conn->prepare("UPDATE users SET profile_image=? WHERE user_id=?");
            $stmt->bind_param("si", $image_path, $_SESSION['user_id']);
            $stmt->execute();
        }
    }

    // Validate the data
    if (empty($new_username) || empty($new_email) || empty($new_password)) {
        echo "Please fill out all fields.";
    } else {
        // Hash the new password
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the user's information in the database
        $stmt = $conn->prepare("UPDATE users SET username=?, email=?, password_hash=? WHERE user_id=?");
        $stmt->bind_param("sssi", $new_username, $new_email, $new_password_hash, $_SESSION['user_id']);

        if (!$stmt->execute()) {
            // Display the error message
            echo "Error updating user information: " . $stmt->error;
        } else {
            // Update the session variables if the user has updated their username or email
            if ($new_username !== $_SESSION['username']) {
                $_SESSION['username'] = $new_username;
            }

            if ($new_email !== $_SESSION['email']) {
                $_SESSION['email'] = $new_email;
            }

            echo "User information updated successfully.";

            include 'footer.php';
        }
    }
}
