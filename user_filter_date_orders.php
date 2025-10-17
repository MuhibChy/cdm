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
    $sql = "SELECT co.order_id, co.reference_number, co.user_id, co.date_of_sales_order_creation, c.company_name, CONCAT(c.firstname, ' ', c.lastname) AS customer_name, co.customer_type, co.order_status, co.payment_reference_number, co.sales_order_reference_number, co.payment_remarks, co.warehouse_email, c.company_name, c.firstname, c.middle_initial, c.lastname, c.contact_number, c.email_address, c.gender
            FROM customer_orders co
            INNER JOIN customers c ON co.customer_id = c.customer_id
            WHERE co.order_status = 'Order'
            AND DATE(co.date_of_sales_order_creation) = '$orderDate'
            AND co.user_id = $user_id"; // Filter by selected date and user ID

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convert datetime to 12-hour format with AM/PM
            $date_of_sales_order_creation = date('Y-m-d h:i A', strtotime($row['date_of_sales_order_creation']));

            echo "<tr>";
                echo "<td style='text-transform: uppercase;'>".$row['reference_number']."</td>";
                echo "<td>".$date_of_sales_order_creation."</td>"; // Display formatted date and time
                echo "<td>".$row['company_name']."</td>";
                echo "<td style='text-transform: capitalize;'>".$row['firstname']." ".$row['lastname']."</td>";
                echo "<td>".$row['customer_type']."</td>";
                echo "<td><span class='badge xhire-bdyellow'>".$row['order_status']."</span></td>";
                echo "<td>";
                echo "<div class='btn-group'>";
                echo "<button type='button' class='btn-xs btn btn-primary' onclick='viewCustomerOrderDetails(".$row['order_id'].")'>View Details</button>";
                echo "<button type='button' class='btn-xs btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>";
                echo "<span class='sr-only'>Toggle Dropdown</span>";
                echo "</button>";
                echo "<div class='dropdown-menu' role='menu'>";
                echo "<a class='dropdown-item' href='#' onclick='fillUpdateCustomerOrder(".$row['order_id'].", \"".$row['payment_reference_number']."\", \"".$row['sales_order_reference_number']."\", \"".$row['payment_remarks']."\", \"".$row['warehouse_email']."\", \"".$row['order_status']."\")' data-toggle='modal' data-target='#updateCustomerOrderModal' style='font-size:12px;'>Update Records</a>";
                echo "</div>";
                echo "</div>";
                echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No customer orders found for the selected date</td></tr>";
    }
} else {
    echo "<tr><td colspan='7'>No date selected</td></tr>";
}
?>
