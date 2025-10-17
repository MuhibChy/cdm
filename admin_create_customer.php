<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conn.php';

    $companyName = mysqli_real_escape_string($conn, $_POST['company_name']);
    $firstName = mysqli_real_escape_string($conn, $_POST['firstname']);
    $middleInitial = mysqli_real_escape_string($conn, $_POST['middle_initial']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastname']);
    $contactNumber = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $emailAddress = mysqli_real_escape_string($conn, $_POST['email_address']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $cityAddress = mysqli_real_escape_string($conn, $_POST['city_address']);

    $sql = "INSERT INTO customers (company_name, firstname, middle_initial, lastname, contact_number, email_address, gender, city_address)
            VALUES ('$companyName', '$firstName', '$middleInitial', '$lastName', '$contactNumber', '$emailAddress', '$gender', '$cityAddress')";

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
