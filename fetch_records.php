<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "cdms"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize arrays to store data
$dates = array();
$leadsGeneration = array();
$engagement = array();
$proposal = array();
$order = array();
$payment = array();
$delivery = array();

// Query to fetch data for each category per day
$sql = "SELECT DATE(order_date) AS order_date,
               SUM(CASE WHEN order_status = 'Leads Generation' THEN 1 ELSE 0 END) AS leads_generation,
               SUM(CASE WHEN order_status = 'Engagement' THEN 1 ELSE 0 END) AS engagement,
               SUM(CASE WHEN order_status = 'Proposal' THEN 1 ELSE 0 END) AS proposal,
               SUM(CASE WHEN order_status = 'Order' THEN 1 ELSE 0 END) AS order_count,
               SUM(CASE WHEN order_status = 'Payment' THEN 1 ELSE 0 END) AS payment,
               SUM(CASE WHEN order_status = 'Delivery' THEN 1 ELSE 0 END) AS delivery
        FROM customer_orders
        WHERE order_date BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW()
        GROUP BY DATE(order_date)
        ORDER BY order_date ASC";

if ($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dates[] = $row['order_date'];
            $leadsGeneration[] = (int) $row['leads_generation'];
            $engagement[] = (int) $row['engagement'];
            $proposal[] = (int) $row['proposal'];
            $order[] = (int) $row['order_count'];
            $payment[] = (int) $row['payment'];
            $delivery[] = (int) $row['delivery'];
        }
    } else {
        // Handle case where no results are found
        $dates[] = "No data";
        $leadsGeneration[] = 0;
        $engagement[] = 0;
        $proposal[] = 0;
        $order[] = 0;
        $payment[] = 0;
        $delivery[] = 0;
    }
} else {
    // Error handling
    $dates[] = "Error";
    $leadsGeneration[] = 0;
    $engagement[] = 0;
    $proposal[] = 0;
    $order[] = 0;
    $payment[] = 0;
    $delivery[] = 0;
}

// Close connection
$conn->close();

// Prepare data to be JSON encoded
$data = array(
    'dates' => $dates,
    'leadsGeneration' => $leadsGeneration,
    'engagement' => $engagement,
    'proposal' => $proposal,
    'order' => $order,
    'payment' => $payment,
    'delivery' => $delivery
);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
