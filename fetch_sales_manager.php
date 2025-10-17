<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "cdms";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch distinct sales managers
$sql = "SELECT DISTINCT sales_manager FROM customer_orders";

$salesManagers = [];
if ($result = $conn->query($sql)) {
    // Fetch results
    while ($row = $result->fetch_assoc()) {
        $salesManagers[] = $row['sales_manager'];
    }
    // Free result set
    $result->free();
} else {
    // Handle query error
    $salesManagers[] = "Error: " . $conn->error;
}

// Close connection
$conn->close();

// Output as JSON
header('Content-Type: application/json');
echo json_encode($salesManagers);
?>
