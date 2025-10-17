<?php
include 'conn.php'; // Ensure your database connection script is included

if (isset($_POST['orderDate'])) {
    $orderDate = $_POST['orderDate'];

    // Prepare and execute query to fetch customer orders with customer details based on the selected date
    $stmt = $conn->prepare("
        SELECT co.order_id, co.delivery_reference_number, co.delivery_date, c.company_name, CONCAT(c.firstname, ' ', c.lastname) AS customer_name, co.customer_type, co.order_status
        FROM customer_orders co
        INNER JOIN customers c ON co.customer_id = c.customer_id
        WHERE DATE(co.delivery_date) = ? AND order_status = 'Delivery'
    ");
    $stmt->bind_param('s', $orderDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".htmlspecialchars($row['delivery_reference_number'], ENT_QUOTES, 'UTF-8')."</td>";
            echo "<td>".htmlspecialchars($row['delivery_date'], ENT_QUOTES, 'UTF-8')."</td>";
            echo "<td>".htmlspecialchars($row['company_name'], ENT_QUOTES, 'UTF-8')."</td>";
            echo "<td>".htmlspecialchars($row['customer_name'], ENT_QUOTES, 'UTF-8')."</td>";
            echo "<td>".htmlspecialchars($row['customer_type'], ENT_QUOTES, 'UTF-8')."</td>";
            echo "<td>".htmlspecialchars($row['order_status'], ENT_QUOTES, 'UTF-8')."</td>";
            echo "<td>";
            echo "<div class='btn-group'>";
            echo "<button type='button' class='btn-xs btn btn-primary' onclick='viewCustomerOrderDetails(".htmlspecialchars($row['order_id'], ENT_QUOTES, 'UTF-8').")'>View Details</button>";
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
