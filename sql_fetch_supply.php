<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "orders_management";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT supply_name, quantity, supply_id FROM supplies ORDER BY supply_name;";


// Execute the query
$result = $conn->query($sql);

// Check for errors in SQL execution
if (!$result) {
    die("Error in SQL query: " . $conn->error);
}

// Fetch data
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "No records found";
}

// Close the connection
$conn->close();
?>
