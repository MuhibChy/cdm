<?php
include 'conn.php'; // Ensure your database connection script is included

if (isset($_POST['orderDate'])) {
    $orderDate = $_POST['orderDate'];

    // Prepare the query with a placeholder
    $stmt = $conn->prepare("
        SELECT co.order_id, co.reference_number, co.date_of_sales_order_creation, c.company_name, 
               CONCAT(c.firstname, ' ', c.lastname) AS customer_name, co.customer_type, co.order_status
        FROM customer_orders co
        INNER JOIN customers c ON co.customer_id = c.customer_id
        WHERE DATE(co.date_of_sales_order_creation) = ? AND co.order_status = 'Order'
    ");
    $stmt->bind_param('s', $orderDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Escape data for HTML output
            $reference_number = htmlspecialchars($row['reference_number'], ENT_QUOTES, 'UTF-8');
            $order_date = htmlspecialchars($row['date_of_sales_order_creation'], ENT_QUOTES, 'UTF-8');
            $company_name = htmlspecialchars($row['company_name'], ENT_QUOTES, 'UTF-8');
            $customer_name = htmlspecialchars($row['customer_name'], ENT_QUOTES, 'UTF-8');
            $customer_type = htmlspecialchars($row['customer_type'], ENT_QUOTES, 'UTF-8');
            $order_status = htmlspecialchars($row['order_status'], ENT_QUOTES, 'UTF-8');
            $order_id = htmlspecialchars($row['order_id'], ENT_QUOTES, 'UTF-8');

            echo "<tr>";
            echo "<td>$reference_number</td>";
            echo "<td>$order_date</td>";
            echo "<td>$company_name</td>";
            echo "<td>$customer_name</td>";
            echo "<td>$customer_type</td>";
            echo "<td><span class='badge bg-navy'>$order_status</span></td>";
            echo "<td>";
            echo "<div class='btn-group'>";
            echo "<button type='button' class='btn-xs btn btn-primary' onclick='viewCustomerOrderDetails($order_id)'>View Details</button>";
            echo "</div>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No customer orders found for the selected date</td></tr>";
    }

    $stmt->close();
} else {
    echo "<tr><td colspan='7'>No date selected</td></tr>";
}

$conn->close();
?>
