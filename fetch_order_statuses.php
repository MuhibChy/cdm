<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "cdms";

$conn = new mysqli($servername, $username, $password, $database);

// Initialize response
$response = [];

// Check connection
if ($conn->connect_error) {
    $response['error'] = "Connection failed: " . $conn->connect_error;
} else {
    // Query to fetch order statuses
    $sql = "SELECT DISTINCT order_status FROM customer_orders";
    if ($result = $conn->query($sql)) {
        $orderStatuses = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orderStatuses[] = $row['order_status'];
            }
        }
        $response['order_statuses'] = $orderStatuses;
        $result->free();
    } else {
        $response['error'] = "Error executing query: " . $conn->error;
    }
}

// Close connection
$conn->close();

// Output as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
