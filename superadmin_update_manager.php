<?php
// Include your database connection file
include 'conn.php';

// Response array
$response = array();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security

    $updateManagerId = mysqli_real_escape_string($conn, $_POST['manager_id']);
    $updateManagerFirstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $updateManagerMiddleInitial = mysqli_real_escape_string($conn, $_POST['middle_initial']);
    $updateManagerLastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $updateManagerGender = mysqli_real_escape_string($conn, $_POST['gender']);

    // Update query
    $sql = "UPDATE sales_managers SET firstname='$updateManagerFirstname', middle_initial='$updateManagerMiddleInitial', lastname='$updateManagerLastname', gender='$updateManagerGender' WHERE manager_id='$updateManagerId'";        

    if (mysqli_query($conn, $sql)) {
        // If update is successful, send success response
        $response['status'] = 'success';
        $response['message'] = 'Sales manager updated successfully!';
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
