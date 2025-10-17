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

    // Query to fetch customer orders with customer details based on the selected date
    $sql = "SELECT co.order_id, co.customer_id, co.user_id, co.order_date, co.customer_category, co.customer_type, co.order_status, co.reference_number, co.latest_engagement_date, co.remarks, co.uploaded_file, c.company_name, c.firstname, c.middle_initial, c.lastname, c.contact_number, c.email_address, c.gender, c.city_address, sm.firstname AS manager_firstname, sm.lastname AS manager_lastname, 
                    sa.firstname AS agent_firstname, sa.lastname AS agent_lastname
            FROM customer_orders co
            INNER JOIN customers c ON co.customer_id = c.customer_id
            LEFT JOIN sales_managers sm ON co.manager_id = sm.manager_id
            LEFT JOIN sales_agents sa ON co.agent_id = sa.agent_id
            WHERE co.order_status = 'Leads Generation'
            AND DATE(co.order_date) = '$orderDate'
            AND co.user_id = $user_id"; // Filter by selected date and user ID
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['reference_number']."</td>";
            echo "<td>".$row['order_date']."</td>";
            echo "<td>".$row['customer_category']."</td>";
            echo "<td>".$row['customer_type']."</td>";
            echo "<td>".$row['company_name']."</td>";
            echo "<td>".$row['firstname']." ".$row['lastname']."</td>";
            echo "<td><span class='badge bg-navy'>".$row['order_status']."</span></td>";
            echo "<td>";
            echo "<div class='btn-group'>";
            echo "<button type='button' class='btn-xs btn btn-primary' onclick='viewCustomerOrderDetails(".$row['order_id'].")'>View Details</button>";
            echo "<button type='button' class='btn-xs btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>";
            echo "<span class='sr-only'>Toggle Dropdown</span>";
            echo "</button>";
            echo "<div class='dropdown-menu' role='menu'>";
            echo "<a class='dropdown-item' href='#' onclick='fillUpdateForm(".$row['order_id'].", \"".$row['reference_number']."\", \"".$row['order_date']."\", \"".$row['remarks']."\", \"".$row['uploaded_file']."\", \"".$row['order_status']."\")' data-toggle='modal' data-target='#updateCustomerOrderModal' style='font-size:12px;'>Update Records</a>";
            echo "</div>";
            echo "</div>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No customer orders found for the selected date</td></tr>";
    }
} else {
    echo "<tr><td colspan='8'>No date selected</td></tr>";
}
?>
