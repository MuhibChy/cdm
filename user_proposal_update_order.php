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
    $quotation_reference_number = $_POST['quotation_reference_number'];
    $date_qtn_sent = $_POST['date_qtn_sent'];
    $order_status = $_POST['order_status'];
    $proposal_remarks = $_POST['proposal_remarks'];
    $reason_cancelled = $_POST['reason_cancelled'];

    // Handle file upload for Proof of Cancellation
    $uploaded_file_cancelled = '';
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
                'message' => 'Error uploading file. Please check file permissions and upload settings.'
            );
            echo json_encode($response);
            exit;
        }
    }

    // Update timestamp
    $statusUpdatedAt = date('Y-m-d H:i:s'); // Current time

    // Prepare SQL query based on order status
    if ($order_status == 'Proposal') {
        $sql = "UPDATE customer_orders SET 
                quotation_reference_number = '$quotation_reference_number',
                date_qtn_sent = '$date_qtn_sent',
                order_status = '$order_status',
                proposal_remarks = '$proposal_remarks',
                status_updated_at = '$statusUpdatedAt'
                WHERE order_id = $order_id";
        
        // If update is successful and status is 'Proposal'
        if ($conn->query($sql) === TRUE) {
            // Insert notification into the database
            $userId = $_SESSION['user_id']; // Use the user ID from session
            $notificationMessage = "Information About Client, Transaction Number: $order_id Has Been Updated and Moved to Proposal Status.";
            $notifSql = "INSERT INTO notifications (user_id, order_id, message) VALUES ('$userId', '$order_id', '$notificationMessage')";
            mysqli_query($conn, $notifSql);

            $userId = $_SESSION['user_id']; // Use the user ID from session
            $notificationMessage = "Information About Client, Transaction Number: $order_id Has Been Updated and Moved to Proposal Status.";
            $notifSql = "INSERT INTO admin_notifications (user_id, order_id, message) VALUES ('$userId', '$order_id', '$notificationMessage')";
            mysqli_query($conn, $notifSql);

            $response = array(
                'status' => 'success',
                'message' => 'Client Status Updated Successfully'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Error Updating Client order: ' . $conn->error
            );
        }
    } elseif ($order_status == 'Cancelled') {
        $sql = "UPDATE customer_orders SET 
                order_status = '$order_status',
                reason_cancelled = '$reason_cancelled',
                uploaded_file_cancelled = '$uploaded_file_cancelled',
                status_updated_at = '$statusUpdatedAt' 
                WHERE order_id = $order_id";
        
        if ($conn->query($sql) === TRUE) {
            // Insert notification into the database
            $userId = $_SESSION['user_id']; // Use the user ID from session
            $notificationMessage = "Information About Client, Transaction Number: $order_id Has Been Cancelled.";
            $notifSql = "INSERT INTO notifications (user_id, order_id, message) VALUES ('$userId', '$order_id', '$notificationMessage')";
            mysqli_query($conn, $notifSql);

            $response = array(
                'status' => 'success',
                'message' => 'Client Status Updated Successfully'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Error Updating Client order: ' . $conn->error
            );
        }
    }

    // Close database connection
    $conn->close();

    // Return JSON response to JavaScript
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
