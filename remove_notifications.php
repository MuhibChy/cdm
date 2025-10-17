<?php
// Include database connection
include 'conn.php';
session_start();

// Check if user ID is available in the session
if (isset($_SESSION['user_id']) && isset($_POST['id'])) {
    $userId = $_SESSION['user_id']; // Get user ID from session
    $notificationId = mysqli_real_escape_string($conn, $_POST['id']);

    // Check if the notification belongs to the user
    $sql = "SELECT id FROM notifications WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $notificationId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Notification exists for this user, proceed with deletion
        $sql = "DELETE FROM notifications WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $notificationId);
        $stmt->execute();

        // Prepare response
        $response = array(
            'status' => 'success'
        );
    } else {
        // Notification does not belong to user
        $response = array(
            'status' => 'error',
            'message' => 'Notification not found or access denied.'
        );
    }
} else {
    // Missing parameters or user not logged in
    $response = array(
        'status' => 'error',
        'message' => 'User not logged in or missing parameters.'
    );
}

// Return JSON response
echo json_encode($response);

// Close database connection
$conn->close();
?>
