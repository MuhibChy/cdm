<?php
include 'conn.php';
session_start();

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $orderId = mysqli_real_escape_string($conn, $_POST['order_id']);
    
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
    } else {
        $response['status'] = 'error';
        $response['message'] = 'User ID not found.';
        echo json_encode($response);
        exit();
    }

    $checkSql = "SELECT COUNT(*) as count FROM notifications WHERE user_id = '$userId' AND order_id = '$orderId' AND is_follow_up_sent = 1";
    $result = mysqli_query($conn, $checkSql);
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] > 0) {
        $response['status'] = 'info';
        $response['message'] = 'Follow-up notification has already been sent.';
    } else {
        $sql = "INSERT INTO notifications (user_id, order_id, message, notification_sent, is_follow_up_sent) VALUES ('$userId', '$orderId', '$message', 1, 1)";
        
        if (mysqli_query($conn, $sql)) {
            $response['status'] = 'success';
            $response['message'] = 'Follow-up notification sent successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error sending follow-up notification: ' . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request.';
}

echo json_encode($response);
?>
