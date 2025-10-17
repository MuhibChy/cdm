<?php
include 'conn.php';

// Initialize response
$response = [];

// Sanitize and validate input
$manager_id = isset($_GET['manager_id']) ? (int) $_GET['manager_id'] : 0;

if ($manager_id > 0) {
    // Fetch manager details
    $sql = "SELECT * FROM sales_managers WHERE manager_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $manager_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $manager = $result->fetch_assoc();
        $stmt->close();
    } else {
        $response['error'] = 'Error preparing statement for manager details.';
    }

    // Fetch agents managed by the manager
    $sql_agents = "SELECT * FROM sales_agents WHERE manager_id = ?";
    if ($stmt_agents = $conn->prepare($sql_agents)) {
        $stmt_agents->bind_param('i', $manager_id);
        $stmt_agents->execute();
        $result_agents = $stmt_agents->get_result();
        $agents = [];
        while ($row = $result_agents->fetch_assoc()) {
            $agents[] = $row;
        }
        $stmt_agents->close();
    } else {
        $response['error'] = 'Error preparing statement for agents details.';
    }

    // Add data to response
    $response['manager'] = isset($manager) ? $manager : null;
    $response['agents'] = $agents;
} else {
    $response['error'] = 'Invalid or missing manager_id.';
}

// Close connection
$conn->close();

// Output as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
