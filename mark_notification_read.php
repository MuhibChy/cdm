<?php
// mark_notification_read.php

// Include database connection
include 'conn.php';

// Get notification ID
$id = $_POST['id'];

// Update notification status
$sql = "UPDATE notifications SET status = 'read' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

// Prepare response
$response = array(
    'status' => 'success'
);

// Return JSON response
echo json_encode($response);

// Close database connection
$conn->close();
?>
