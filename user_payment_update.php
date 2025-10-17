<?php
include 'conn.php'; // Include your database connection script

session_start(); // Ensure session is started

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables from form inputs
    $order_id = $_POST['order_id'];
    $payment_reference_number = $_POST['payment_reference_number'];
    $payment_date = $_POST['payment_date'];
    $payment_remarks = $_POST['payment_remarks'];
    $warehouse_email = $_POST['warehouse_email'];
    $order_status = $_POST['order_status'];
    $cancellation_reason = $_POST['cancellation_reason'];

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

    // Prepare SQL query based on order status
    if ($order_status == 'Payment') {
        $sql = "UPDATE customer_orders SET 
                payment_reference_number = '$payment_reference_number',
                payment_date = '$payment_date',
                payment_remarks = '$payment_remarks',
                warehouse_email = '$warehouse_email',
                order_status = '$order_status',
                status_updated_at = '$statusUpdatedAt'
                WHERE order_id = $order_id";

        // Insert notification into the database
        $userId = $_SESSION['user_id']; // Get the actual user ID from session
        $notificationMessage = "Information About Client, Transaction Number: $order_id Has Been Updated and Moved to Payment Status.";
        $notifSql = "INSERT INTO notifications (user_id, order_id, message) VALUES (?, ?, ?)";
        $notifStmt = $conn->prepare($notifSql);
        $notifStmt->bind_param("iis", $userId, $order_id, $notificationMessage);
        $notifStmt->execute();

        // Insert notification into the database
        $userId = $_SESSION['user_id']; // Get the actual user ID from session
        $notificationMessage = "Information About Client, Transaction Number: $order_id Has Been Updated and Moved to Payment Status.";
        $notifSql = "INSERT INTO admin_notifications (user_id, order_id, message) VALUES (?, ?, ?)";
        $notifStmt = $conn->prepare($notifSql);
        $notifStmt->bind_param("iis", $userId, $order_id, $notificationMessage);
        $notifStmt->execute();

    } elseif ($order_status == 'Cancelled') {
        $sql = "UPDATE customer_orders SET 
                order_status = '$order_status',
                reason_cancelled = '$cancellation_reason',
                uploaded_file_cancelled = '$uploaded_file_cancelled',
                status_updated_at = '$statusUpdatedAt'
                WHERE order_id = $order_id";

        // Insert notification into the database
        $userId = $_SESSION['user_id']; // Get the actual user ID from session
        $notificationMessage = "Information About Client, Transaction Number: $order_id Has Been Cancelled. Reason: $cancellation_reason";
        $notifSql = "INSERT INTO notifications (user_id, order_id, message) VALUES (?, ?, ?)";
        $notifStmt = $conn->prepare($notifSql);
        $notifStmt->bind_param("iis", $userId, $order_id, $notificationMessage);
        $notifStmt->execute();
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
