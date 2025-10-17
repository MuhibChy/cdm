<?php
include 'conn.php'; // Include your database connection script

session_start(); // Ensure session is started

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables from form inputs
    $order_id = $_POST['order_id'];
    $delivery_reference_number = $_POST['delivery_reference_number'];
    $delivery_date = $_POST['delivery_date'];
    $delivery_remarks = $_POST['delivery_remarks'];
    $order_status = $_POST['order_status'];
    $reason_cancelled = isset($_POST['reason_cancelled']) ? $_POST['reason_cancelled'] : '';

    // Initialize file variables
    $uploaded_file_cancelled = '';

    if ($order_status == 'Cancelled') {
        // Handle file upload for Proof of Cancellation
        if (!empty($_FILES['uploaded_file_cancelled']['name'])) {
            $target_dir = "files/"; // Use 'files' directory
            $uploaded_file_cancelled = basename($_FILES["uploaded_file_cancelled"]["name"]);
            $target_file = $target_dir . $uploaded_file_cancelled;

            // Check if file was uploaded without errors
            if (!move_uploaded_file($_FILES["uploaded_file_cancelled"]["tmp_name"], $target_file)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Error uploading file.'
                );
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }
        }
    }

    // Update timestamp
    $statusUpdatedAt = date('Y-m-d H:i:s'); // Current time

    // Prepare SQL statement to update customer order details
    $sql = "";
    if ($order_status == 'Delivery') {
        $sql = "UPDATE customer_orders SET 
                    delivery_reference_number = '$delivery_reference_number', 
                    delivery_date = '$delivery_date', 
                    delivery_remarks = '$delivery_remarks', 
                    order_status = '$order_status',
                    status_updated_at = '$statusUpdatedAt' 
                WHERE order_id = $order_id";

        // Insert notification into the database
        $userId = $_SESSION['user_id']; // Get the actual user ID from session
        $notificationMessage = "Information About Client, Transaction Number: $order_id Has Been Updated and Moved to Delivery Status.";
        $notifSql = "INSERT INTO notifications (user_id, order_id, message) VALUES (?, ?, ?)";
        $notifStmt = $conn->prepare($notifSql);
        $notifStmt->bind_param("iis", $userId, $order_id, $notificationMessage);
        $notifStmt->execute();

        // Insert notification into the database
        $userId = $_SESSION['user_id']; // Get the actual user ID from session
        $notificationMessage = "Information About Client, Transaction Number: $order_id Has Been Updated and Moved to Delivery Status.";
        $notifSql = "INSERT INTO admin_notifications (user_id, order_id, message) VALUES (?, ?, ?)";
        $notifStmt = $conn->prepare($notifSql);
        $notifStmt->bind_param("iis", $userId, $order_id, $notificationMessage);
        $notifStmt->execute();

    } elseif ($order_status == 'Cancelled') {
        $sql = "UPDATE customer_orders SET 
                    order_status = '$order_status', 
                    reason_cancelled = '$reason_cancelled', 
                    uploaded_file_cancelled = '$uploaded_file_cancelled',
                    status_updated_at = '$statusUpdatedAt' 
                WHERE order_id = $order_id";

        // Insert notification into the database
        $userId = $_SESSION['user_id']; // Get the actual user ID from session
        $notificationMessage = "Information About Client, Transaction Number: $order_id Has Been Cancelled. Reason: $reason_cancelled";
        $notifSql = "INSERT INTO notifications (user_id, order_id, message) VALUES (?, ?, ?)";
        $notifStmt = $conn->prepare($notifSql);
        $notifStmt->bind_param("iis", $userId, $order_id, $notificationMessage);
        $notifStmt->execute();
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Invalid order status'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Execute the query
    if ($conn->query($sql) === TRUE) {
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
