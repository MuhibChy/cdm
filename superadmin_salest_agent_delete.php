<?php
// Include database connection
include 'conn.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if there's a POST request for agent_id
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agent_id'])) {
    $agentId = $_POST['agent_id'];

    // Prepare SQL query to delete the agent based on agent_id
    $sql = "DELETE FROM sales_agents WHERE agent_id = ?";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("i", $agentId);

        // Execute statement
        if ($stmt->execute()) {
            // Success
            echo json_encode(array("status" => "success", "message" => "Sales agent deleted successfully!"));
        } else {
            // Error
            echo json_encode(array("status" => "error", "message" => "Failed to delete agent."));
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
