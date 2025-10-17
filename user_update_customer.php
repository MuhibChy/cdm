<?php
// Include your database connection file
include 'conn.php';

// Response array
$response = array();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $customerId = mysqli_real_escape_string($conn, $_POST['customer_id']);
    $companyName = mysqli_real_escape_string($conn, $_POST['company_name']);
    $firstName = mysqli_real_escape_string($conn, $_POST['firstname']);
    $middleInitial = mysqli_real_escape_string($conn, $_POST['middle_initial']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastname']);
    $contactNumber = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $emailAddress = mysqli_real_escape_string($conn, $_POST['email_address']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $cityAddress = mysqli_real_escape_string($conn, $_POST['city_address']);

    // Update query
    $sql = "UPDATE customers SET company_name='$companyName', firstname='$firstName', middle_initial='$middleInitial', lastname='$lastName',
            contact_number='$contactNumber', email_address='$emailAddress', gender='$gender', city_address='$cityAddress' WHERE customer_id='$customerId'";

    if (mysqli_query($conn, $sql)) {
        // If update is successful, send success response
        $response['status'] = 'success';
        $response['message'] = 'Customer updated successfully.';
    } else {
        // If there's an error with the query, send error response
        $response['status'] = 'error';
        $response['message'] = 'Error updating record: ' . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
} else {
    // Invalid request
    $response['status'] = 'error';
    $response['message'] = 'Invalid request.';
}

// Send response as JSON
echo json_encode($response);
?>
