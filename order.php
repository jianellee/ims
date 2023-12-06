<?php

$orderTypes = [
    'Sticker Printing' => ['5x5', '7x5', '10x7'],
    'Label Printing' => ['Small', 'Medium', 'Large'],
    'Wall Decor' => ['8x10', '16x20', '24x36'],
    'Photocard' => ['Standard', 'Square', 'Polaroid'],
    'Business Card' => ['Standard', 'Square'],
    'Invitation' => ['A5', 'A6', '5x7'],
    'Logo Branding' => ['Small', 'Medium', 'Large'],
    'Video Editing' => ['Basic', 'Standard', 'Premium'],
    'Vector Art' => ['Simple', 'Detailed'],
    'Proof Reading' => ['Basic', 'Advanced'],
    'Writing Assistance' => ['Content Editing', 'Copywriting']
];


function getTotalSupply() {
    // Database connection parameters
    $host = "localhost";
    $uname = "root";
    $password = "";
    $database = "orders_management";

    // Create a new MySQLi connection
    $conn = new mysqli($host, $uname, $password, $database);

    // Check the database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Select the total_supply value from the "supplies" table
    $query = "SELECT quantity FROM supplies";

    // Execute the SQL query
    $result = $conn->query($query);

    // Check if the query was successful
    if ($result) {
        // Fetch the result as an associative array
        $row = $result->fetch_assoc();

        // Check if the row is not empty
        if ($row) {
            // Retrieve the total_supply value
            $totalSupply = $row['quantity'];
            return $totalSupply;
        } else {
            echo "No data found in the 'supplies' table.";
        }
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}

$totalSupply = getTotalSupply();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_submitted'])) {
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedOrderType = $_POST['orderType'];
    $selectedSize = $_POST['size'];

    if (isset($orderTypes[$selectedOrderType])) {
        if (in_array($selectedSize, $orderTypes[$selectedOrderType])) {
            $quantity = $_POST['quantity'];
            $totalArea = calculateTotalArea($selectedOrderType, $selectedSize, $quantity);
            $a4Area = 21 * 29.7; 
            $sheetsNeeded = ceil($totalArea / $a4Area);
            $supplyAfter = $totalSupply - $sheetsNeeded;

            // Fetch total supply here (removed inner if condition)
            $totalSupply = getTotalSupply();

            // Confirm and store the order in the database
            if (confirmAndStoreOrder($selectedOrderType, $selectedSize, $quantity, $totalArea, $sheetsNeeded, $totalSupply)) {
                echo "Order confirmed and stored successfully!<br>";
                header("table_order.php");
            } else {
                echo "Failed to confirm and store the order.";
            }

            echo "Order Type: $selectedOrderType<br>";
            echo "Size: $selectedSize<br>";
            echo "Quantity: $quantity<br>";
            echo "Supplies Needed: $sheetsNeeded<br>";
            echo "Total Supply after Order: $supplyAfter<br>";
            
        } else {
            echo "Invalid size for the chosen order type.";
        }
    } else {
        echo "Invalid order type.";
    }
}
}


function calculateTotalArea($orderType, $size, $quantity) {
    $stickerSizes = [
        '5x5' => 25,
        '7x5' => 35,
        '10x7' => 70,
        'Small' => 10,
        'Medium' => 15,
        'Large' => 20,
        '8x10' => 80,
        '16x20' => 160,
        '24x36' => 240,
        'Standard' => 15,
        'Square' => 20,
        'Polaroid' => 25,
        'A5' => 30,
        'A6' => 20,
        '5x7' => 35,
        'Basic' => 40,
        'Standard' => 80,
        'Premium' => 120,
        'Simple' => 60,
        'Detailed' => 100,
        'Basic' => 20,
        'Advanced' => 40,
        'Content Editing' => 100,
        'Copywriting' => 160
    ];

    $areaPerUnit = $stickerSizes[$size] ?? 0;
    $totalArea = $quantity * $areaPerUnit;

    return $totalArea;
}

function confirmAndStoreOrder($orderType, $size, $quantity, $totalArea, $a4Needed, $totalSupply) {
    
    $host = "localhost";
    $uname = "root";
    $password = "";
    $database = "orders_management";

    // Create connection
    $conn = new mysqli($host, $uname, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the order into the 'orders' table
    $query = "INSERT INTO orders (order_type, size, quantity, total_area, a4_needed, total_supply) 
              VALUES ('$orderType', '$size', $quantity, $totalArea, $a4Needed, $totalSupply)";

    $result = $conn->query($query);

    // Close the database connection
    $conn->close();

    return $result;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Supplies Calculator</title>
    <link rel="stylesheet" href="style_order.css">
</head>
<body>
    <div class="sidebar">
        <img src="logo.jpg" alt="Logo" class="logo">
        <button onclick="location.href='home.php'">Dashboard</button>
        <button onclick="location.href='table_order.php'">Order</button>
        <button onclick="location.href='table_supply.php'">Supply</button>
    </div>

    <form method="post" action="" class="form-container">
        <input type="hidden" name="form_submitted" value="1"> <!-- Add this line -->

        <label for="orderType">Order Type:</label>
        <select name="orderType" id="orderType">
            <?php foreach ($orderTypes as $type => $sizes) : ?>
                <option value="<?= $type ?>"><?= $type ?></option>
            <?php endforeach; ?>
        </select>

        <label for="size">Size:</label>
        <select name="size" id="size">
            <!-- Size options will be dynamically populated based on the selected order type -->
        </select>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" value="1" min="1">

        <button type="submit">Calculate</button>
    </form>

    <script>
        const orderTypeSelect = document.getElementById('orderType');
        const sizeSelect = document.getElementById('size');
        const sizes = <?= json_encode($orderTypes) ?>;

        orderTypeSelect.addEventListener('change', () => {
            const selectedOrderType = orderTypeSelect.value;
            const selectedSizes = sizes[selectedOrderType];

            sizeSelect.innerHTML = '';

            selectedSizes.forEach(size => {
                const option = document.createElement('option');
                option.value = size;
                option.textContent = size;
                sizeSelect.appendChild(option);
            });
        });

        orderTypeSelect.dispatchEvent(new Event('change'));
    </script>
</body>
</html>
