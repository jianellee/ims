<?php
// Assuming you have a database connection established, include the necessary configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "order_management";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Get data from the request
$orderId = $_POST['orderId'];
$status = $_POST['status'];

// Validate and sanitize input as needed

// Update the database
try {
    $stmt = $conn->prepare("UPDATE orders SET status = :status WHERE OrderID = :orderId");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':orderId', $orderId);
    $stmt->execute();

    // Return a success message or other response if needed
    echo "Status updated successfully!";
} catch (PDOException $e) {
    // Handle errors
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>
