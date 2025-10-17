<?php
// Include your database connection file
include 'conn.php';

// Start session to access user ID
session_start();

// Response array
$response = array();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $order_id = intval($_POST['order_id']); // Ensure order_id is an integer
    $date_closed = mysqli_real_escape_string($conn, $_POST['date_closed']);
    $order_status = mysqli_real_escape_string($conn, $_POST['order_status']);

    // Update query
    $sql = "UPDATE customer_orders SET 
                date_closed = '$date_closed', 
                order_status = '$order_status' 
            WHERE order_id = $order_id";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        // If update is successful, send success response
        $response['status'] = 'success';
        $response['message'] = 'Client Status Updated Successfully';

        // Insert notification into the database
        $userId = $_SESSION['user_id']; // Get the actual user ID from session
        $notificationMessage = "Information About Order ID: $order_id Has Been Updated and Moved to Closed Status.";
        $notifSql = "INSERT INTO notifications (user_id, order_id, message) VALUES (?, ?, ?)";
        $notifStmt = $conn->prepare($notifSql);
        $notifStmt->bind_param("iis", $userId, $order_id, $notificationMessage);
        $notifStmt->execute();

        // Insert notification into the database
        $userId = $_SESSION['user_id']; // Get the actual user ID from session
        $notificationMessage = "Information About Client, Transaction Number: $order_id Has Been Updated and Moved to Closed Status.";
        $notifSql = "INSERT INTO admin_notifications (user_id, order_id, message) VALUES (?, ?, ?)";
        $notifStmt = $conn->prepare($notifSql);
        $notifStmt->bind_param("iis", $userId, $order_id, $notificationMessage);
        $notifStmt->execute();
    } else {
        // If there's an error with the query, send error response
        $response['status'] = 'error';
        $response['message'] = 'Error Updating Client Order: ' . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
} else {
    // Invalid request
    $response['status'] = 'error';
    $response['message'] = 'Invalid request.';
}

// Send response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
