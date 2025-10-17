<?php
// Include your database connection file
include 'conn.php';

// Retrieve date range from POST request
$startDate = isset($_POST['start_date']) ? mysqli_real_escape_string($conn, $_POST['start_date']) : '';
$endDate = isset($_POST['end_date']) ? mysqli_real_escape_string($conn, $_POST['end_date']) : '';

// Initialize the response
$response = '';

// SQL query to fetch all data with date range filter
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

// Execute the query
$result = $conn->query($sql);

// Generate CSV content
$csvContent = "data:text/csv;charset=utf-8,"
    . "Customer Name,Company Name,Customer Type,Order Status,Agent Name\n";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $csvContent .= implode(",", array(
            $row["customer_name"],
            $row["company_name"],
            $row["customer_type"],
            $row["status"],
            $row["agent_name"]
        )) . "\n";
    }
} else {
    $csvContent .= "No records found\n";
}

// Close connection
$conn->close();

// Output the CSV content
echo $csvContent;
?>
