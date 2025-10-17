<?php
// Include your connection file (conn.php or any connection setup)
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Query to fetch customer order details including customer, sales manager, and sales agent
    $sql = "SELECT co.order_id, co.order_date, co.customer_category, co.customer_type, co.order_status,
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
        ?>
        <div class="row">
            <div class="col-md-6">
                <h5 style="font-size: 15px; font-weight: bold; text-transform: uppercase;">Order Details</h5>
                <p style="font-size: 12px;"><strong>Order ID:</strong> <?php echo $row['order_id']; ?></p>
                <p style="font-size: 12px;"><strong>Order Date:</strong> <?php echo $row['order_date']; ?></p>
                <p style="font-size: 12px;"><strong>Customer Category:</strong> <?php echo $row['customer_category']; ?></p>
                <p style="font-size: 12px;"><strong>Customer Type:</strong> <?php echo $row['customer_type']; ?></p>
                <p style="font-size: 12px;"><strong>Order Status:</strong> <?php echo $row['order_status']; ?></p>
            </div>
            <div class="col-md-6">
                <h5 style="font-size: 15px; font-weight: bold; text-transform: uppercase;">Customer Details</h5>
                <p style="font-size: 12px;"><strong>Name:</strong> <?php echo $row['firstname'].' '.$row['lastname']; ?></p>
                <p style="font-size: 12px;"><strong>Contact Number:</strong> <?php echo $row['contact_number']; ?></p>
                <p style="font-size: 12px;"><strong>Email Address:</strong> <?php echo $row['email_address']; ?></p>
                <p style="font-size: 12px;"><strong>Gender:</strong> <?php echo $row['gender']; ?></p>
                <p style="font-size: 12px;"><strong>City Address:</strong> <?php echo $row['city_address']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h5 style="font-size: 15px; font-weight: bold; text-transform: uppercase;">Sales Manager Details</h5>
                <p style="font-size: 12px;"><strong>Name:</strong> <?php echo $row['manager_firstname'].' '.$row['manager_lastname']; ?></p>
            </div>
            <div class="col-md-6">
                <h5 style="font-size: 15px; font-weight: bold; text-transform: uppercase;">Sales Agent Details</h5>
                <p style="font-size: 12px;"><strong>Name:</strong> <?php echo $row['agent_firstname'].' '.$row['agent_lastname']; ?></p>
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
?>
