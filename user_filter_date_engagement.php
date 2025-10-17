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

    // Validate and sanitize the orderDate input
    $orderDate = $conn->real_escape_string($orderDate);

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT co.order_id, co.customer_id, co.order_date, co.customer_category, co.customer_type, co.order_status, co.reference_number, co.latest_engagement_date, co.remarks, co.uploaded_file, c.company_name, c.firstname, c.middle_initial, c.lastname, c.contact_number, c.email_address, c.gender, c.city_address, sm.firstname AS manager_firstname, sm.lastname AS manager_lastname, sa.firstname AS agent_firstname, sa.lastname AS agent_lastname
        FROM customer_orders co
        INNER JOIN customers c ON co.customer_id = c.customer_id
        LEFT JOIN sales_managers sm ON co.manager_id = sm.manager_id
        LEFT JOIN sales_agents sa ON co.agent_id = sa.agent_id
        WHERE co.order_status = 'Engagement'
        AND DATE(co.latest_engagement_date) = ? AND co.user_id = ?");
    
    // Bind parameters and execute the statement
    $stmt->bind_param('si', $orderDate, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convert latest_engagement_date to 12-hour format with AM/PM
            $latest_engagement_date = !empty($row['latest_engagement_date']) ? date('Y-m-d h:i A', strtotime($row['latest_engagement_date'])) : '';

            echo "<tr>";
            echo "<td style='text-transform:uppercase;'>".$row['reference_number']."</td>";
            echo "<td>".$latest_engagement_date."</td>"; // Display formatted date
            echo "<td>".$row['company_name']."</td>";
            echo "<td style='text-transform: capitalize;'>".$row['firstname']." ".$row['lastname']."</td>";
            echo "<td>".$row['customer_type']."</td>";
            echo "<td><span class='badge xhire-bdblue'>".$row['order_status']."</span></td>";
            echo "<td>";
            echo " 
                <div class='btn-group'>
                    <button type='button' class='btn-xs btn btn-primary' onclick='viewCustomerOrderDetails(".$row['order_id'].")'>View Details</button>
                    <button type='button' class='btn-xs btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>
                        <span class='sr-only'>Toggle Dropdown</span>
                    </button>
                    <div class='dropdown-menu' role='menu'>
                        <a class='dropdown-item' href='#' onclick='fillUpdateCustomerOrder(".$row['order_id'].", \"".$row['reference_number']."\", \"".$row['latest_engagement_date']."\", \"".$row['remarks']."\", \"".$row['uploaded_file']."\", \"".$row['order_status']."\")' data-toggle='modal' data-target='#updateCustomerOrderModal' style='font-size:12px;'>Update Records</a>
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
