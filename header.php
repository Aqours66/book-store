<?php
// Include this file at the beginning of each script that needs the header
session_start();

// Your header content goes here
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PageTurner Plaza</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1><a href="index.php">PageTurner Plaza</a></h1>
        <div class="search-bar">
            <form action="search.php" method="GET">
                <input type="text" name="query" placeholder="Search...">
                <button type="submit">Search</button>
            </form>
        </div>

        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="manga.php">Manga</a></li>
                <li><a href="light-novel.php">Light Novels</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="faq.php">FAQ</a></li>
                <?php
                // Check if the user is logged in
                if (isset($_SESSION["user_id"])) {
                    // If the user is logged in, display the username instead of the login and register links
                    $username = $_SESSION["username"];
                    $user_id = $_SESSION["user_id"];
                    echo "<li><a href='user-profile.php?user_id=$user_id'>$username</a></li>";
                } else {
                    // If the user is not logged in, display the login and register links
                    echo "<li><a href='login.php'>Login</a></li>";
                    echo "<li><a href='register_form.php'>Register</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>
</body>

</html>