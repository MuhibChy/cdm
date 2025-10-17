<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'conn.php';

    // Collect and sanitize input
    $firstname = $_POST['firstname'];
    $middle_initial = $_POST['middle_initial'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $manager_id = $_POST['manager_id'];

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("INSERT INTO sales_agents (firstname, middle_initial, lastname, gender, manager_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $middle_initial, $lastname, $gender, $manager_id);

    if ($stmt->execute()) {
        $response = [
            'status' => 'success',
            'message' => 'Sales Agent created successfully!'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'There was an error creating the sales agent.',
            'error' => $stmt->error
        ];
    }

    $stmt->close();
    $conn->close();

    echo json_encode($response);
    exit();
}
?>
