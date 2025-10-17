<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'conn.php';
    
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $middle_initial = mysqli_real_escape_string($conn, $_POST['middle_initial']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);

    $sql = "INSERT INTO sales_managers (firstname, middle_initial, lastname, gender)
            VALUES ('$firstname', '$middle_initial', '$lastname', '$gender')";

    if (mysqli_query($conn, $sql)) {
        $response = [
            'status' => 'success',
            'message' => 'Sales manager created successfully!'
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