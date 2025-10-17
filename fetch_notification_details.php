<?php
// Include database connection
include 'conn.php';
session_start();

// Check if notification ID is provided
if (isset($_POST['id'])) {
    $notificationId = mysqli_real_escape_string($conn, $_POST['id']);
    $userId = $_SESSION['user_id']; // Get user ID from session

    // Prepare SQL query to fetch notification details for the specific user
    $sql = "SELECT id, title, message, created_at FROM notifications WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $notificationId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $notification = $result->fetch_assoc();

    if ($notification) {
        // Prepare response
        $response = array(
            'title' => $notification['title'],
            'content' => $notification['message'],
            'created_at' => $notification['created_at']
        );
    } else {
        // Notification not found or doesn't belong to user
        $response = array(
            'status' => 'error',
            'message' => 'Notification not found or access denied.'
        );
    }
} else {
    // Missing parameters
    $response = array(
        'status' => 'error',
        'message' => 'Missing parameters.'
    );
}

// Return JSON response
echo json_encode($response);

// Close database connection
$conn->close();
?>
