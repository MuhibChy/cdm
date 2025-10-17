<?php
// Include your database connection file
include 'conn.php';

// Retrieve date range from POST request
$startDate = isset($_POST['start_date']) ? mysqli_real_escape_string($conn, $_POST['start_date']) : '';
$endDate = isset($_POST['end_date']) ? mysqli_real_escape_string($conn, $_POST['end_date']) : '';

// Initialize the response
$response = '';

// SQL query to fetch data with date range filter
$sql = "SELECT 
            CONCAT(c.firstname, ' ', c.lastname) AS customer_name,
            c.company_name,
            co.customer_type,
            co.order_status AS status,
            CONCAT(sa.firstname, ' ', sa.lastname) AS agent_name
        FROM customers c
        INNER JOIN customer_orders co ON c.customer_id = co.customer_id
        LEFT JOIN sales_agents sa ON co.agent_id = sa.agent_id
        WHERE co.order_status = 'Closed'";

if ($startDate && $endDate) {
    $sql .= " AND co.status_updated_at BETWEEN '$startDate' AND '$endDate'";
}

// Execute the query and handle potential errors
if ($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {
        // Generate table rows
        while ($row = $result->fetch_assoc()) {
            $response .= "<tr>";
            $response .= "<td>" . htmlspecialchars($row["customer_name"], ENT_QUOTES, 'UTF-8') . "</td>";
            $response .= "<td>" . htmlspecialchars($row["company_name"], ENT_QUOTES, 'UTF-8') . "</td>";
            $response .= "<td>" . htmlspecialchars($row["customer_type"], ENT_QUOTES, 'UTF-8') . "</td>";
            $response .= "<td>" . htmlspecialchars($row["status"], ENT_QUOTES, 'UTF-8') . "</td>";
            $response .= "<td>" . htmlspecialchars($row["agent_name"], ENT_QUOTES, 'UTF-8') . "</td>";
            $response .= "</tr>";
        }
    } else {
        $response .= "<tr><td colspan='5'>No records found</td></tr>";
    }
} else {
    // Error handling
    $response .= "<tr><td colspan='5'>Error executing query: " . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8') . "</td></tr>";
}

// Close connection
$conn->close();

// Return the response
echo $response;
?>
