<?php
// edit_supply.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "orders_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Extract supply_id, supply_name, and quantity from the URL parameters
if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['quantity'])) {
  $supplyId = $_GET['id'];
  $supplyName = $_GET['name'];
  $quantity = $_GET['quantity'];
} else {
  echo "Missing supply ID or name or quantity in URL";
  exit();
}

// Check if it's an existing supply or a new one
$isEditing = true;

// Update the data in the database for an existing supply
$update_sql = "UPDATE supplies SET supply_name = '" . $conn->escape_string($supplyName) . "', quantity = $quantity WHERE supply_id = $supplyId";

if ($conn->query($update_sql) === TRUE) {
  echo "Record updated successfully.";
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Supply</title>
</head>
<body>

<h2><?php echo $isEditing ? 'Edit' : 'Add'; ?> Supply</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . ($isEditing ? "?id=" . $supplyId : "")); ?>">
  <label for="new_supply_name">New Supply Name:</label>
  <input type="text" name="new_supply_name" value="<?php echo $isEditing ? $row['supply_name'] : ''; ?>" required><br>

  <label for="new_quantity">New Quantity:</label>
  <input type="number" name="new_quantity" value="<?php echo $isEditing ? $row['quantity'] : ''; ?>" required><br>

  <input type="submit" value="<?php echo $isEditing ? 'Update' : 'Add'; ?> Supply">
</form>

</body>
</html>
