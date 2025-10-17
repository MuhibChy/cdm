<?php
include 'conn.php'; // Include your database connection script

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Ensure session is started

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables from form inputs
    $order_id = $_POST['order_id'];
    $sales_order_reference_number = $_POST['sales_order_reference_number'];
    $date_of_sales_order_creation = $_POST['date_of_sales_order_creation'];
    $order_remarks = $_POST['order_remarks'];
    $warehouse_email = $_POST['warehouse_email'];
    $order_status = $_POST['order_status'];

    // Initialize $uploaded_file_cancelled
    $uploaded_file_cancelled = '';

    // Handle file upload for Proof of Cancellation
    if ($order_status == 'Cancelled' && !empty($_FILES['uploaded_file_cancelled']['name'])) {
        $target_dir = "files/"; // Directory where files will be uploaded
        $uploaded_file_cancelled = basename($_FILES["uploaded_file_cancelled"]["name"]);
        $target_file = $target_dir . $uploaded_file_cancelled;
        
        // Check if the file is uploaded successfully
        if (move_uploaded_file($_FILES["uploaded_file_cancelled"]["tmp_name"], $target_file)) {
            // File uploaded successfully
        } else {
            // Handle file upload error
            $response = array(
                'status' => 'error',
                'message' => 'Error Uploading File. Please Check File Permissions and Upload Settings.'
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

    // Update timestamp
    $statusUpdatedAt = date('Y-m-d H:i:s'); // Current time

    // Prepare SQL query based on order status
    $sql = "";
    if ($order_status == 'Order') {
        $sql = "UPDATE customer_orders 
                SET sales_order_reference_number = '$sales_order_reference_number', 
                    date_of_sales_order_creation = '$date_of_sales_order_creation', 
                    order_remarks = '$order_remarks', 
                    warehouse_email = '$warehouse_email',
                    order_status = '$order_status',
                    status_updated_at = '$statusUpdatedAt'
                WHERE order_id = $order_id";
    } elseif ($order_status == 'Cancelled') {
        $reason_cancelled = $_POST['reason_cancelled'];

        $sql = "UPDATE customer_orders 
                SET order_status = 'Cancelled', 
                    reason_cancelled = '$reason_cancelled',
                    uploaded_file_cancelled = '$uploaded_file_cancelled',
                    status_updated_at = '$statusUpdatedAt' 
                WHERE order_id = $order_id";
    }

    // Execute update query
    if ($conn->query($sql) === TRUE) {
        // Prepare notification messages
        $userId = $_SESSION['user_id']; // Use the user ID from session
        $notificationMessage = "";
        
        if ($order_status == 'Order') {
            $notificationMessage = "Information About Client, Transaction Number: $order_id Has Been Updated and Moved to Order Status.";
        } elseif ($order_status == 'Cancelled') {
            $notificationMessage = "Information About Client, Transaction Number: $order_id Has Been Cancelled. Reason: " . $_POST['reason_cancelled'];
        }

        // Insert notification into the notifications table
        $notifSql = "INSERT INTO notifications (user_id, order_id, message) VALUES (?, ?, ?)";
        $notifStmt = $conn->prepare($notifSql);
        $notifStmt->bind_param("iis", $userId, $order_id, $notificationMessage);
        $notifStmt->execute();

        // Insert notification into the admin_notifications table
        $adminNotifSql = "INSERT INTO admin_notifications (user_id, order_id, message) VALUES (?, ?, ?)";
        $adminNotifStmt = $conn->prepare($adminNotifSql);
        $adminNotifStmt->bind_param("iis", $userId, $order_id, $notificationMessage);
        $adminNotifStmt->execute();

        $response = array(
            'status' => 'success',
            'message' => 'Client Status Updated Successfully'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Error Updating Client Order: ' . $conn->error
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
