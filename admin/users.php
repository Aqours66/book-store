<?php
include 'dashboard.php';
?>

<?php
// users.php

// Include database connection file
include_once "../db_connection.php";

// Initialize $user_data variable
$user_data = array();

// Initialize $success_message and $error_message variables
$success_message = "";
$error_message = "";

// CRUD operations
// Read operation
function getUsers($conn)
{
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Create operation
function createUser($conn, $username, $email, $password_hash, $profile_image)
{
    $sql = "INSERT INTO users (username, email, password_hash, profile_image) VALUES ('$username', '$email', '$password_hash', '$profile_image')";
    if ($conn->query($sql) === TRUE) {
        return "User added successfully!";
    } else {
        return "Error adding user: " . $conn->error;
    }
}

// Update operation
function updateUser($conn, $user_id, $username, $email, $password_hash, $profile_image)
{
    $sql = "UPDATE users SET username='$username', email='$email', password_hash='$password_hash', profile_image='$profile_image' WHERE user_id=$user_id";
    if ($conn->query($sql) === TRUE) {
        return "User updated successfully!";
    } else {
        return "Error updating user: " . $conn->error;
    }
}

// Delete operation
function deleteUser($conn, $user_id)
{
    $sql = "DELETE FROM users WHERE user_id=$user_id";
    if ($conn->query($sql) === TRUE) {
        return "User deleted successfully!";
    } else {
        return "Error deleting user: " . $conn->error;
    }
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new user
    if (isset($_POST["add_user"])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash password
        $profile_image = $_POST["profile_image"];
        $success_message = createUser($conn, $username, $email, $password_hash, $profile_image);
    }

    // Update user
    if (isset($_POST["edit_user"])) {
        $user_id = $_POST["user_id"];
        $sql = "SELECT * FROM users WHERE user_id=$user_id";
        $result = $conn->query($sql);
        $user_data = $result->fetch_assoc();
    }

    // Delete user
    if (isset($_POST["delete_user"])) {
        $user_id = $_POST["user_id"];
        $error_message = deleteUser($conn, $user_id);
    }

    // Update user
    if (isset($_POST["update_user"])) {
        $user_id = $_POST["user_id"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash password
        $profile_image = $_POST["profile_image"];
        $error_message = updateUser($conn, $user_id, $username, $email, $password_hash, $profile_image);
    }
}

// Display users
$users = getUsers($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../admin/css/users.css"> <!-- Link to your custom CSS styles -->
</head>

<body>
    <h1>Manage Users</h1>

    <?php
    // Display success message if set
    if (!empty($success_message)) {
        echo '<p class="success-message">' . $success_message . '</p>';
    }

    // Display error message if set
    if (!empty($error_message)) {
        echo '<p class="error-message">' . $error_message . '</p>';
    }
    ?>

    <button onclick="toggleForm('addUserForm')" class="add-button">Add User</button>
    <form id="addUserForm" method="post" style="display: none;">
        Username: <input type="text" name="username" required><br>
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        Profile Image URL: <input type="text" name="profile_image"><br>
        <input type="submit" name="add_user" value="Add User">
    </form>
    <!-- Display Users -->
    <h2>Users</h2>
    <table border="1">
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Profile Image</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?php echo $user['user_id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['profile_image']; ?></td>
                <td>
                    <!-- Edit User Form -->
                    <button onclick="toggleForm('editUserForm_<?php echo $user['user_id']; ?>')">Edit</button>
                    <form id="editUserForm_<?php echo $user['user_id']; ?>" method="post" style="display: none;">
                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                        Username: <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
                        Email: <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
                        Password: <input type="password" name="password" required><br>
                        Profile Image URL: <input type="text" name="profile_image" value="<?php echo $user['profile_image']; ?>"><br>
                        <input type="submit" name="update_user" value="Update User">
                    </form>
                    <!-- Delete User Button -->
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                        <input type="submit" name="delete_user" value="Delete">
                    </form>
                    <!-- Add User Button -->


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