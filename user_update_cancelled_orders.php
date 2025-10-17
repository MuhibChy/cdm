<?php
// Include your database connection file
include 'conn.php';

// Update cancelled orders to closed after 1 minute
$sql = "UPDATE customer_orders
        SET order_status = 'Closed'
        WHERE order_status = 'Cancelled' AND TIMESTAMPDIFF(MINUTE, latest_engagement_date, NOW()) >= 1";

if ($conn->query($sql) === TRUE) {
    echo "Cancelled orders updated to closed successfully.";
} else {
    echo "Error updating orders: " . $conn->error;
}

$conn->close();
?>
