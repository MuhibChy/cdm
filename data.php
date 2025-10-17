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

// Function to get counts for a specific date
function getCountsForDate($conn, $date) {
    $query = "SELECT 
                SUM(CASE WHEN order_status = 'Leads Generation' THEN 1 ELSE 0 END) AS lead_generation,
                SUM(CASE WHEN order_status = 'Engagement' THEN 1 ELSE 0 END) AS engagement,
                SUM(CASE WHEN order_status = 'Proposal' THEN 1 ELSE 0 END) AS proposal,
                SUM(CASE WHEN order_status = 'Order' THEN 1 ELSE 0 END) AS order_total,
                SUM(CASE WHEN order_status = 'Payment' THEN 1 ELSE 0 END) AS payment,
                SUM(CASE WHEN order_status = 'Delivery' THEN 1 ELSE 0 END) AS delivery,
                COUNT(*) AS total_customers
              FROM customer_orders
              WHERE DATE(order_date) = '$date'";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Example: Get counts for today
$currentDate = date('Y-m-d');
$data_today = getCountsForDate($conn, $currentDate);

// Close connection
$conn->close();

// Output data as JSON
header('Content-Type: application/json');
echo json_encode($data_today);
?>
