<?php
// Include database connection
include 'conn.php';
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Get user ID from session

    // Prepare SQL query to fetch notifications for the specific user
    $sql = "SELECT id, message, created_at FROM notifications WHERE user_id = ? AND status = 'unread' ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $notifications = array();
    while($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    // Prepare response
    $response = array(
        'count' => count($notifications),
        'notifications' => $notifications
    );
} else {
    // Prepare error response if user ID is not provided
    $response = array(
        'status' => 'error',
        'message' => 'User not logged in.'
    );
}

// Return JSON response
echo json_encode($response);

// Close database connection
$conn->close();
?>
