<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conn.php';

    //Specific User ID Account
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

    $order_date = mysqli_real_escape_string($conn, $_POST['order_date']);
    $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
    $customer_category = mysqli_real_escape_string($conn, $_POST['customer_category']);
    $customer_type = mysqli_real_escape_string($conn, $_POST['customer_type']);
    $order_status = mysqli_real_escape_string($conn, $_POST['order_status']);
    $manager_id = mysqli_real_escape_string($conn, $_POST['manager_id']);
    $agent_id = mysqli_real_escape_string($conn, $_POST['agent_id']);
    $reference_number = mysqli_real_escape_string($conn, $_POST['reference_number']);

    $sql = "INSERT INTO customer_orders (order_date, customer_id, customer_category, customer_type, order_status, manager_id, agent_id, reference_number, user_id)
            VALUES ('$order_date', '$customer_id', '$customer_category', '$customer_type', '$order_status', '$manager_id', '$agent_id', '$reference_number', $user_id)";

    if (mysqli_query($conn, $sql)) {
        $response = [
            'status' => 'success',
            'message' => 'Customer successfully created!'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'There was an error creating the customer.',
            'error' => mysqli_error($conn)
        ];
    }

    mysqli_close($conn);

    echo json_encode($response);
    exit();
}
?>
