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

// Initialize response
$response = [];

// Get and sanitize POST data
$salesManager = isset($_POST['sales_manager']) ? $conn->real_escape_string($_POST['sales_manager']) : '';
$orderStatus = isset($_POST['order_status']) ? $conn->real_escape_string($_POST['order_status']) : '';

// Prepare SQL query with placeholders
$sql = "SELECT c.customer_firstname, c.customer_lastname, c.company_name, c.customer_type, c.customer_category
        FROM customers c
        INNER JOIN customer_orders o ON c.customer_id = o.customer_id
        INNER JOIN sales_managers s ON o.sales_manager_id = s.sales_manager_id
        WHERE s.sales_manager_name = ? AND o.order_status = ?";

if ($stmt = $conn->prepare($sql)) {
    // Bind parameters
    $stmt->bind_param('ss', $salesManager, $orderStatus);
    
    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch data
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
    } else {
        $response = ['message' => 'No records found'];
    }

    // Close statement
    $stmt->close();
} else {
    $response = ['error' => 'Error preparing the SQL statement'];
}

// Close connection
$conn->close();

// Output as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
