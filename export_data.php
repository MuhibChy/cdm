<?php
// Include your database connection file
include 'conn.php';

// Retrieve date range and customer type from POST request
$startDate = isset($_POST['start_date']) ? mysqli_real_escape_string($conn, $_POST['start_date']) : '';
$endDate = isset($_POST['end_date']) ? mysqli_real_escape_string($conn, $_POST['end_date']) : '';
$customerType = isset($_POST['customer_type']) ? mysqli_real_escape_string($conn, $_POST['customer_type']) : '';

// SQL query to fetch data with date range filter and customer type filter
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

if ($customerType) {
    $sql .= " AND co.customer_type = '$customerType'";
}

// Execute the query
$result = $conn->query($sql);

// Generate CSV content
$csvContent = "Customer Name,Company Name,Customer Type,Order Status,Agent Name\n";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Escape fields that contain commas, quotes, or new lines
        $customer_name = str_replace('"', '""', $row["customer_name"]);
        $company_name = str_replace('"', '""', $row["company_name"]);
        $customer_type = str_replace('"', '""', $row["customer_type"]);
        $status = str_replace('"', '""', $row["status"]);
        $agent_name = str_replace('"', '""', $row["agent_name"]);

        // Concatenate values into CSV format
        $csvContent .= "\"$customer_name\",\"$company_name\",\"$customer_type\",\"$status\",\"$agent_name\"\n";
    }
} else {
    $csvContent .= "No records found\n";
}

// Close connection
$conn->close();

// Output the CSV content
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="customer_orders_export.csv"');
echo $csvContent;
?>
