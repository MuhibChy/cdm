<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "cdms";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize response
$response = [];

// Check if manager_id is set and valid
if (isset($_POST['manager_id']) && !empty($_POST['manager_id'])) {
    $manager_id = $conn->real_escape_string($_POST['manager_id']);

    // Prepare SQL query with placeholders
    $sql = "SELECT co.*, c.firstname AS customer_firstname, c.lastname AS customer_lastname
            FROM customer_orders co
            INNER JOIN customers c ON co.customer_id = c.customer_id
            WHERE co.manager_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param('i', $manager_id);
        
        // Execute the statement
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch data
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        }

        // Close statement
        $stmt->close();
    } else {
        $response = ['error' => 'Error preparing the SQL statement'];
    }
} else {
    $response = ['error' => 'Invalid or missing manager_id'];
}

// Close connection
$conn->close();

// Output as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
