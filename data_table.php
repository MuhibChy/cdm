<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "cdms"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get customer orders by customer type
function getCustomerOrdersByType($conn, $customerType) {
    $query = "SELECT 
                customers.customer_firstname,
                customers.customer_lastname,
                customers.company_name,
                customer_orders.customer_type,
                customer_orders.customer_category
              FROM customer_orders
              JOIN customers ON customer_orders.customer_id = customers.customer_id
              WHERE customer_orders.customer_type = '$customerType'";

    $result = $conn->query($query);

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    return $orders;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerType = isset($_POST['customer_type']) ? $_POST['customer_type'] : '';

    if ($customerType) {
        $orders = getCustomerOrdersByType($conn, $customerType);

        // Output data as JSON
        $response = [
            "data" => $orders
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

// Close connection
$conn->close();
?>
