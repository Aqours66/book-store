<?php
include 'header.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Include the database connection file
require_once 'db_connection.php';

$user_id = $_SESSION['user_id'];

// Fetch the user's profile information from the database
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $email = $row['email'];
    $profile_image = $row['profile_image'];

    // Check if the form was submitted and the user information was updated
    $success_message = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form input data
        $new_username = $_POST['new_username'];
        $new_email = $_POST['new_email'];
        $new_password = $_POST['new_password'];

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

                $success_message = "User information updated successfully.";
            }

            // Check if a file was uploaded
            if (isset($_FILES['profile_image'])) {
                $file = $_FILES['profile_image'];

                // Check if there was no error during the file upload
                if ($file['error'] === UPLOAD_ERR_OK) {
                    // Move the uploaded file to the desired directory
                    $uploadDir = 'uploads/';
                    $uploadFile = $uploadDir . basename($file['name']);

                    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                        // Update the user's profile image path in the database
                        $profile_image = $uploadFile;

                        $stmt = $conn->prepare("UPDATE users SET profile_image=? WHERE user_id=?");
                        $stmt->bind_param("si", $profile_image, $_SESSION['user_id']);
                        $stmt->execute();

                        // Check if the profile image was updated successfully
                        if ($stmt->affected_rows > 0) {
                            $success_message .= " Profile image updated successfully.";
                        } else {
                            $success_message .= " Error updating profile image.";
                        }
                    } else {
                        $success_message .= " Error uploading file.";
                    }
                } else {
                    $success_message .= " Error: " . $file['error'];
                }
            }
        }
    }

    // Display the user profile and order history
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Profile</title>
        <link rel="stylesheet" href="user-profile.css">
    </head>

    <body class="profile-container">
        <h1 class="profile-title">User Profile</h1>
        <div class="profile">
            <img class="profile-image" src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Image">
            <p class="profile-username"><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p class="profile-email"><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p class="logout"><a class="logout-link" href="logout.php">Logout</a></p>
            <?php if (!empty($success_message)) : ?>
                <p class="success-message"><?php echo $success_message; ?></p>
            <?php endif; ?>
            <div class="profile-form">
                <form action="user-profile.php" method="post" enctype="multipart/form-data">
                    <h2>Edit Profile</h2>
                    <label for="new_username">New Username:</label>
                    <input type="text" id="new_username" name="new_username" value="<?php echo htmlspecialchars($username); ?>">

                    <label for="new_email">New Email:</label>
                    <input type="email" id="new_email" name="new_email" value="<?php echo htmlspecialchars($email); ?>">

                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password">

                    <label for="profile_image">New Profile Image:</label>
                    <input type="file" id="profile_image" name="profile_image">

                    <input type="submit" value="Save Changes">
                </form>
            </div>
        </div>

        <!-- Order History Section -->
        <div class="order-history">
            <h2>Order History</h2>
            <?php
            // Retrieve the user's orders from the database
            $sql = "SELECT * FROM orders WHERE user_id = $user_id";
            $orders_result = $conn->query($sql);

            if ($orders_result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Order ID</th><th>Order Date</th><th>Total</th><th>Status</th></tr>";
                while ($order_row = $orders_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $order_row['order_id'] . "</td>";
                    echo "<td>" . $order_row['order_date'] . "</td>";
                    echo "<td>" . $order_row['total'] . "</td>";
                    echo "<td>" . $order_row['status'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No orders found.";
            }
            ?>
        </div>
    </body>

    </html>
<?php
} else {
    echo 'User not found';
}
?>