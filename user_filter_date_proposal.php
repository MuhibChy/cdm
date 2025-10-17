<?php
include 'conn.php'; // Ensure your database connection script is included

// Start the session to access session variables
session_start();

// Check if the user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['orderDate'])) {
    $orderDate = $_POST['orderDate'];

    // Prepare the SQL statement to avoid SQL injection
    $sql = "SELECT co.order_id, co.customer_id, co.user_id, co.order_date, co.customer_category, co.customer_type, co.order_status, 
                   co.reference_number, co.latest_engagement_date, co.date_qtn_sent, co.quotation_reference_number, co.proposal_remarks, 
                   co.remarks, co.uploaded_file, c.company_name, c.firstname, c.middle_initial, c.lastname, c.contact_number, c.email_address, 
                   c.gender, c.city_address, sm.firstname AS manager_firstname, sm.lastname AS manager_lastname, 
                   sa.firstname AS agent_firstname, sa.lastname AS agent_lastname
            FROM customer_orders co
            INNER JOIN customers c ON co.customer_id = c.customer_id
            LEFT JOIN sales_managers sm ON co.manager_id = sm.manager_id
            LEFT JOIN sales_agents sa ON co.agent_id = sa.agent_id
            WHERE co.order_status = 'Proposal'
            AND DATE(co.date_qtn_sent) = ?
            AND co.user_id = ?";

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $orderDate, $user_id);

    // Execute and get the result
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convert datetime to 12-hour format with AM/PM
            $date_qtn_sent = date('Y-m-d h:i A', strtotime($row['date_qtn_sent']));

            echo "<tr>";
            echo "<td style='text-transform: uppercase;'>".htmlspecialchars($row['quotation_reference_number'])."</td>";
            echo "<td>".htmlspecialchars($date_qtn_sent)."</td>"; // Display formatted date
            echo "<td>".htmlspecialchars($row['company_name'])."</td>";
            echo "<td style='text-transform: capitalize;'>".htmlspecialchars($row['firstname'])." ".htmlspecialchars($row['lastname'])."</td>";
            echo "<td>".htmlspecialchars($row['customer_type'])."</td>";
            echo "<td><span class='badge xhire-bdred'>".htmlspecialchars($row['order_status'])."</span></td>";
            echo "<td>";
            echo "<div class='btn-group'>";
            echo "<button type='button' class='btn-xs btn btn-primary' onclick='viewCustomerOrderDetails(".htmlspecialchars($row['order_id']).")'>View Details</button>";
            echo "<button type='button' class='btn-xs btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>";
            echo "<span class='sr-only'>Toggle Dropdown</span>";
            echo "</button>";
            echo "<div class='dropdown-menu' role='menu'>";
            echo "<a class='dropdown-item' href='#' onclick='fillUpdateCustomerOrder(".htmlspecialchars($row['order_id']).", \"".htmlspecialchars($row['reference_number'])."\", \"".htmlspecialchars($row['latest_engagement_date'])."\", \"".htmlspecialchars($row['remarks'])."\", \"".htmlspecialchars($row['uploaded_file'])."\", \"".htmlspecialchars($row['order_status'])."\")' data-toggle='modal' data-target='#updateCustomerOrderModal' style='font-size:12px;'>Update Records</a>";
            echo "</div>";
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
