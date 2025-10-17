<?php
// fetch_notification_details.php

// Include database connection
include 'conn.php';

// Get notification ID from POST request
$id = $_POST['id'];

// Fetch notification details from the new admin_notifications table
$sql = "SELECT id, message AS content, created_at FROM admin_notifications WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$notification = $result->fetch_assoc();

// Prepare response
$response = array(
    'content' => $notification['content'],
    'created_at' => $notification['created_at']
);

// Return JSON response
echo json_encode($response);

// Close database connection
$conn->close();
?>
