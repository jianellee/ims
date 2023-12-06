<?php
// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "orders_management";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start or resume the session
session_start();

// Fetch available supply names from the database
$supplyNames = array();
$fetch_supply_sql = "SELECT DISTINCT supply_name FROM supplies";
$fetch_supply_result = $conn->query($fetch_supply_sql);

if ($fetch_supply_result->num_rows > 0) {
    while ($row = $fetch_supply_result->fetch_assoc()) {
        $supplyNames[] = $row['supply_name'];
    }
}

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION['form_submitted'])) {
    // Retrieve form data
    $supply_name = $_POST["supply_name"];
    $quantity = $_POST["quantity"];
    $purchase_date = date("Y-m-d");

    // Check if the supply already exists in the database
    $check_sql = "SELECT * FROM supplies WHERE supply_name = '$supply_name'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Supply already exists, update the quantity
        $update_sql = "UPDATE supplies SET quantity = quantity + $quantity WHERE supply_name = '$supply_name'";
        if ($conn->query($update_sql) === TRUE) {
            echo "Supply updated successfully.";
        } else {
            echo "Error updating supply: " . $conn->error;
        }
    } else {
        // Supply does not exist, insert a new record
        $insert_sql = "INSERT INTO supplies (supply_name, quantity, purchase_date) VALUES ('$supply_name', $quantity, '$purchase_date')";

        if ($conn->query($insert_sql) === TRUE) {
            unset($_POST);
            echo "Supply added successfully.";

            // Set session variable to indicate form submission
            $_SESSION['form_submitted'] = true;
        } else {
            echo "Error adding supply: " . $conn->error;
        }
    }
}

// Process custom supply form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['custom_supply'])) {
    $custom_supply_name = $_POST["custom_supply_name"];

    // Insert a new record for custom supply
    $insert_custom_sql = "INSERT INTO supplies (supply_name, quantity, purchase_date) VALUES ('$custom_supply_name', 0, '$purchase_date')";

    if ($conn->query($insert_custom_sql) === TRUE) {
        unset($_POST);
        echo "Custom Supply added successfully.";
    } else {
        echo "Error adding custom supply: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplies</title>
    <link rel="stylesheet" href="style_supply.css">
</head>
<body>

<div class="sidebar">
    <img src="logo.jpg" alt="Logo" class="logo">
    <button onclick="location.href='home.php'">Dashboard</button>
    <button onclick="location.href='table_order.php'">Order</button>
    <button onclick="location.href='table_supply.php'">Supply</button>
</div>

<div class="form-container">
    <h2>Add Supplies</h2>

    <?php
       if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted']) {
    echo "<p>Form submitted successfully!</p>";

    // Reset session variable
    unset($_SESSION['form_submitted']);
        } else
           ?>

    <form id="supplyForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="supply_name">Select Supply:</label>
        <select id="supplySelect" name="supply_name" required>
            <option value="" selected>-- Select Supply --</option>
            <?php
            foreach ($supplyNames as $name) {
                echo "<option value='$name'>$name</option>";
            }
            ?>
        </select><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantityInput" name="quantity" required><br>

        <input type="submit" value="Add Supply">
        <br>
    </form>

    <!-- Form for adding custom supply -->
    <form id="customSupplyForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="custom_supply_name">Custom Supply Name:</label>
        <input type="text" id="customSupplyNameInput" name="custom_supply_name" required><br>

        <input type="submit" name="custom_supply" value="Add Custom Supply">
    </form>
</div>

</body>
</html>