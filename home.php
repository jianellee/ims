<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "orders_management";

// Create a database connection
$conn = new mysqli($host, $user, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the 3 latest rows from the 'order' table
$orderQuery = "SELECT * FROM `orders` ORDER BY `created_at` DESC LIMIT 3";
$orderResult = $conn->query($orderQuery);

// Check for errors in the order query
if (!$orderResult) {
    die("Error in order query: " . $conn->error);
}

// Query to get the lowest quantity from the 'supplies' table
$suppliesQuery = "SELECT * FROM `supplies` ORDER BY `quantity` ASC LIMIT 1";
$suppliesResult = $conn->query($suppliesQuery);

// Check for errors in the supplies query
if (!$suppliesResult) {
    die("Error in supplies query: " . $conn->error);
}

$lowestSupply = $suppliesResult->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Overview Dashboard</title>
    <link rel="stylesheet" href="style_home.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            display: flex;
            justify-content: space-between;
        }

        .table-container {
            width: 48%;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="sidebar">
        <img src="logo.jpg" alt="Logo" class="logo">
        <button onclick="location.href='home.php'">Dashboard</button>
        <button onclick="location.href='table_order.php'">Order</button>
        <button onclick="location.href='table_supply.php'">Supply</button>
    </div>
    <h1>Dashboard</h1>

    <div class="container">
        <div class="table-container">
            <h2>Latest Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $orderResult->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['order_id'] ?></td>
                            <td><?= $row['order_type'] ?></td>
                            <td><?= $row['quantity'] ?></td>
                            <td><?= $row['created_at'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <h2>Lowest Supplies</h2>
            <table>
                <thead>
                    <tr>
                        <th>Supply ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $lowestSupply['supply_id'] ?></td>
                        <td><?= $lowestSupply['supply_name'] ?></td>
                        <td><?= $lowestSupply['quantity'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
