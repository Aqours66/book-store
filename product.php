<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #141d26;
            /* Dark blue */
            color: #fff;
        }

        .product-detail-container {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            justify-content: space-between;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #1d2633;
        }

        .product-detail-image {
            width: 800px;
            height: 500px;
            margin-right: 20px;
            border-radius: 5px;
        }

        .product-detail-info {
            max-width: 600px;
            flex-grow: 1;
        }

        .product-detail-title {
            font-size: 24px;
            margin-top: 20px;
        }

        .product-detail-text {
            font-size: 16px;
            margin: 10px 0;
        }

        .product-detail-input {
            width: 60px;
            padding: 5px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
        }

        .product-detail-button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #ff0045;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .product-detail-button:hover {
            background-color: #ff506a;
        }

        .other-books {
            margin-top: 40px;
        }

        .other-books h3 {
            margin-bottom: 20px;
        }

        .swiper-container-other {
            width: 100%;
            padding: 20px;
        }

        .swiper-slide-other {
            display: flex;
            justify-content: space-between;
        }

        .other-book-item {
            background-color: #1d2633;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 30px;
            text-align: center;
            width: 300px;
            margin-bottom: 100px;
        }

        .other-book-item img {
            max-width: 100%;
            width: 400px;
            height: 200px;
            border-radius: 5px;
        }

        .other-book-item h4 {
            font-size: 18px;
            margin-top: 10px;
        }

        .other-book-item p {
            font-size: 14px;
            margin: 5px 0;
        }

        .other-book-item a {
            text-decoration: none;
            color: #fff;
        }

        .other-book-item a:hover {
            color: #ff0045;
        }

        /* Hide Swiper pagination dots */
        .swiper-pagination-other {
            display: none;
        }

        .login-message {
            font-size: 18px;
            color: #ff0045;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <main>
        <?php
        // Include database connection file
        include_once "db_connection.php";

        // Get the book ID from the URL
        $book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Fetch the book details from the database
        $sql = "SELECT * FROM books WHERE book_id = $book_id";
        $result = $conn->query($sql);

        // Check if the book exists
        if ($result->num_rows > 0) {
            $book = $result->fetch_assoc();
        ?>
            <div class="product-detail-container">
                <img class="product-detail-image" src="admin/<?php echo $book['image_url']; ?>" alt="<?php echo $book['title']; ?>">
                <div class="product-detail-info">
                    <h2 class="product-detail-title"><?php echo $book['title']; ?></h2>
                    <p class="product-detail-text"><strong>Author:</strong> <?php echo $book['author']; ?></p>
                    <p class="product-detail-text"><?php echo $book['description']; ?></p>
                    <p class="product-detail-text"><strong>Price:</strong> $<?php echo $book['price']; ?></p>
                    <div class="product-detail-text">
                        <label for="quantity">Quantity:</label>
                        <form action="addToCart.php" method="post">
                            <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                            <input class="product-detail-input" type="number" id="quantity" name="quantity" min="1" max="<?php echo $book['stock_quantity']; ?>" value="1">
                            <?php
                            // Check if user is not logged in
                            if (!isset($_SESSION['user_id'])) {
                                // User is not logged in, show message and prompt to log in
                                echo '<p class="login-message">Please log in to buy this product.</p>';
                            } else {
                                // User is logged in, show Buy Now button
                                echo '<input type="submit" class="product-detail-button" value="Buy Now">';
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        <?php
        } else {
            echo "<p>Book not found.</p>";
        }
        ?>
        <div class="other-books">
            <h3>Other Books</h3>
            <div class="swiper-container swiper-container-other">
                <div class="swiper-wrapper">
                    <?php
                    // Fetch other books from the database
                    $sql = "SELECT * FROM books WHERE book_id != $book_id LIMIT 6";
                    $result = $conn->query($sql);

                    // Check if there are any results
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="swiper-slide swiper-slide-other">';
                            echo '<div class="other-book-item">';
                            echo '<a href="product.php?id=' . $row["book_id"] . '">';
                            echo '<img src="admin/' . $row["image_url"] . '" alt="' . $row["title"] . '">';
                            echo '<h4>' . $row["title"] . '</h4>';
                            echo '<p>' . $row["author"] . '</p>';
                            echo '</a>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "No other books found.";
                    }
                    ?>
                </div>
                <div class="swiper-pagination swiper-pagination-other"></div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiperOther = new Swiper('.swiper-container-other', {
            slidesPerView: 3,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination-other',
                clickable: true,
            },
        });

        function buyNow() {
            // Redirect user to login page
            window.location.href = 'login.php';
        }
    </script>
    <script src="scripts.js"></script>
</body>

</html>