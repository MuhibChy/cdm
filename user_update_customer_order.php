<?php
// Include your database connection file
include 'conn.php';
session_start(); // Start the session to retrieve user ID

// Response array
$response = array();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and escape form data
    $orderId = mysqli_real_escape_string($conn, $_POST['order_id']);
    $latestEngagementDate = mysqli_real_escape_string($conn, $_POST['latest_engagement_date']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $orderStatus = mysqli_real_escape_string($conn, $_POST['order_status']);

    // Initialize file paths
    $uploadedFile = '';
    $uploadedFileCancelled = '';

    // Handle file upload for general file
    if (!empty($_FILES['uploaded_file']['name'])) {
        $targetDirectory = "files/";
        $uploadedFile = basename($_FILES['uploaded_file']['name']);
        $targetFile = $targetDirectory . $uploadedFile;

        if (!move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $targetFile)) {
            $response['status'] = 'error';
            $response['message'] = 'Error uploading file.';
            echo json_encode($response);
            exit();
        }
    }

    // Handle file upload for proof of cancellation
    if (!empty($_FILES['uploaded_file_cancelled']['name'])) {
        $targetDirectory = "files/";
        $uploadedFileCancelled = basename($_FILES['uploaded_file_cancelled']['name']);
        $targetFileCancelled = $targetDirectory . $uploadedFileCancelled;

        if (!move_uploaded_file($_FILES['uploaded_file_cancelled']['tmp_name'], $targetFileCancelled)) {
            $response['status'] = 'error';
            $response['message'] = 'Error uploading proof of cancellation.';
            echo json_encode($response);
            exit();
        }
    }

    // Update status and timestamp
    $statusUpdatedAt = date('Y-m-d H:i:s');

    // Build the SQL query
    $sql = "UPDATE customer_orders 
            SET latest_engagement_date = '$latestEngagementDate', 
                remarks = '$remarks', 
                order_status = '$orderStatus', 
                status_updated_at = '$statusUpdatedAt'";

    if ($uploadedFile) {
        $sql .= ", uploaded_file = '$uploadedFile'";
    }

    if ($uploadedFileCancelled) {
        $sql .= ", uploaded_file_cancelled = '$uploadedFileCancelled'";
    }

    $sql .= " WHERE order_id = '$orderId'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        if ($orderStatus == 'Engagement') {
            // Insert notification into notifications table
            $userId = $_SESSION['user_id']; // Use the user ID from session
            $notificationMessage = "Information About Client, Transaction Number: $orderId Has Been Updated and Moved to Engagement Status.";

            // Insert into notifications table
            $notifSql = "INSERT INTO notifications (user_id, order_id, message) VALUES ('$userId', '$orderId', '$notificationMessage')";
            mysqli_query($conn, $notifSql);

            // Insert into admin_notifications table
            $adminNotifSql = "INSERT INTO admin_notifications (user_id, order_id, message) VALUES ('$userId', '$orderId', '$notificationMessage')";
            mysqli_query($conn, $adminNotifSql);
        }

        $response['status'] = 'success';
        $response['message'] = 'Client Status Updated Successfully';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error Updating Client Order: ' . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}

// Return the response as JSON
echo json_encode($response);
?>
