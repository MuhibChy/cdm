<?php
include 'conn.php';

// Set content type for proper output handling
header('Content-Type: text/html; charset=utf-8');

// Check if manager_id is set and not empty
if (isset($_POST['manager_id']) && !empty($_POST['manager_id'])) {
    $manager_id = $_POST['manager_id'];

    // Prepare and execute SQL query
    $sql = "SELECT * FROM sales_agents WHERE manager_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $manager_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Output options
        echo '<option value="">Select Sales Agent</option>';
        while ($row = $result->fetch_assoc()) {
            $agent_id = htmlspecialchars($row['agent_id'], ENT_QUOTES, 'UTF-8');
            $firstname = htmlspecialchars($row['firstname'], ENT_QUOTES, 'UTF-8');
            $lastname = htmlspecialchars($row['lastname'], ENT_QUOTES, 'UTF-8');
            echo "<option value='$agent_id'>$firstname $lastname</option>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "Invalid manager ID.";
}

// Close connection
$conn->close();
?>
