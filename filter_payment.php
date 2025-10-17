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

    // Prepare the query with placeholders
    $stmt = $conn->prepare("
        SELECT co.order_id, co.reference_number, co.payment_date, c.company_name, 
               CONCAT(c.firstname, ' ', c.lastname) AS customer_name, co.customer_type, 
               co.order_status, co.payment_reference_number, co.sales_order_reference_number, 
               co.payment_remarks, co.warehouse_email, c.firstname, c.middle_initial, 
               c.lastname, c.contact_number, c.email_address, c.gender, c.city_address
        FROM customer_orders co
        INNER JOIN customers c ON co.customer_id = c.customer_id
        WHERE co.order_status = 'Payment'
        AND DATE(co.payment_date) = ? 
        AND co.user_id = ?
    ");
    $stmt->bind_param('si', $orderDate, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convert datetime to 12-hour format with AM/PM
            $payment_date = date('Y-m-d h:i A', strtotime($row['payment_date']));

            // Escape data for HTML output
            $payment_reference_number = htmlspecialchars($row['payment_reference_number'], ENT_QUOTES, 'UTF-8');
            $sales_order_reference_number = htmlspecialchars($row['sales_order_reference_number'], ENT_QUOTES, 'UTF-8');
            $payment_remarks = htmlspecialchars($row['payment_remarks'], ENT_QUOTES, 'UTF-8');
            $warehouse_email = htmlspecialchars($row['warehouse_email'], ENT_QUOTES, 'UTF-8');
            $company_name = htmlspecialchars($row['company_name'], ENT_QUOTES, 'UTF-8');
            $firstname = htmlspecialchars($row['firstname'], ENT_QUOTES, 'UTF-8');
            $lastname = htmlspecialchars($row['lastname'], ENT_QUOTES, 'UTF-8');
            $customer_type = htmlspecialchars($row['customer_type'], ENT_QUOTES, 'UTF-8');
            $order_status = htmlspecialchars($row['order_status'], ENT_QUOTES, 'UTF-8');
            $order_id = htmlspecialchars($row['order_id'], ENT_QUOTES, 'UTF-8');

            echo "<tr>";
            echo "<td style='text-transform:uppercase;'>$payment_reference_number</td>";
            echo "<td>$payment_date</td>"; // Display formatted date and time
            echo "<td>$company_name</td>";
            echo "<td style='text-transform:capitalize;'>$firstname $lastname</td>";
            echo "<td>$customer_type</td>";
            echo "<td><span class='badge xhire-bdorange'>$order_status</span></td>";
            echo "<td>";
            echo "<div class='btn-group'>";
            echo "<button type='button' class='btn-xs btn btn-primary' onclick='viewCustomerOrderDetails($order_id)'>View Details</button>";
            echo "<button type='button' class='btn-xs btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>";
            echo "<span class='sr-only'>Toggle Dropdown</span>";
            echo "</button>";
            echo "<div class='dropdown-menu' role='menu'>";
            echo "<a class='dropdown-item' href='#' onclick='fillUpdateCustomerOrder($order_id, \"$payment_reference_number\", \"$sales_order_reference_number\", \"$payment_remarks\", \"$warehouse_email\", \"$order_status\")' data-toggle='modal' data-target='#updateCustomerOrderModal' style='font-size:12px;'>Update Records</a>";
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
