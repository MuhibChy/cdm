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

// Get POST data and sanitize inputs
$salesManager = isset($_POST['sales_manager']) ? $conn->real_escape_string($_POST['sales_manager']) : '';
$orderStatus = isset($_POST['order_status']) ? $conn->real_escape_string($_POST['order_status']) : '';

// Prepare SQL query with placeholders
$sql = "SELECT customer_firstname, customer_lastname, company_name, customer_type, customer_category
        FROM customer_orders
        WHERE sales_manager = ? AND order_status = ?";

// Prepare and execute the statement
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('ss', $salesManager, $orderStatus);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch data
    $customerData = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $customerData[] = $row;
        }
    }

    // Close statement
    $stmt->close();
} else {
    echo json_encode(['error' => 'Error preparing the SQL statement']);
}

// Close connection
$conn->close();

// Output as JSON
header('Content-Type: application/json');
echo json_encode($customerData);
?>
