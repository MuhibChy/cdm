<?php
// Include your database connection file
include 'conn.php';

// Function to update order status
function updateOrderStatus() {
    global $conn;

    // Update orders with 'Delivery' status to 'Closed' after 1 minute
    $sql = "UPDATE customer_orders 
            SET order_status = 'Closed', date_closed = NOW()
            WHERE order_status = 'Delivery' 
            AND TIMESTAMPDIFF(SECOND, order_date, NOW()) >= 60"; // 60 seconds = 1 minute

    if (mysqli_query($conn, $sql)) {
        echo "Order statuses updated successfully.";
    } else {
        echo "Error updating order statuses: " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}

// Call the function to update order status
updateOrderStatus();
?>
