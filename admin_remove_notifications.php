<?php
// remove_notification.php

// Include database connection
include 'conn.php';

// Get notification ID
$id = $_POST['id'];

// Delete notification
$sql = "DELETE FROM notifications WHERE id = ?";
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
