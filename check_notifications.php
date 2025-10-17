<?php
include 'conn.php';
session_start();

// Retrieve user ID
$userId = $_SESSION['user_id'];

// Fetch the count and details of new notifications
$sql = "SELECT COUNT(*) as count, message FROM notifications WHERE user_id = ? AND is_read = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$notifications = array();
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

// Respond with JSON
$response = array(
    'count' => count($notifications),
    'notifications' => $notifications
);

echo json_encode($response);

$stmt->close();
$conn->close();
?>
