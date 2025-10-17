<?php
include 'conn.php'; // Include your database connection file

$response = array();
$response['alerts'] = array();
$response['alerts']['proposal'] = false; // Default to no alert for 'Proposal'
$response['alerts']['order'] = false; // Default to no alert for 'Order'
$response['alerts']['payment'] = false; // Default to no alert for 'Payment'
$response['orders'] = array();

// Get the user_id from session
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($user_id === null) {
    $response['error'] = 'User not authenticated';
    echo json_encode($response);
    exit();
}

// Query to get orders with 'proposal' status that have not been updated in the last 5 days
$sqlProposal = "
    SELECT order_id, status_updated_at 
    FROM customer_orders 
    WHERE order_status = 'proposal' 
    AND TIMESTAMPDIFF(DAY, status_updated_at, NOW()) >= 5
    AND user_id = ?
";

$stmt = $conn->prepare($sqlProposal);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$resultProposal = $stmt->get_result();

if ($resultProposal->num_rows > 0) {
    $response['alerts']['proposal'] = true;
    $response['orders']['proposal'] = array();
    while ($row = $resultProposal->fetch_assoc()) {
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
    AND user_id = ?
";

$stmt = $conn->prepare($sqlOrder);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$resultOrder = $stmt->get_result();

if ($resultOrder->num_rows > 0) {
    $response['alerts']['order'] = true;
    $response['orders']['order'] = array();
    while ($row = $resultOrder->fetch_assoc()) {
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
    AND user_id = ?
";

$stmt = $conn->prepare($sqlPayment);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$resultPayment = $stmt->get_result();

if ($resultPayment->num_rows > 0) {
    $response['alerts']['payment'] = true;
    $response['orders']['payment'] = array();
    while ($row = $resultPayment->fetch_assoc()) {
        $response['orders']['payment'][] = array(
            'order_id' => $row['order_id'],
            'transaction_time' => $row['status_updated_at']
        );
    }
}

echo json_encode($response);
?>
