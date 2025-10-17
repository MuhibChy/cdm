<?php
// Database credentials
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

// Query to fetch sales managers
$sql = "SELECT manager_id, firstname, lastname FROM sales_managers";

$managers = [];
if ($result = $conn->query($sql)) {
    // Fetch results
    while ($row = $result->fetch_assoc()) {
        $managers[] = $row;
    }
    // Free result set
    $result->free();
} else {
    // Handle query error
    $managers[] = ["error" => "Query failed: " . $conn->error];
}

// Close connection
$conn->close();

// Output as JSON
header('Content-Type: application/json');
echo json_encode($managers);
?>
