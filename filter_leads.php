<?php
include 'conn.php'; // Ensure your database connection script is included

if (isset($_POST['orderDate'])) {
    $orderDate = $_POST['orderDate'];

    // Prepare the query with placeholders
    $stmt = $conn->prepare("
        SELECT co.order_id, co.customer_id, co.order_date, co.customer_category, co.customer_type, co.order_status, co.reference_number, co.latest_engagement_date, co.remarks, co.uploaded_file, 
               c.company_name, c.firstname, c.middle_initial, c.lastname, c.contact_number, c.email_address, c.gender, c.city_address, 
               sm.firstname AS manager_firstname, sm.lastname AS manager_lastname, 
               sa.firstname AS agent_firstname, sa.lastname AS agent_lastname
        FROM customer_orders co
        INNER JOIN customers c ON co.customer_id = c.customer_id
        LEFT JOIN sales_managers sm ON co.manager_id = sm.manager_id
        LEFT JOIN sales_agents sa ON co.agent_id = sa.agent_id
        WHERE co.order_status = 'Leads Generation'
        AND DATE(co.order_date) = ?
    ");
    $stmt->bind_param('s', $orderDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Escape data for HTML output
            $reference_number = htmlspecialchars($row['reference_number'], ENT_QUOTES, 'UTF-8');
            $order_date = htmlspecialchars($row['order_date'], ENT_QUOTES, 'UTF-8');
            $customer_category = htmlspecialchars($row['customer_category'], ENT_QUOTES, 'UTF-8');
            $customer_type = htmlspecialchars($row['customer_type'], ENT_QUOTES, 'UTF-8');
            $company_name = htmlspecialchars($row['company_name'], ENT_QUOTES, 'UTF-8');
            $customer_name = htmlspecialchars($row['firstname'] . ' ' . $row['lastname'], ENT_QUOTES, 'UTF-8');
            $order_status = htmlspecialchars($row['order_status'], ENT_QUOTES, 'UTF-8');
            $order_id = htmlspecialchars($row['order_id'], ENT_QUOTES, 'UTF-8');
            $remarks = htmlspecialchars($row['remarks'], ENT_QUOTES, 'UTF-8');
            $uploaded_file = htmlspecialchars($row['uploaded_file'], ENT_QUOTES, 'UTF-8');

            echo "<tr>";
            echo "<td>$reference_number</td>";
            echo "<td>$order_date</td>";
            echo "<td>$customer_category</td>";
            echo "<td>$customer_type</td>";
            echo "<td>$company_name</td>";
            echo "<td>$customer_name</td>";
            echo "<td><span class='badge bg-navy'>$order_status</span></td>";
            echo "<td>";
            echo " 
                <div class='btn-group'>
                    <button type='button' class='btn-xs btn btn-primary' onclick='viewCustomerOrderDetails($order_id)'>View Details</button>
                    <button type='button' class='btn-xs btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>
                        <span class='sr-only'>Toggle Dropdown</span>
                    </button>
                    <div class='dropdown-menu' role='menu'>
                        <a class='dropdown-item' href='#' onclick='fillUpdateCustomerOrder($order_id, \"$reference_number\", \"$order_date\", \"$remarks\", \"$uploaded_file\", \"$order_status\")' data-toggle='modal' data-target='#updateCustomerOrderModal' style='font-size:12px;'>Update Records</a>
                    </div>
                </div>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No customer orders found for the selected date</td></tr>";
    }

    $stmt->close();
} else {
    echo "<tr><td colspan='8'>No date selected</td></tr>";
}

$conn->close();
?>
