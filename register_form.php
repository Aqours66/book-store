<?php
session_start();

require_once 'db_connection.php';

$error_message = ''; // Initialize the error message variable
$profile_image = ''; // Initialize the profile image variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if username or email already exists
    $sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error_message = "Username or email already exists!";
    } else {
        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Handle profile image upload
        $target_dir = "uploads/"; // Change this to the directory where you want to store the uploaded images
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        if ($check !== false) {
            $error_message = "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $error_message = "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["profile_image"]["size"] > 500000) {
            $error_message = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $error_message = "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                $error_message = "Register Successfully. Click This to <a href='welcome.php'>Login</a>";
                $profile_image = $target_file; // Save the path to the uploaded image
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        }

        if ($uploadOk == 1) {
            // Insert new user into database
            $sql = "INSERT INTO users (username, email, password_hash, profile_image) VALUES ('$username', '$email', '$password_hash', '$profile_image')";
            $conn->query($sql);

            if (empty($error_message)) {
                // Redirect to welcome.php page
                header('Location: welcome.php');
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Your register CSS styles -->
    <link rel="stylesheet" href="register.css">
</head>

<?php include 'header.php'; ?>

<body class="register-body">
    <h2 class="register-title">Register</h2>
    <form class="register-form" action="register_form.php" method="post" enctype="multipart/form-data">
        <label class="register-label" for="username">Username:</label>
        <input class="register-input" type="text" id="username" name="username" required><br><br>

        <label class="register-label" for="email">Email:</label>
        <input class="register-input" type="email" id="email" name="email" required><br><br>

        <label class="register-label" for="password">Password:</label>
        <input class="register-input" type="password" id="password" name="password" required><br><br>

        <label class="register-label" for="profile_image">Profile Image:</label>
        <input class="register-input" type="file" id="profile_image" name="profile_image" accept="image/*">

        <input class="register-button" type="submit" value="Register" name="submit">

        <?php if (!empty($error_message)) : ?>
            <p><?php echo $error_message; ?></p>
        <?php endif; ?>

    </form>

</body>

</html>

<?php include 'footer.php'; ?>