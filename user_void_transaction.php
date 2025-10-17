<?php
// Include your database connection file
include 'conn.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Response array
$response = array();

// Check if form is submitted and process the update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    
    // Update order status to 'Leads Generation'
    $sql = "UPDATE customer_orders SET order_status = 'Leads Generation' WHERE order_id = $order_id";
    
    // Execute update query
    if ($conn->query($sql) === TRUE) {
        $response = array(
            'status' => 'success',
            'message' => 'Order status updated to Leads Generation successfully.'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Error updating order status: ' . $conn->error
        );
    }

    // Close database connection
    $conn->close();

    // Return JSON response to JavaScript
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
