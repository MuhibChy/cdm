<?php
// Include database connection
include 'conn.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if there's a POST request for user_id
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $userId = intval($_POST['user_id']); // Ensure user_id is an integer

    // Prepare SQL query to delete the user based on user_id
    $sql = "DELETE FROM users WHERE user_id = ?";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("i", $userId);

        // Execute statement
        if ($stmt->execute()) {
            // Success
            echo json_encode(array("status" => "success", "message" => "User deleted successfully!"));
        } else {
            // Error
            echo json_encode(array("status" => "error", "message" => "Failed to delete user."));
        }

        // Close statement
        $stmt->close();
    } else {
        // Prepare statement error
        echo json_encode(array("status" => "error", "message" => "Failed to prepare SQL statement."));
    }

    // Close connection
    $conn->close();
} else {
    // Invalid request
    echo json_encode(array("status" => "error", "message" => "Invalid request."));
}
?>
