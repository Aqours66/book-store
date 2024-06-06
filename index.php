<?php include 'header.php'; ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured Books</title>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <style>
        /* Customize styles as needed */
        .swiper-container {
            width: 100%;
            padding: 20px;
        }

        .swiper-slide {
            display: flex;
            justify-content: space-between;
        }

        .product {
            background-color: #2e3a4d;
            /* Dark blue */
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            width: 300px;
            text-align: center;
        }

        .product h3 {
            margin-top: 10px;
            font-size: 16px;
            /* Adjust the font size of the book title */
        }

        .product p {
            margin-bottom: 10px;
            font-size: 14px;
            /* Adjust the font size of other text */
        }

        .product img {
            max-width: 100%;
            width: 250px;
            height: 200px;
            border-radius: 10px;
        }

        .product a {
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <main>
        <section id="featured-manga">
            <h2>Featured Manga</h2>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php
                    // Include database connection file
                    include_once "db_connection.php";

                    // Fetch featured manga books from the database
                    $sql = "SELECT * FROM books WHERE type = 'Manga'";
                    $result = $conn->query($sql);

                    // Check if there are any results
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="swiper-slide">';
                            echo '<div class="product">';
                            echo '<a href="product.php?id=' . $row["book_id"] . '">';
                            echo '<img src="admin/' . $row["image_url"] . '" alt="' . $row["title"] . '">';
                            echo '<h3>' . $row["title"] . '</h3>';
                            echo '</a>';
                            echo '<p>' . $row["author"] . '</p>';
                            echo '<p>' . $row["description"] . '</p>';
                            echo '<p>Price: $' . $row["price"] . '</p>';
                            echo '<a href="product.php?id=' . $row["book_id"] . '"><button>View Details</button></a>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "No manga books found.";
                    }
                    ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>

        <section id="featured-light-novels">
            <h2>Featured Light Novels</h2>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php
                    // Fetch featured light novels from the database
                    $sql = "SELECT * FROM books WHERE type = 'Light Novel'";
                    $result = $conn->query($sql);

                    // Check if there are any results
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="swiper-slide">';
                            echo '<div class="product">';
                            echo '<a href="product.php?id=' . $row["book_id"] . '">';
                            echo '<img src="admin/' . $row["image_url"] . '" alt="' . $row["title"] . '">';
                            echo '<h3>' . $row["title"] . '</h3>';
                            echo '</a>';
                            echo '<p>' . $row["author"] . '</p>';
                            echo '<p>' . $row["description"] . '</p>';
                            echo '<p>Price: $' . $row["price"] . '</p>';
                            echo '<a href="product.php?id=' . $row["book_id"] . '"><button>View Details</button></a>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "No light novels found.";
                    }
                    ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>
    </main>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 3, // Number of books per swipe
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
</body>

</html>

<?php include 'footer.php'; ?>
<script src="scripts.js"></script>
</body>

</html>