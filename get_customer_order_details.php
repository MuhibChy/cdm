<?php
// Include your connection file (conn.php or any connection setup)
include 'conn.php';

// Start the session if needed
// session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Prepare the query with a placeholder for security
    $sql = "SELECT co.order_id, co.reference_number, co.order_date, co.customer_category, co.customer_type, co.order_status,
                   c.firstname, c.middle_initial, c.lastname, c.contact_number, c.email_address, c.gender, c.city_address,
                   sm.firstname AS manager_firstname, sm.lastname AS manager_lastname,
                   sa.firstname AS agent_firstname, sa.lastname AS agent_lastname
            FROM customer_orders co
            INNER JOIN customers c ON co.customer_id = c.customer_id
            LEFT JOIN sales_managers sm ON co.manager_id = sm.manager_id
            LEFT JOIN sales_agents sa ON co.agent_id = sa.agent_id
            WHERE co.order_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Escape data for HTML output
        $reference_number = htmlspecialchars($row['reference_number'], ENT_QUOTES, 'UTF-8');
        $order_date = htmlspecialchars($row['order_date'], ENT_QUOTES, 'UTF-8');
        $customer_category = htmlspecialchars($row['customer_category'], ENT_QUOTES, 'UTF-8');
        $customer_type = htmlspecialchars($row['customer_type'], ENT_QUOTES, 'UTF-8');
        $order_status = htmlspecialchars($row['order_status'], ENT_QUOTES, 'UTF-8');
        $customer_name = htmlspecialchars($row['firstname'] . ' ' . $row['lastname'], ENT_QUOTES, 'UTF-8');
        $contact_number = htmlspecialchars($row['contact_number'], ENT_QUOTES, 'UTF-8');
        $email_address = htmlspecialchars($row['email_address'], ENT_QUOTES, 'UTF-8');
        $gender = htmlspecialchars($row['gender'], ENT_QUOTES, 'UTF-8');
        $city_address = htmlspecialchars($row['city_address'], ENT_QUOTES, 'UTF-8');
        $manager_name = htmlspecialchars($row['manager_firstname'] . ' ' . $row['manager_lastname'], ENT_QUOTES, 'UTF-8');
        $agent_name = htmlspecialchars($row['agent_firstname'] . ' ' . $row['agent_lastname'], ENT_QUOTES, 'UTF-8');

        // Output the details
        ?>
        <div class="row">
            <div class="col-md-6">
                <h5 style="font-size: 15px; font-weight: bold; text-transform: uppercase;">Order Details</h5>
                <p style="font-size: 12px;"><strong>Reference Number:</strong> <?php echo $reference_number; ?></p>
                <p style="font-size: 12px;"><strong>Order Date:</strong> <?php echo $order_date; ?></p>
                <p style="font-size: 12px;"><strong>Customer Category:</strong> <?php echo $customer_category; ?></p>
                <p style="font-size: 12px;"><strong>Customer Type:</strong> <?php echo $customer_type; ?></p>
                <p style="font-size: 12px;"><strong>Order Status:</strong> <?php echo $order_status; ?></p>
            </div>
            <div class="col-md-6">
                <h5 style="font-size: 15px; font-weight: bold; text-transform: uppercase;">Customer Details</h5>
                <p style="font-size: 12px;"><strong>Name:</strong> <?php echo $customer_name; ?></p>
                <p style="font-size: 12px;"><strong>Contact Number:</strong> <?php echo $contact_number; ?></p>
                <p style="font-size: 12px;"><strong>Email Address:</strong> <?php echo $email_address; ?></p>
                <p style="font-size: 12px;"><strong>Gender:</strong> <?php echo $gender; ?></p>
                <p style="font-size: 12px;"><strong>City Address:</strong> <?php echo $city_address; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h5 style="font-size: 15px; font-weight: bold; text-transform: uppercase;">Sales Manager Details</h5>
                <p style="font-size: 12px;"><strong>Name:</strong> <?php echo $manager_name; ?></p>
            </div>
            <div class="col-md-6">
                <h5 style="font-size: 15px; font-weight: bold; text-transform: uppercase;">Sales Agent Details</h5>
                <p style="font-size: 12px;"><strong>Name:</strong> <?php echo $agent_name; ?></p>
            </div>
        </div>
        <?php
    } else {
        echo "No details found for this order.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
