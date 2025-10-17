<?php
include 'conn.php';

// Function to sanitize and validate input
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if POST request is made and manager_id is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['manager_id'])) {
    $manager_id = sanitize_input($_POST['manager_id']);

    // Validate manager_id
    if (!filter_var($manager_id, FILTER_VALIDATE_INT)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid manager ID.']);
        exit();
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Set manager_id to NULL for agents managed by the manager
        $sql_update_agents = "UPDATE sales_agents SET manager_id = NULL WHERE manager_id = ?";
        $stmt_update_agents = $conn->prepare($sql_update_agents);
        $stmt_update_agents->bind_param('i', $manager_id);
        $stmt_update_agents->execute();
        $stmt_update_agents->close();

        // Now delete the manager
        $sql_delete_manager = "DELETE FROM sales_managers WHERE manager_id = ?";
        $stmt_delete_manager = $conn->prepare($sql_delete_manager);
        $stmt_delete_manager->bind_param('i', $manager_id);
        $stmt_delete_manager->execute();

        if ($stmt_delete_manager->affected_rows > 0) {
            // Commit transaction
            $conn->commit();
            echo json_encode(['status' => 'success', 'message' => 'Manager deleted successfully.']);
        } else {
            // Rollback transaction if deletion failed
            $conn->rollback();
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete manager.']);
        }

        $stmt_delete_manager->close();
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
