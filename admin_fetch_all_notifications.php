<?php
// fetch_all_notifications.php

// Include database connection
include 'conn.php';

// Fetch all notifications from the admin_notifications table
$sql = "SELECT id, message AS content, created_at FROM admin_notifications ORDER BY created_at DESC";
$result = $conn->query($sql);

$notifications = array();
while($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

// Prepare response
$response = array(
    'notifications' => $notifications
);

// Return JSON response
echo json_encode($response);

// Close database connection
$conn->close();
?>
