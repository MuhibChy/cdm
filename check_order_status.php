<?php
include 'conn.php'; // Include your database connection file

$response = array();
$response['alerts'] = array();
$response['alerts']['proposal'] = false; // Default to no alert for 'Proposal'
$response['alerts']['order'] = false; // Default to no alert for 'Order'
$response['alerts']['payment'] = false; // Default to no alert for 'Payment'
$response['orders'] = array();

// Query to get orders with 'proposal' status that have not been updated in the last 5 days
$sqlProposal = "
    SELECT order_id, status_updated_at 
    FROM customer_orders 
    WHERE order_status = 'proposal' 
    AND TIMESTAMPDIFF(DAY, status_updated_at, NOW()) >= 5
";

$resultProposal = mysqli_query($conn, $sqlProposal);

if (mysqli_num_rows($resultProposal) > 0) {
    $response['alerts']['proposal'] = true;
    $response['orders']['proposal'] = array();
    while ($row = mysqli_fetch_assoc($resultProposal)) {
        $response['orders']['proposal'][] = array(
            'order_id' => $row['order_id'],
            'transaction_time' => $row['status_updated_at']
        );
    }
}

// Query to get orders with 'Order' status that have not been updated in the last 7 days
$sqlOrder = "
    SELECT order_id, status_updated_at 
    FROM customer_orders 
    WHERE order_status = 'Order' 
    AND TIMESTAMPDIFF(DAY, status_updated_at, NOW()) >= 7
";

$resultOrder = mysqli_query($conn, $sqlOrder);

if (mysqli_num_rows($resultOrder) > 0) {
    $response['alerts']['order'] = true;
    $response['orders']['order'] = array();
    while ($row = mysqli_fetch_assoc($resultOrder)) {
        $response['orders']['order'][] = array(
            'order_id' => $row['order_id'],
            'transaction_time' => $row['status_updated_at']
        );
    }
}

// Query to get orders with 'payment' status that have not been updated in the last 3 days
$sqlPayment = "
    SELECT order_id, status_updated_at 
    FROM customer_orders 
    WHERE order_status = 'payment' 
    AND TIMESTAMPDIFF(DAY, status_updated_at, NOW()) >= 3
";

$resultPayment = mysqli_query($conn, $sqlPayment);

if (mysqli_num_rows($resultPayment) > 0) {
    $response['alerts']['payment'] = true;
    $response['orders']['payment'] = array();
    while ($row = mysqli_fetch_assoc($resultPayment)) {
        $response['orders']['payment'][] = array(
            'order_id' => $row['order_id'],
            'transaction_time' => $row['status_updated_at']
        );
    }
}

echo json_encode($response);
?>
