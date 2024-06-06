<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../admin/css/dashboard.css"> <!-- Link to your custom CSS styles -->

</head>

<body>
    <header>
        <h1 onclick="window.location.href='dashboard.php'">Admin Dashboard</h1>

        <nav>
            <ul>
                <li><a href="users.php?source=dashboard">Users</a></li>
                <li><a href="order_items.php?source=dashboard">Order Items</a></li>
                <li><a href="orders.php?source=dashboard">Orders</a></li>
                <li><a href="books.php?source=dashboard">Books</a></li>
                <li><a href="logout.php?source=dashboard">Logout</a></li>
            </ul>
        </nav>
    </header>


</body>

</html>