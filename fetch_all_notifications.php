<?php
// Include database connection
include 'conn.php';
session_start();

// Check if user ID is available in the session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Get user ID from session

    // Fetch all notifications for the specific user
    $sql = "SELECT id, message, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $notifications = array();
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    // Prepare response
    $response = $notifications;
} else {
    // User ID not available in session
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
