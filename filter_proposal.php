<?php
include 'conn.php'; // Ensure your database connection script is included

// Check if the orderDate is set in the POST request
if (isset($_POST['orderDate'])) {
    $orderDate = $_POST['orderDate'];

    // Prepare the query with placeholders
    $stmt = $conn->prepare("
        SELECT co.order_id, co.customer_id, co.order_date, co.customer_category, co.customer_type, 
               co.order_status, co.reference_number, co.latest_engagement_date, co.date_qtn_sent, 
               co.quotation_reference_number, co.proposal_remarks, co.remarks, co.uploaded_file, 
               c.company_name, c.firstname, c.middle_initial, c.lastname, c.contact_number, 
               c.email_address, c.gender, c.city_address, 
               sm.firstname AS manager_firstname, sm.lastname AS manager_lastname, 
               sa.firstname AS agent_firstname, sa.lastname AS agent_lastname
        FROM customer_orders co
        INNER JOIN customers c ON co.customer_id = c.customer_id
        LEFT JOIN sales_managers sm ON co.manager_id = sm.manager_id
        LEFT JOIN sales_agents sa ON co.agent_id = sa.agent_id
        WHERE co.order_status = 'Proposal'
        AND DATE(co.date_qtn_sent) = ?
    ");
    $stmt->bind_param('s', $orderDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Escape data for HTML output
            $quotation_reference_number = htmlspecialchars($row['quotation_reference_number'], ENT_QUOTES, 'UTF-8');
            $date_qtn_sent = htmlspecialchars($row['date_qtn_sent'], ENT_QUOTES, 'UTF-8');
            $company_name = htmlspecialchars($row['company_name'], ENT_QUOTES, 'UTF-8');
            $firstname = htmlspecialchars($row['firstname'], ENT_QUOTES, 'UTF-8');
            $lastname = htmlspecialchars($row['lastname'], ENT_QUOTES, 'UTF-8');
            $customer_type = htmlspecialchars($row['customer_type'], ENT_QUOTES, 'UTF-8');
            $order_status = htmlspecialchars($row['order_status'], ENT_QUOTES, 'UTF-8');
            $order_id = htmlspecialchars($row['order_id'], ENT_QUOTES, 'UTF-8');

            echo "<tr>";
            echo "<td>$quotation_reference_number</td>";
            echo "<td>$date_qtn_sent</td>";
            echo "<td>$company_name</td>";
            echo "<td>$firstname $lastname</td>";
            echo "<td>$customer_type</td>";
            echo "<td><span class='badge btn-danger'>$order_status</span></td>";
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
