<?php
// fetch_notifications.php

// Include database connection
include 'conn.php';

// Fetch latest notifications
$sql = "SELECT id, message, created_at FROM admin_notifications WHERE status = 'unread' ORDER BY created_at DESC";
$result = $conn->query($sql);

$notifications = array();
while($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

// Prepare response
$response = array(
    'count' => count($notifications),
    'notifications' => $notifications
);

// Return JSON response
echo json_encode($response);

// Close database connection
$conn->close();
?>
