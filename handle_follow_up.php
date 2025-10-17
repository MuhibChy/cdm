<?php
// Include your database connection file
include 'conn.php';

// Response array
$response = array();

// Function to run follow-up notifications
function runFollowUpNotifications() {
    include 'conn.php';
    $filePath = 'follow_up_queue.txt';

    if (file_exists($filePath)) {
        $lines = file($filePath);
        $currentTime = time();

        foreach ($lines as $line) {
            $followUpData = json_decode($line, true);

            if ($followUpData['timestamp'] <= $currentTime) {
                $orderId = $followUpData['order_id'];

                // Insert follow-up notification for admin
                $adminUserId = 1; // Assuming 1 is the admin ID, adjust as needed
                $notificationMessage = "Follow-up needed for Order ID $orderId.";
                $notifSql = "INSERT INTO notifications (user_id, order_id, message, create_at, status, is_follow_up_sent) VALUES ('$adminUserId', '$orderId', '$notificationMessage', NOW(), 'sent', 1)";
                mysqli_query($conn, $notifSql);

                // Remove the processed entry from the queue
                $remainingLines = array_filter(file($filePath), function($line) use ($currentTime, $orderId) {
                    $data = json_decode($line, true);
                    return !($data['timestamp'] <= $currentTime && $data['order_id'] == $orderId);
                });

                file_put_contents($filePath, implode('', $remainingLines));
            }
        }
    }

    mysqli_close($conn);
}

// Run follow-up notifications
runFollowUpNotifications();
?>
